<div class="content">

	<section class="video-settings">
		<h1 class="title">Parametres de la vidéo "<?php echo $video->title; ?>"</h1>

		<?php @include $messages; ?>

		<form class="form" method="post" action="<?php echo WEBROOT.'videos/'.$video->id; ?>" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="put" />

			<label for="video-title">Titre de la vidéo :</label>
			<input value="<?php echo $video->title; ?>" id="video-title" type="text" name="video-title" placeholder="Titre" spellcheck="false"/>
			
			<label for="video-description">Description :</label>
			<textarea name="video-description" id="video-description" rows="4" placeholder="Description"><?php echo $video->description; ?></textarea>
			
			<label for="video-tags">Tags :</label>
			<input value="<?php echo $video->tags; ?>" id="video-tags" type="text" name="video-tags" placeholder="Tags" spellcheck="false"/>

			<label for="tumbnail">
				<img class="preview filePreview" data-input="tumbnail" id="preview-thumbnail" src="<?php echo $video->getThumbnail(); ?>">
				<i>Miniature :</i>
				<input type="file" data-text="Choisir un fichier" data-preview="preview-thumbnail" name="tumbnail" id="tumbnail" /><br />
			</label>

			<label for="video-visibility">
				Visibilité :
				<select name="video-visibility" id="video-visibility">
					<option value="2">Publique</option>
					<option value="1">Non listée</option>
					<option value="0">Privée</option>
				</select>
			</label>

			<input type="submit" name="video-edit-submit" value="Enregistrer">
		</form>
	</section>

</div>