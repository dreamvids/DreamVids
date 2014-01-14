<div class="container">
	<div class="container">
		<div class='border-top'></div>
			<h1>Mettre en ligne une vidéo</h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class="container" style="width: 40%; float: left;">

		<?php
		echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : '';
		echo (!isset($err) && isset($_POST['submit']) ) ? '<div id="uploadDoneAlert" class="alert alert-success">'.$uploadDone.'</div>' : '';
		?>

		<form role="from" method="post" enctype="multipart/form-data" action="">
			<div class="form-group">
				<label for="videoInput">Vidéo</label>
				<input type="file" id="videoInput" name="videoInput">
				<p class="help-block">Séléctionnez la vidéo a mettre en ligne</p>
				<div class="progress progress-striped active">
					<div class="progress-bar" id="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
						<span class="sr-only"><span id="percent"></span>% Completé</span>
					</div>
				</div>
				<p id="vid-ok"></p>
			</div>
		</form>

		<form role="form" method="post" action="">
			<div class="form-group">
				<label for="videoTitle">Titre</label>
				<input type="text" class="form-control" name="videoTitle" id="videoTitle" placeholder="Titre">
			</div>

			<div class="form-group">
				<label for="videoDescription">Description</label>
				<textarea rows="4" cols="50" class="form-control" name="videoDescription" id="videoDescription" placeholder="Texte de présentation de la vidéo"></textarea>
			</div>

			<div class="form-group">
				<label for="videoTags">Tags</label>
				<input type="text" class="form-control" name="videoTags" id="videoTags" placeholder="Mots clés">
			</div>

			<br>

			<input type="submit" class="btn btn-primary" name="submit">
		</form>
	</div>
</div>

<script type="text/javascript">
var fileInput = document.getElementById('videoInput'),
progress = document.getElementById('progress');

fileInput.onchange = function() {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'index.php?page=upload');
	xhr.upload.onprogress = function(e) {
		var percent = (e.loaded/e.total)*100;
	    progress.style.width = percent+'%';
	    progress.setAttribute('aria-valuenow', percent);
	    document.getElementById('percent').innerHTML = percent;
	};
	xhr.onload = function() {
	    document.getElementById('vid-ok').innerHTML = 'Upload terminé !';
		var percent = 100;
	    progress.style.width = percent+'%';
	    progress.setAttribute('aria-valuenow', percent);
	    document.getElementById('percent').innerHTML = percent;
	};
	var form = new FormData();
	form.append('videoInput', fileInput.files[0]);
	xhr.send(form);
};
</script>