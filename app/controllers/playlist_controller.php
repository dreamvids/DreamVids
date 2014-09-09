<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'playlist.php';

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
			return Utils::getNotFoundResponse();
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
		if (Session::isActive() ) {
			$req = $request->getParameters();
			$playlist = Playlist::find($req['playlist_id']);
			if (Playlist::exists($req['playlist_id']) && UserChannel::find(Playlist::find($req['playlist_id'])->channel_id)->belongToUser(Session::get()->id)) {
				$videos = json_decode($playlist->video);
				switch ($req['action']) {
					case 'add':
						$videos[] = $req['video_id'];
						break;
					
					case 'remove':
						foreach ($videos as $key => $value) {
							if ($key == $req['video_id']) {
								unset($videos[$key]);
							}
						}
						break;
				}
				$playlist->video = json_encode($videos);
				$playlist->save();
			}
		}
	}

	public function destroy($id, $request) {

	}

}