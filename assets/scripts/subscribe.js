function subscribeAction(channel) {
	var button = document.getElementById('subscribe-button');

	if(hasClass(button, 'subscribed')) {
		ajax.get(channel + '/unsubscribe/', {});
	}
	else {
		ajax.get(channel + '/subscribe/', {});
	}
}