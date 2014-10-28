function likeComment(commentId) {
	marmottajax.put({
		'url': _webroot_ + 'comments/' + commentId,
		'options': { like: true }
	}).then(function(result) {
		try {
			var comment = JSON.parse(result);

			document.getElementById('plus-' + comment.id).innerHTML = '+' + comment.likes;
			document.getElementById('moins-' + comment.id).innerHTML = '-' + comment.dislikes;
		}
		catch(e) {}
	});
}

function dislikeComment(commentId) {
	marmottajax.put({
		'url': _webroot_ + 'comments/' + commentId,
		'options': { dislike: true }
	}).then(function(result) {
		try {
			var comment = JSON.parse(result);

			document.getElementById('plus-' + comment.id).innerHTML = '+' + comment.likes;
			document.getElementById('moins-' + comment.id).innerHTML = '-' + comment.dislikes;
		}
		catch(e) {}
	});
}

function reportComment(commentId, reportElement) {
	if(confirm('Ce commentaire sera envoyé aux moderateurs. Voulez-vous continuer ?')) {
		marmottajax.put({
			'url': _webroot_ + 'comments/' + commentId,
			'options': { flag: true }
		}).then(function(result) {
			reportElement.innerHTML = 'Commentaire reporté. Merci.';
		});
	}
}