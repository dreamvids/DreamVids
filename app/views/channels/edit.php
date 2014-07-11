<div class="content">

	<section class="">
		<h1 class="title">Modifier une chaîne</h1>

		<?php
			include VIEW.'layouts/accountMenu.php';
			include VIEW.'layouts/messages.php';
		?>

		<form class="form" method="post" action="" enctype="multipart/form-data">
			<label for="name">Nom :</label>
			<input value="<?php echo @$name; ?>" type="text" name="name" required="required" id="name" placeholder="Nom de votre chaîne" <?php echo @$mainChannel ? 'disabled' : ''; ?>/>

			<?php if (@$mainChannel): ?>
				<p>Vous ne pouvez pas changer le nom de votre chaîne principale</p><br />
			<?php endif ?>
			<br />
			
			<label for="description">Description :</label>
			<textarea rows="8" cols="50" required="required" name="description" id="description"><?php echo @$description; ?></textarea><br />
			
			<label for="avatar">
				<img class="preview none filePreview" data-input="avatar" id="preview-avatar" src="">
				<i>Avatar :</i>
				<input type="file" data-text="Choisir un avatar" data-preview="preview-avatar" name="avatar" id="avatar" value="<?php echo @$avatar; ?>" /><br />
			</label>
			
			<label for="banner">
				<img class="preview none filePreview" data-input="banner" id="preview-banner" src="">
				<i>Bannière :</i>
				<input type="file" data-text="Choisir une bannière" data-preview="preview-banner" name="banner" id="banner" value="<?php echo @$banner; ?>" /><br />
			</label>
			
			<label for="background">
				<img class="preview none filePreview" data-input="background" id="preview-background" src="">
				<i>Arrière-plan :</i>
				<input type="file" data-text="Choisir un arrière-plan" data-preview="preview-background" name="background" id="background" value="<?php echo @$background; ?>" /><br />
			</label>
			
			<input type="submit" name="editChannelSubmit" value="Créer la chaîne" />
		</form>
	</section>

</div>