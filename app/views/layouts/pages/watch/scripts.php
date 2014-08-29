<script type="text/javascript" src="https://www.gstatic.com/cv/js/sender/v1/cast_sender.js"></script>

<script src="<?php echo JS.'script.js'; ?>"></script>

<script src="<?php echo JS."utils.js"; ?>"></script>
<script src="<?php echo JS."interactions.js"; ?>"></script>
<script src="<?php echo JS."video.js"; ?>"></script>
<script src="<?php echo JS."comment.js"; ?>"></script>
<script src="<?php echo JS."player.js"; ?>"></script>
<script src="<?php echo JS."subscribe.js"; ?>"></script>
<script src="<?php echo JS.'admin.js'; ?>"></script>
<script src="<?php echo JS.'marmottajax.js'; ?>"></script>

<script>
	

	setVideo([

		{
			format: 360,
			mp4: "http://dreamvids.fr/uploads/Dimou/AxRw02.webm_640x360p.mp4",
			webm: "http://dreamvids.fr/uploads/Dimou/AxRw02.webm_640x360p.webm"
		},

		{
			format: 720,
			mp4: "http://dreamvids.fr/uploads/Dimou/AxRw02.webm_1280x720p.mp4",
			webm: "http://dreamvids.fr/uploads/Dimou/AxRw02.webm_1280x720p.webm"
		}

	]);
	
	setSubTitles([

		{
			text: "Nom Nom Nom Nom",
			start: 0,
			end: 3
		},

		{
			text: "Nom Nom Nom Nom Nom Nom",
			start: 4,
			end: 6
		}

	]);

</script>

<script>

	var DEBUG_VARIABLES = [];

	function DEBUG(variable) {

		DEBUG_VARIABLES.push(variable);

	}
	
	alert("Ok ! Salut Peter !");

	if (confirm("Premièrement, es-tu connecté ?\n\nOk = Oui\nAnnuler = Non")) {

		alert("Génial ! Maintenant essaye de poster un commentaire, puis ne quitte surtout pas cette page et previens Dimou quand tu as fini ;-)");

	}

	else {

		alert("Alors je vais t'inviter à te connecter ;-)");
		document.location = "../login";

	}

</script>