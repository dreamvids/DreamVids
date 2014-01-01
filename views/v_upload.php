<div class="container">
	<div class="container">
		<div class='lol'></div>
			<h1>Mettre en linge une vidéo</h1>
		<div class='yolo'></div>

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
			</div>

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

			<button class="btn">Annuler</button>
			<input type="submit" class="btn btn-primary" name="submit">
		</form>
	</div>
</div>