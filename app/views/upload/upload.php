<h1>Mettre en ligne une vidéo</h1><br>

<?php
if(isset($data['error']))
	echo "<h1>ERROR ! ".$data['error']."</h1><br><br>";
?>

<progress id="progress-bar" value="0" max="100" style="100%;"></progress><br><br>

<form enctype="multipart/form-data" method="post" id="videoFileForm">
	<input type="file" name="videoFile" id="videoFile"><br>
</form>

<form id="uploadVideoForm" method="post">
	<br><br>

	Titre<br>
	<input type="text" id="videoTitle" name="videoTitle" required><br><br>

	Description<br>
	<textarea rows="4" cols="50" required name="videoDescription" id="videoDescription" placeholder="Présentation de la vidéo"></textarea><br><br>

	Tags<br>
	<input type="text" id="videoTags" name="videoTags" required><br><br>

	Miniature<br>
	<input type="file" name="videoThumbnail" id="videoThumbnail"><br><br>

	Visibilité
	<select name="videoVisibility" id="videoVisibility">
		<option value="2">Publique</option>
		<option value="1">Non listée</option>
		<option value="0">Privée</option>
	</select>
	<br>

	<br><br><input type="submit" value="Envoyer" name="uploadDataSubmit"><br><br>

	<p id="status"></p><br>
	<p id="bytesLoaded"></p>
</form>

<script src="<?php echo JS.'upload.js'; ?>"></script>