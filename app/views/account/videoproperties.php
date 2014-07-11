<br>

<form method="post" action="">
	<label for="videoTitle">Titre:</label><br>
	<input type="text" name="videoTitle" value="<?php echo $video->title; ?>">
	<br><br>

	<label for="videoDescription">Description:</label><br>
	<textarea name="videoDescription" rows="8" cols="18"><?php echo $video->description; ?></textarea>
	<br><br>

	<label for="videoTags">Tags:</label><br>
	<input type="text" name="videoTags" value="<?php echo $video->tags; ?>">
	<br><br>

	<input type="submit" name="videoPropertiesSubmit" value="Enregistrer">
</form>