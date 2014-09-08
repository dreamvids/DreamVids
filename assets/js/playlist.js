
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

	console.log("Add video \"" + vidid + "\" to playlist \"" + playlistid + "\"");

}

function removeVideoFromPlaylist(playlistid, vidid) {

	console.log("Remove video \"" + vidid + "\" from playlist \"" + playlistid + "\"");
	
}