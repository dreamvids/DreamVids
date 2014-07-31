function unFlagVideo(vidId) {
	marmottajax.put({
		url: '../videos/' + vidId,
		options: { flag: false }
	}).then(function(result) {
		window.location.reload();
	});
}

function suspendVideo(vidId) {
	marmottajax.put({
		url: '../videos/' + vidId,
		options: { suspend: true }
	}).then(function(result) {
		window.location.reload();
	});
}

function unSuspendVideo(vidId) {
	marmottajax.put({
		url: '../videos/' + vidId,
		options: { suspend: false }
	}).then(function(result) {
		window.location.reload();
	});
}

function eraseVideo(vidId) {
	if(confirm("Voulez-vous vraiment effacer cette video DEFINITIVEMENT ?")) {
		marmottajax.delete({
			url: '../videos/' + vidId,
			options: {}
		}).then(function(result) {
			window.location.reload();
		});
	}
}



function unflagComment(commentId) {
	marmottajax.put({
		url: '../comments/' + commentId,
		options: { flag: false }
	}).then(function(result) {
		window.location.reload();
	});
}

function eraseComment(commentId) {
	if(confirm("Voulez-vous vraiment effacer ce commentaire DEFINITIVEMENT ?")) {
		marmottajax.delete({
			url: '../comments/' + commentId,
			options: {}
		}).then(function(result) {
			//window.location.reload();
		});
	}
}