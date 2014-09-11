<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'playlist.php';

require_once CONTROLLER.'video_controller.php';

class PlaylistController extends Controller {

	public function __construct() {}
	
	public function index($request) {
		if (Session::isActive()) {
			$data = array();
			$data['playlists'] = array();
			$data['channels'] = Session::get()->getOwnedChannels();
			foreach ($data['channels'] as $chan) {
				$data['playlists'][$chan->id] = Playlist::all(array('conditions' => array('channel_id = ?', $chan->id), 'order' => 'timestamp desc'));
			}
			
			return new ViewResponse('playlists/playlists', $data);
		}
		else {
			return new RedirectResponse(WEBROOT);
		}
	}

	public function get($id, $request) {
		$playlist = Playlist::exists($id) ? Playlist::find($id) : false;

		$playlistAuthor = $playlist->getAuthor();
		$playlistVideos = $playlist->getVideos();

		if($request->acceptsJson()) {
			$videosData = array();

			foreach($playlistVideos as $video) {
				$videosData[] = array(
					'id' => $video->id,
					'title' => $video->title,
					'author' => $video->poster_id,
					'description' => $video->description,
					'views' => $video->views,
					'likes' => $video->likes,
					'dislikes' => $video->dislikes
				);
			}

			$playlistData = array(
				'id' => $playlist->id,
				'name' => $playlist->name,
				'author' => array(
					'id' => $playlistAuthor->id,
					'name' => $playlistAuthor->name
				),
				'videos' => $videosData,
				'timestamp' => $playlist->timestamp
			);
			
			return new JsonResponse($playlistData);
		}
		else {
			header('location:'.WEBROOT.'playlists/'.$id.'/watch');
			exit();
		}
	}

	public function create($request) {
		if (Session::isActive()) {
			$req = $request->getParameters();
			$resp = $this->index($request);
			if ($req['name'] != '' && $req['channel_id'] != '') {
				if (UserChannel::exists($req['channel_id'])) {
					if (UserChannel::find($req['channel_id'])->belongToUser(Session::get()->id)) {
						if (!Playlist::exists(array('conditions' => array('name = ? AND channel_id = ?', $req['name'], $req['channel_id'])))) {
							Playlist::create(array(
								'name' => $req['name'],
								'channel_id' => $req['channel_id'],
								'videos_ids' => json_encode(array()),
								'timestamp' => Utils::tps() 
							));
							// Oui cette ligne est dupliquée mais ce n'est pas une erreur, ne pas supprimer SVP
								$resp = $this->index($request);
							$resp->addMessage(ViewMessage::success('Playlist ajoutée avec succès !'));
						}
						else {
							$resp->addMessage(ViewMessage::error('Une playlist du même nom existe déjà sur cette chaîne.'));
						}
					}
					else {
						$resp->addMessage(ViewMessage::error('Cette chaîne ne vous appartient pas.'));
					}
				}
				else {
					$resp->addMessage(ViewMessage::error('Cette chaîne n\'existe pas !'));
				}
			}
			else {
				$resp->addMessage(ViewMessage::error('Merci de remplir tous les champs'));
			}
		}
		return $resp;
	}

	public function update($id, $request) {
		if (Session::isActive()) {
			$req = $request->getParameters();
			$playlist = Playlist::find($id);
			if (Playlist::exists($id) && UserChannel::find(Playlist::find($id)->channel_id)->belongToUser(Session::get()->id)) {
				$videos = json_decode($playlist->videos_ids);
				switch ($req['action']) {
					case 'add':
						if (!in_array($req['video_id'], $videos)) {
							$videos[] = $req['video_id'];
						}
						break;
					
					case 'remove':
						if (in_array($req['video_id'], $videos)) {
							$key = array_search($req['video_id'], $videos);
							unset($videos[$key]);
						}
						break;
				}
				$playlist->videos_ids = json_encode($videos);
				$playlist->save();
				
				return new JsonResponse(array('ok'));
			}
			else {
				return new Response(500);
			}
		}
		else {
			return new Response(500);
		}
	}

	public function destroy($id, $request) {
		if (Session::isActive() && UserChannel::find(Playlist::find($id)->channel_id)->belongToUser(Session::get()->id)) {
			Playlist::find($id)->delete();
			Playlist::delete_all(array('conditions' => 'id = ?'), $id);
			return new Response(200);
		}
		else {
			ob_clean();
			return new Response(500);
		}
	}
	
	public function watch($parameters, $request) {
		$playlist_id = $parameters[1];
		
		if (Playlist::exists($playlist_id) ) {
			$playlist = Playlist::find($playlist_id);
			
			if (isset($parameters[3])) {
				$video_id = $parameters[3];
			}
			else {
				$video_id = json_decode($playlist->videos_ids);
				$video_id = $video_id[0];
			}
			
			if (in_array($video_id, json_decode($playlist->videos_ids))) {
				$resp = new VideoController();
				return $resp->get($video_id, $request, $playlist);
			}
			else {
				return new Response(500);
			}
		}
		else {
			return new Response(500);
		}
	}

}