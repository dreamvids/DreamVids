function subscribeAction(channel) {
	var button = document.getElementById('subscribe-button');

	if(hasClass(button, 'subscribed')) {
		marmottajax.put({
			'url': channel,
			'options': { unsubscribe: true }
		});
	}
	else {
		marmottajax.put({
			'url': channel,
			'options': { subscribe: true }
		});
	}
}