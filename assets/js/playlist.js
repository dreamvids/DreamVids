
function createPlaylist(name, callback) {

	console.log("Create Playlist \"" + name + "\"");

	marmottajax.post({

	    url: '../playlists',
	    json: true,

	    options: {

	        name: name

	    }

	}).then(function(callback) {

	    return function(result) {

	        callback(result.name, result.id)

	    }

	}(callback)).error(function(error) {

		console.error("Erreur lors de la création de la playlist", error);

	});

}

function addVideoToPlaylist(playlistid, vidid) {
	marmottajax.put({
		'url': _webroot_+'playlists/'+playlistid,
		'options': {
			action: 'add',
			video_id: vidid
		}
	});
}

function removeVideoFromPlaylist(playlistid, vidid) {
	marmottajax.put({
		url: _webroot_+'playlists/'+playlistid,
		options: {
			action: 'remove',
			video_id: vidid
		}
	});
}

function erasePlaylist(playlistid) {
	if (confirm('Êtes-vous sur de vouloir supprimer cette playlist ? Cela n\'effacera pas physiquement les vidéos qu\'elle contient.')) {
		marmottajax.destroy({
			url: 'playlists/'+playlistid,
		}).then(function(result) {
			window.location.reload();
		});
	}
}