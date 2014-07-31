<div class="content">

	<section class="">
		<h1 class="title">Modifier une chaîne</h1>

		<?php
			include VIEW.'layouts/account_menu.php';
			include VIEW.'layouts/messages.php';
		?>

		<form class="form" method="post" action="<?php echo WEBROOT.'channel/'.$name; ?>" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="put" />

			<label for="name">Nom :</label>
			<input value="<?php echo @$name; ?>" type="text" name="name" required="required" id="name" placeholder="Nom de votre chaîne" <?php echo @$mainChannel ? 'readonly' : ''; ?>/>

			<?php if (@$mainChannel) { ?>
				<p>Pour changer le nom de cette chaîne, vous devez changer de pseudo, le changement sera immédiatement répercuté sur votre chaîne.</p><br />
			<?php 
			}
			else {}
			?>
			<br />
			
			<label for="description">Description :</label>
			<textarea rows="8" cols="50" required="required" name="description" id="description"><?php echo @$description; ?></textarea><br />
			
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
			
			<input type="submit" name="editChannelSubmit" value="Modifier la chaîne" />
		</form>
	</section>

</div>