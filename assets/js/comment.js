function postComment(vid, commentContent) {
	ajax.post('video/' + vid, {'comment-content': commentContent});
}