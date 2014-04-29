<div id="upload-large-modal">
	<div class="bgLoader" id="backgroundLoader" data-background="<?php echo IMG.'backgrounds/002.jpg'; ?>"></div>
	<section id="message-upload">
		<h3>Déposez votre fichier vidéo dans cette zone pour l'uploader</h3>
		<p>(Pour selectionner votre fichier manuellement cliquez sur le nuage)</p>
	</section>
	<section id="uploader">
		<span id="upload-illustration">
			<span class="cloud">
				<span id="arrowUpload" data-uploaded-message="Uploaded"></span>
			</span>
		</span>

		<input id="upload-input" type="file" name="video" accept="video/*">

		<div id="file-name"></div>
	</section>

	<div id="progress-upload">
		<div id="progress-bar"></div>
	</div>
</div>

<div id="upload-content">
	<form class="form middle" method="post" action="" enctype="multipart/form-data">
		<label for="video-title">Titre de la vidéo :<input id="video-title" type="text" name="video-title" placeholder="Titre" spellcheck="false"/></label>
		<label for="video-description">Description :<textarea name="video-description" id="video-description" rows="4" placeholder="Description"></textarea></label>
		<label for="video-tags">Tags :<input id="video-tags" type="text" name="video-tags" placeholder="Tags" spellcheck="false"/></label>
		<label for="video-tumbnail">Miniature :<br /><input type="file" name="video-tumbnail" id="video-tumbnail" accept="image/*"></label><br /><br /><br /><br /><br />
		<label for="video-visibility">
			Visibilité :
			<select name="video-visibility" id="video-visibility">
				<option value="2">Publique</option>
				<option value="1">Non listée</option>
				<option value="0">Privée</option>
			</select>
		</label>
		
		<input type="button" id="up-submit" disabled="disabled" name="submit" value="Valider" onclick="submitVideoInfo()">
	</form>
</div>