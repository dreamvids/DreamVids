	<div class="container">
<h1 class="title">Ajouter une vidéo</h1>
		<?php
		echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : '';
		echo (!isset($err) && isset($_POST['submit']) ) ? '<div id="uploadDoneAlert" class="alert alert-success">'.$uploadDone.'</div>' : '';
		?>
		<div class="alert alert-success">Une fois le formulaire validé, vous allez être redirigé vers votre vidéo, si celle-ci ne se lance pas, attendez quelques secondes puis rechargez la page, le temps que la conversion se fasse :)</div>
		<div class="alert alert-info">Les formats compatibles sont: <strong>webm, mp4, m4a, mpg, mpeg, 3gp, 3g2, asf, wma, mov, avi, wmv, ogg, ogv, flv et mkv.</strong> La taille maximum autorisée pour une vidéo est de 2Go.</div>
		<form role="form" method="post" enctype="multipart/form-data" action="<?php echo $_SESSION['serv']['addr'].'uploads/?uid='.$session->getId().'&fid='.$_SESSION['vid_id'].'&tid=video'; ?>>">
			<label for="videoInput"><?php echo $lang['vid']; ?></label>
			<input type="file" id="videoInput" name="videoInput">
			<p class="help-block"><?php echo $lang['select_vid']; ?></p>
			<div class="progress progress-striped active" id="progress-style">
				<div id="progressbar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
					<span class="sr-only"></span>
				</div>
			</div>
			<p id="vid-ok"></p>
			<button class="btn btn-danger" onclick="abortUpload();return false"><?php echo $lang['abort']; ?></button>
		</form>
		<br /><br />
		<form role="form" method="post" action="" enctype="multipart/form-data">
			<div class="form-group">
				<label for="videoTitle"><?php echo $lang['title']; ?></label>
				<input type="text" required class="form-control" name="videoTitle" id="videoTitle" placeholder="<?php echo $lang['title']; ?>">
			</div>

			<div class="form-group">
				<label for="videoDescription"><?php echo $lang['desc']; ?></label>
				<textarea rows="4" cols="50" required class="form-control" name="videoDescription" id="videoDescription" placeholder="<?php echo $lang['desc']; ?>"></textarea>
			</div>

			<div class="form-group">
				<label for="videoTags"><?php echo $lang['tags']; ?></label>
				<input type="text" class="form-control" required name="videoTags" id="videoTags" placeholder="<?php echo $lang['tags']; ?>">
				<div class="alert alert-info">Les tags doivent être séparés par une virgule</div>
			</div>

			<div class="form-group">
				<label for="videoTumbnail"><?php echo $lang['tumbnail']; ?></label>
				<input type="file" name="videoTumbnail" id="videoTumbnail" />
				<a href="img/maquette_thumbnail.png" target="_blank">Maquette de miniature</a>
			</div>
			
			<div class="form-group">
				<label for="videoVisibility"><?php echo $lang['visibility']; ?></label>
				<select class="form-control" name="videoVisibility" id="videoVisibility">
					<option value="2"><?php echo $lang['public']; ?></option>
					<option value="1"><?php echo $lang['non_listed']; ?></option>
					<option value="0"><?php echo $lang['private']; ?></option>
				</select>
			</div>

			<br>

			<div class="alert alert-info">Vous pouvez valider le formulaire une fois la mise en ligne terminée</div>
			<input type="submit" id="up-submit" disabled="disabled" class="btn btn-primary" name="submit">
		</form>
	</div>
</div>

<script type="text/javascript">
var fileInput = document.getElementById('videoInput'),
thumbInput = document.getElementById('videoTumbnail'),
progress = document.getElementById('progressbar'),
xhr = null;

<?php
if (isset($_POST['submit']) )
{
?>
updateProgress(100);
document.getElementById('vid-ok').innerHTML += '<br />Upload terminé !';
document.getElementById('progress-style').className = 'progress progress-striped';
progress.className = 'progress-bar progress-bar-success';
document.getElementById('up-submit').removeAttribute('disabled');
<?php
}
?>

function updateProgress(percent) {
	percent = Math.round(percent*10)/10;
    progress.style.width = percent+'%';
    progress.setAttribute('aria-valuenow', percent);
    document.getElementById('vid-ok').innerHTML = '<b>'+percent+' %</b>';
}

function tempsRestant(timestamp) {
    var seconds = Math.round(timestamp / 1000);
    var minutes = Math.round(seconds / 60);
    var heures = Math.round(minutes / 60);

    if (seconds < 1) { return "une seconde"; }
    else if (seconds < 60) { return seconds + " secondes"; }
    else if (minutes === 1) { return minutes + " une minute"; }
    else if (minutes < 14) { return minutes + " minutes"; }
    else if (minutes < 16) { return "un quart d'heures"; }
    else if (minutes < 29) { return minutes + " minutes"; }
    else if (minutes < 31) { return "une demi heure"; }
    else if (minutes < 55) { return minutes + " minutes"; }
    else if (minutes < 65) { return "une heure"; }
    else if (minutes < 120) { return "une heure"; }
    else if (minutes < 1440) { return heures + " heures"; }
    else { return "très longtemps"; }
}

function abortUpload() {
	xhr.abort();
	fileInput.removeAttribute('disabled');
	document.getElementById('progress-style').className = 'progress progress-striped';
	progress.className = 'progress-bar progress-bar-danger';
}

fileInput.onchange = function() {
	document.getElementById('progress-style').className = 'progress progress-striped active';
	progress.className = 'progress-bar';
	var ext = fileInput.value.split('.');
	ext = ext[ext.length - 1];
	if (inArray(ext.toLowerCase(), ['webm', 'mp4', 'm4a', 'mpg', 'mpeg', '3gp', '3g2', 'asf', 'wma', 'mov', 'avi', 'wmv', 'ogg', 'ogv', 'flv', 'mkv']) ) {
		fileInput.setAttribute('disabled', 'disabled');
		xhr = new XMLHttpRequest();
		xhr.open('POST', '<?php echo $_SESSION['serv']['addr'].'uploads/?uid='.$session->getId().'&fid='.$_SESSION['vid_id'].'&tid=video'; ?>');
		xhr.upload.onprogress = function(e) {
			updateProgress( (e.loaded/e.total)*100);
		};
		xhr.onload = function() {
			updateProgress(100);
		    document.getElementById('vid-ok').innerHTML += '<br />Upload terminé !';
		    document.getElementById('progress-style').className = 'progress progress-striped';
		    progress.className = 'progress-bar progress-bar-success';
		    document.getElementById('up-submit').removeAttribute('disabled');
		};
		var form = new FormData();
		form.append('fileInput', fileInput.files[0]);
		xhr.send(form);
	}
	else {
		alert("<?php echo $lang['error_video_type_incorrect']; ?>");
	}
};

thumbInput.onchange = function() {
	var ext = thumbInput.value.split('.');
	ext = ext[ext.length - 1];
	if (inArray(ext.toLowerCase(), ['jpeg', 'jpg', 'png', 'gif', 'tiff', 'svg']) ) {
		thumbInput.setAttribute('disabled', 'disabled');
		xhr = new XMLHttpRequest();
		xhr.open('POST', '<?php echo $_SESSION['serv']['addr'].'uploads/?uid='.$session->getId().'&fid='.$_SESSION['vid_id'].'&tid=thumbnail'; ?>');
		var form = new FormData();
		form.append('fileInput', thumbInput.files[0]);
		xhr.send(form);
	}
	else {
		alert("Ceci n'est pas une image valide");
	}
};
</script>
