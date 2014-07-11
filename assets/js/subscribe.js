function subscribeAction(channel) {
	var button = document.getElementById('subscribe-button');

	if(hasClass(button, 'subscribed')) {
		ajax.get('unsubscribe/' + channel, {});
	}
	else {
		ajax.get('subscribe/' + channel, {});
	}
}