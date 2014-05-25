function postComment(vid, commentContent) {
	ajax.post('video/' + vid, {'commentSubmit': 'lol', 'comment-content': commentContent});
}