
function addVideoToPlaylist(playlistid, vidid) {

	marmottajax.put({

		url: _webroot_ + "playlists/" + playlistid,

		options: {

			action: "add",
			video_id: vidid

		}

	});

}

function removeVideoFromPlaylist(playlistid, vidid) {

	marmottajax.put({

		url: _webroot_ + "playlists/" + playlistid,

		options: {

			action: "remove",
			video_id: vidid

		}

	});

}

function erasePlaylist(id) {

	if (confirm("Êtes-vous sur de vouloir supprimer cette playlist ? Cela n'effacera pas physiquement les vidéos qu'elle contient.")) {

		marmottajax.delete({

			url: _webroot_ + "playlists/" + id,

		}).then(function() {

			window.location.reload();

		});

	}

}