
function createLive(channelId) {

	marmottajax.post({

		url: _webroot_ + "lives",

		options: {

			"channel-id": channelId

		}

	}) .then(function(result) {

		try {

			var data = JSON.parse(result);

			document.getElementById("live-key").innerHTML = "Accès a votre live disponible (chaîne: " + data.channel + ")" + "<br><br>Clé de live : " + data.key + '<br>Lien du live: <a href="' + _webroot_ + 'lives/' + data.channel + '">dreamvids.fr/lives/' + data.channel + '</a>';

			document.getElementById("live-form-button").innerHTML = '<button class="btn btn--raised btn--red" onclick="revokeLive(\'' + data.id + '\')">Révoquer l\'accès live</button>';
			//document.getElementById("channel").setAttribute("disabled", "");

			document.getElementById("live-creation-title").innerHTML = "Votre live";

		}

		catch(e) {}

	});

}

function revokeLive(accessId) {

	marmottajax.delete({

		url: _webroot_ + "lives/" + accessId

	}) .then(function() {
		document.location.reload();
		/*document.getElementById("live-key").innerHTML = "";

		document.getElementById("live-form-button").innerHTML = '<button class="btn btn--raised btn--blue" onclick="createLive(document.getElementById(\'channel\').value)">Commencer un live</button>';
		document.getElementById("channel").removeAttribute("disabled");

		document.getElementById("live-creation-title").innerHTML = "Lancer un live";*/

	});

}