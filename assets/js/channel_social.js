function postMessage(channel, postContent) {
	marmottajax.post({
		'url': '../../../posts',
		'options': {'post-message-submit': 'lol', 'channel': channel, 'post-content': postContent}
	}).then(function(result) {
		try {
			var json = JSON.parse(result);
			
			var postDiv = document.createElement('div');
			postDiv.className = 'channel-post';
			postDiv.setAttribute('style', 'background-color: #40a6e0; width: 50%; padding: 10px; margin-bottom: 1%;'); // Sorry...

			var content = document.createTextNode(json.content);
			postDiv.appendChild(content);

			document.getElementById('channel-posts').appendChild(postDiv);
		}
		catch(e) {}
	});
	document.getElementById("post-content").value = '';

}