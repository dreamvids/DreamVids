function unFlagVideo(vidId) {
	if(confirm("Voulez-vous annuler le report de cette video ?")) {
		$.ajax({
			type: "PUT",
			url: _webroot_ + 'videos/' + vidId,
			data: { flag: false },
			success: function(result) {
				window.location.reload();
			}
		});
	}
}

function flagVideo(vidId) {
	if(confirm("Voulez-vous report cette video ?")) {
		$.ajax({
			type: "PUT",
			url: _webroot_ + 'videos/' + vidId,
			data: { flag: true },
			success: function(result) {
				window.location.reload();
			}
		});
	}
}

function suspendVideo(vidId) {
	if(confirm("Voulez-vous vraiment suspendre cette video ?")) {
		$.ajax({
			type: "PUT",
			url: _webroot_ + 'videos/' + vidId,
			data: { suspend: true },
			success: function(result) {
				window.location.reload();
			}
		});
	}
}

function unSuspendVideo(vidId) {
	if(confirm("Voulez-vous vraiment annuler la suspension de cette video ?")) {
		$.ajax({
			type: "PUT",
			url: _webroot_ + 'videos/' + vidId,
			data: { suspend: false },
			success: function(result) {
				window.location.reload();
			}
		});
	}
}

function eraseVideo(vidId) {
	if(confirm("Voulez-vous vraiment effacer cette video DEFINITIVEMENT ?")) {
		$.ajax({
			type: "DELETE",
			url: _webroot_ + 'videos/' + vidId,
			data: {},
			success: function(result) {
				window.location.reload();
			}
		});
	}
}



function unflagComment(commentId) {
	if(confirm("Voulez-vous vraiment annuler le report de ce commentaire ?")) {
		$.ajax({
			type: "PUT",
			url: _webroot_ + 'comments/' + commentId,
			data: { flag: false },
			success: function(result) {
				window.location.reload();
			}
		});
	}
}

function eraseComment(commentId) {
	if(confirm("Voulez-vous vraiment effacer ce commentaire DEFINITIVEMENT ?")) {
		$.ajax({
			type: "DELETE",
			url: _webroot_ + 'comments/' + commentId,
			data: {},
			success: function(result) {
				window.location.reload();
			}
		});
	}
}