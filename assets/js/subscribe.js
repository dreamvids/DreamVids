function subscribeAction(channel) {
	var button = document.getElementById('subscribe-button');

	//alert()

	if(hasClass(button, 'subscribed')) {
		alert('unsubscribe');
		ajax.get('unsubscribe/' + channel, {});
	}
	else {
		alert('subscribe');
		ajax.get('subscribe/' + channel, {});
	}
}