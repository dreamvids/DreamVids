<div class="content">

	<section class="">
		<h1 class="title">Ajouter une chaîne</h1>

		<?php
			include VIEW.'layouts/account_menu.php';
			include VIEW.'layouts/messages.php';
		?>

		<form class="form" method="post" action="" enctype="multipart/form-data">

			<label for="name">
				Nom :
				<input value="<?php echo @$name; ?>" id="name" type="text" name="name" placeholder="Nom de votre chaîne" required="required" spellcheck="false"/>
			</label>

			<label for="description">
				Description :
				<textarea name="description" id="description" rows="4" required="required" placeholder="Description"><?php echo @$description; ?></textarea>
			</label>
			
			<label for="avatar">
				<img class="preview none filePreview" data-input="avatar" id="preview-avatar" src="">
				<i>Avatar :</i>
				<input type="file" data-text="Choisir un avatar" data-preview="preview-avatar" name="avatar" id="avatar" value="<?php echo @$avatar; ?>" /><br />
			</label>
			
			<label for="background">
				<img class="preview none filePreview" data-input="background" id="preview-background" src="">
				<i>Arrière-plan :</i>
				<input type="file" data-text="Choisir un arrière-plan" data-preview="preview-background" name="background" id="background" value="<?php echo @$background; ?>" /><br />
			</label>
			
			<input type="submit" name="createChannelSubmit" value="Créer la chaîne" />

		</form>
	</section>

</div>