function postComment(vid, commentContent, fromChannel) {
<<<<<<< HEAD
	ajax.post('video/' + vid, {'commentSubmit': 'lol', 'comment-content': commentContent, 'from-channel': fromChannel});
=======
	marmottajax.post({
		'url': '../comments/',
		'options': {'commentSubmit': 'lol', 'comment-content': commentContent, 'from-channel': fromChannel, 'video-id': vid}
	}).then(function(result) {
		var comment = JSON.parse(result);

		var commentDiv = document.createElement('div');
			commentDiv.className = 'comment';

			var headDiv = document.createElement('div');
				headDiv.className = 'comment-head';

				var userDiv = document.createElement('div');
					userDiv.className = 'user';

					var avatar = document.createElement('img');
					avatar.setAttribute('src', '../assets/img/avatar_user.png'); //TODO: Use channel's avatar

					var a = document.createElement('a');
					a.setAttribute('href', '#'); //TODO: Use channel's avatar

					var username = document.createTextNode(comment.author);
					a.appendChild(username);

					userDiv.appendChild(avatar);
					userDiv.appendChild(a);

				headDiv.appendChild(userDiv);


				var dateDiv = document.createElement('div');
					dateDiv.className = 'date';

					var p = document.createElement('p');
					var date = document.createTextNode(comment.relativeTime);

					p.appendChild(date);
					dateDiv.appendChild(p);

				headDiv.appendChild(dateDiv);

			commentDiv.appendChild(headDiv);

			var textDiv = document.createElement('div');
				textDiv.className = 'comment-text';

				var p1 = document.createElement('p');
				var text = document.createTextNode(comment.comment);
				
				p1.appendChild(text);
				textDiv.appendChild(p1);

			commentDiv.appendChild(textDiv);

			var noteDiv = document.createElement('div');
				noteDiv.className = 'comment-notation';

					var ul = document.createElement('ul');

						var li1 = document.createElement('li');
						var li2 = document.createElement('li');

						li1.className = 'plus';
						li2.className = 'moins';

						li1.id = 'plus-' + comment.id;
						li2.id = 'moins-' + comment.id;

						li1.setAttribute('onclick', "likeComment('" + comment.id + "')");
						li2.setAttribute('onclick', "dislikeComment('" + comment.id + "')");;

						var plusText = document.createTextNode('+');
						li1.appendChild(plusText);

						var moinsText = document.createTextNode('-');
						li2.appendChild(moinsText);

						var plusNumber = document.createTextNode('0');
						li1.appendChild(plusNumber);

						var moinsNumber = document.createTextNode('0');
						li2.appendChild(moinsNumber);

						ul.appendChild(li1);
						ul.appendChild(li2);

					noteDiv.appendChild(ul);

			commentDiv.appendChild(noteDiv);

		document.getElementById('comments-best').appendChild(commentDiv);
	});
}

function likeComment(commentId) {
	marmottajax.get({
		'url': '../comments/' + commentId + '/like',
		'options': {}
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
	marmottajax.get({
		'url': '../comments/' + commentId + '/dislike',
		'options': {}
	}).then(function(result) {
		try {
			var comment = JSON.parse(result);

			document.getElementById('plus-' + comment.id).innerHTML = '+' + comment.likes;
			document.getElementById('moins-' + comment.id).innerHTML = '-' + comment.dislikes;
		}
		catch(e) {}
	});
>>>>>>> dreamvids-2.0-dev
}