function subscribeAction(channel) {
	var button = document.getElementById('subscribe-button');

	if(hasClass(button, 'subscribed')) {
		marmottajax.put({
			'url': _webroot_ + channel,
			'options': { unsubscribe: true }
		});
	}
	else {
		marmottajax.put({
			'url': _webroot_ + channel,
			'options': { subscribe: true }
		});
	}
}