function createLive(channelId) {
	marmottajax.post({
		'url': './lives',
		'options': { 'channel-id': channelId }
	}) .then(function(result) {
		try {
			var json = JSON.parse(result);
			document.getElementById('live-key').innerHTML = 'Votre clé: ' + json.key;
		}
		catch(e) {}
	});
}

function revokeLive(accessId) {
	marmottajax.delete({
		'url': './' + accessId,
		'options': {}
	}) .then(function(result) {
		document.getElementById('access').innerHTML = 'Accès supprimé';
	});
}