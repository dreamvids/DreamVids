function unFlagVideo(vidId) {
	if(confirm("Voulez-vous annuler le report de cette video ?")) {
		marmottajax.put({
			url: '../videos/' + vidId,
			options: { flag: false }
		}).then(function(result) {
			window.location.reload();
		});
	}
}

function suspendVideo(vidId) {
	if(confirm("Voulez-vous vraiment suspendre cette video ?")) {
		marmottajax.put({
			url: '../videos/' + vidId,
			options: { suspend: true }
		}).then(function(result) {
			window.location.reload();
		});
	}
}

function unSuspendVideo(vidId) {
	if(confirm("Voulez-vous vraiment annuler la suspension de cette video ?")) {
		marmottajax.put({
			url: '../videos/' + vidId,
			options: { suspend: false }
		}).then(function(result) {
			window.location.reload();
		});
	}
}

function eraseVideo(vidId) {
	if(confirm("Voulez-vous vraiment effacer cette video DEFINITIVEMENT ?")) {
		marmottajax.delete({
			url: '../../videos/' + vidId,
			options: {}
		}).then(function(result) {
			window.location.reload();
		});
	}
}



function unflagComment(commentId) {
	if(confirm("Voulez-vous vraiment annuler le report de ce commentaire ?")) {
		marmottajax.put({
			url: '../comments/' + commentId,
			options: { flag: false }
		}).then(function(result) {
			window.location.reload();
		});
	}
}

function eraseComment(commentId) {
	if(confirm("Voulez-vous vraiment effacer ce commentaire DEFINITIVEMENT ?")) {
		marmottajax.delete({
			url: '../comments/' + commentId,
			options: {}
		}).then(function(result) {
			window.location.reload();
		});
	}
}

function setToDiscover(vidId) {
	if(confirm('Voulez-vous vraiment mettre cette vidéo on avant sur la page d\'accueil ?')) {
		marmottajax.put({
			url: '../videos/' + vidId,
			options: { discover: true }
		}).then(function(result) {
			document.location.href = '../';
		});
	}
}