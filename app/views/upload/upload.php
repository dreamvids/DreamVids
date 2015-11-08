<div id="upload-large-modal">
	<div class="bg-loader" id="backgroundLoader" data-background="<?php echo UserChannel::find($channelId)->getBackground(); ?>"></div>
<?php if(!$canUpload): ?>
        <section id="uploader">
            <?php  include VIEW . 'layouts/messages.php'; ?>
		<span id="upload-illustration">

		</span>
        </section>
<?php
    elseif($canUpload): ?>
	<section id="message-upload">
		<h3>Déposez votre fichier vidéo dans cette zone pour l'uploader</h3>
		<p>(Ou selectionnez votre fichier manuellement en cliquant sur le nuage)</p>
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
	<form id="upload-form" class="form middle" method="post" action="<?php echo WEBROOT.'videos'; ?>" enctype="multipart/form-data">
		<input type="hidden" name="channelId" id="channelId" value="<?php echo $channelId; ?>" />
		<input type="hidden" name="uploadId" id="uploadId" value="<?php echo $uploadId; ?>" />
		<label for="video-title">
			Titre de la vidéo :
			<input id="video-title" type="text" name="video-title" required="required" placeholder="Titre" spellcheck="false"/>
		</label>
		<fieldset>
			<?php if(false){ //if(!empty($predefined_descriptions)) { //TODO AFTER All the bug fix?>
			<select onchange="insertDesc(this);">
				<option value="" selected>Inserez une description prédéfinie...</option>
				<option disabled>──────────</option>
			<?php foreach ($predefined_descriptions as $desc) { ?>
			
				<option value="<?php echo stripslashes($desc->description); ?>" ><?php echo Utils::secure($desc->name); ?></option>
			<?php } ?>
		</select> 
			<?php }else{
					
			}?>
		<label for="video-description"> 
			Description : 
		<textarea name="video-description" required="required" id="video-description" rows="4" placeholder="Description"></textarea>
		</label>
		
<!-- 		<input name="save-description" type="checkbox">Ajouter cette description aux prédéfinies &nbsp;</input> 
		<input name="save-description-name" style="width:45%; display: inline;" placeholder="Nom de cette description" type="text"> -->
		</fieldset>
		
		<label for="video-tags">
			Mots clés (séparés par un espace) :<input id="video-tags" type="text" name="video-tags" required="required" placeholder="Tag1 Tag2 TagDeLaMort" spellcheck="false"/>
		</label>

		<label for="upload-tumbnail">
			<img class="preview none filePreview" data-input="upload-tumbnail" id="preview-upload-thumbnail" src="<?php echo $thumbnail; ?>">
			<i>Miniature :</i>
			<input type="file" data-text="Choisir un fichier" data-preview="preview-upload-thumbnail" name="upload-tumbnail" id="upload-tumbnail" accept="image/*"><br />
		</label>
		
		<label for="video-visibility">Visibilité :</label>	
		<select name="video-visibility" id="video-visibility">
			<option value="2">Publique</option>
			<option value="1">Non listée</option>
			<option value="0">Privée</option>
		</select>

		<br>
		
		<input type="submit" id="up-submit" name="submit" value="Valider">
	</form>
</div>
<?php endif; ?>
