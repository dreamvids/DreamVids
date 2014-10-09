function createLive(channelId) {
	marmottajax.post({
		'url': './lives',
		'options': { 'channel-id': channelId }
	}) .then(function(result) {
		try {
			var json = JSON.parse(result);
			document.getElementById('live-key').innerHTML = 'Votre clé: ' + json.key + '<br />Lien du live: <a href="'+_webroot_+'lives/'+json.channel+'">http://dreamvids.fr/lives/'+json.channel+'</a>';
		}
		catch(e) {}
	});
}

function revokeLive(accessId) {
	marmottajax.delete({
		'url': './lives/' + accessId,
		'options': {}
	}) .then(function(result) {
		document.getElementById('access').innerHTML = 'Accès supprimé';
	});
}