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
	<form class="form middle" method="post" action="">
		<label for="video-title">
			Titre de la vidéo :
			<input id="video-title" type="text" name="video-title" placeholder="Titre" spellcheck="false"/>
		</label>
		
		<label for="video-description">
			Description :
			<textarea name="video-description" id="video-description" rows="4" placeholder="Description"></textarea>
		</label>
		
		<label for="video-tags">
			Tags :<input id="video-tags" type="text" name="video-tags" placeholder="Tags" spellcheck="false"/>
		</label>

		<label for="upload-tumbnail">
			<img class="preview none filePreview" data-input="upload-tumbnail" id="preview-upload-thumbnail" src="">
			<i>Miniature :</i>
			<input type="file" data-text="Choisir un fichier" data-preview="preview-upload-thumbnail" name="upload-tumbnail" id="upload-tumbnail" accept="image/*"><br />
		</label>
		
		<label for="video-visibility">Visibilité :</label>	
		<select name="video-visibility" id="video-visibility">
			<option value="2">Publique</option>
			<option value="1">Non listée</option>
			<option value="0">Privée</option>
		</select>

		<input type="checkbox" id="late" name="late"/><label for="late">Mise en ligne tardive</label><br />
		<label for="video-tags" class="checkbox-dependence">
			<input type="datetime-local" id="datetime" name="datetime">
		</label>

		
		<input type="checkbox" checked id="canDL" name="canDL"/><label for="canDL">Autoriser le téléchargement</label><br />
		
		<input type="submit" id="up-submit" disabled="disabled" name="submit" value="Valider">
	</form>
</div>