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

function deleteComment(commentId, deleteElement) {
	if(confirm('Voulez vous vraiment suprimer ce commentaire ?')) {
		marmottajax.delete({
			'url': _webroot_ + 'comments/' + commentId
		}).then(function(result) {
			if(result == "done"){
				document.getElementById("c-"+commentId).innerHTML = 
				'<div class="message error">'+
				'	<div class="message-icn"><img src="'+_webroot_ +'assets/img/message_error_icon.png" alt="Erreur"></div>'+
				'	<p>Commentaire supprimé</p>'+
				'</div>';
				setTimeout(function(){document.getElementById("c-"+commentId).innerHTML='';}, 3000);
			}
		});
	}
}

function editComment(commentId, buttonEl){
	if(!(buttonEl.getAttribute('data-state') == 'edit')){ //Normal state
		buttonEl.setAttribute('data-state', 'edit');
		buttonEl.innerHTML = 'Enregistrer';

		textEl = document.getElementById("c-"+commentId).children[1].firstElementChild; //Text paragraph
		
		textarea = '<form class="no-style"><textarea id="c-new-content-'+commentId+'" data-content="' + textEl.innerHTML + '">'+ textEl.innerHTML +'</textarea></form>';
		document.getElementById("c-"+commentId).children[1].firstElementChild.innerHTML = textarea;
		document.getElementById("c-new-content-"+commentId).children[1].firstElementChild.focus();
		
	}else{	//Editing
		saveEditedComment(commentId, buttonEl, function(buttonEl) {
			buttonEl.setAttribute('data-state', '');
			buttonEl.innerHTML = 'Editer';
		});
	}
	
	

}

function saveEditedComment(commentId, buttonEl, callback){
	
	if(confirm('Modifier le commentaire ?')){
		marmottajax.put({
			'url': _webroot_ + 'comments/' + commentId,
			'options': {comment: document.getElementById('c-new-content-'+commentId).value}
		}).then( function(result){
			callback(buttonEl);
			comment = document.getElementById("c-"+commentId); //comment element
			textEl = comment.children[1].firstElementChild; //Text paragraph
			
			newContent =  document.getElementById('c-new-content-'+commentId).value;
			
			textEl.innerHTML = '';
			textEl.innerHTML = newContent;
			
			newContent = textEl.innerHTML;
		})
	}
	
}
		