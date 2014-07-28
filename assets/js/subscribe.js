function subscribeAction(channel) {
	var button = document.getElementById('subscribe-button');

	if(hasClass(button, 'subscribed')) {
<<<<<<< HEAD
		ajax.get('unsubscribe/' + channel, {});
	}
	else {
		ajax.get('subscribe/' + channel, {});
=======
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
>>>>>>> dreamvids-2.0-dev
	}
}