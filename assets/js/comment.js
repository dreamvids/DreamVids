function postComment(vid, commentContent, fromChannel) {
	ajax.post('video/' + vid, {'commentSubmit': 'lol', 'comment-content': commentContent, 'from-channel': fromChannel});
}