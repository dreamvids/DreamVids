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
		
	}

	public function get($id, $request) {
		$playlist = Playlist::exists($id) ? Playlist::find($id) : false;

		if(is_object($playlist)) {
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
				$data = array();

				$data['id'] = $playlist->id;
				$data['name'] = $playlist->name;
				$data['author'] = $playlistAuthor;
				$data['videos'] = $playlistVideos;
				$data['timestamp'] = $playlist->timestamp;

				return new ViewResponse('playlist/playlist', $data);
			}
		}
		else {
			return Utils::getNotFoundResponse();
		}
	}

	public function create($request) {

	}

	public function update($id, $request) {

	}

	public function destroy($id, $request) {

	}

}