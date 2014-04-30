<div class="content">

	<section class="">
		<h1 class="title">Modifier une chaîne</h1>

		<?php
			include VIEW.'layouts/accountMenu.php';
			include VIEW.'layouts/messages.php';
		?>

		<form class="form" method="post" action="" enctype="multipart/form-data">
			<label for="name">Nom :</label>
			<input value="<?php echo @$name; ?>" type="text" name="name" required="required" id="name" placeholder="Nom de votre chaîne" /><br />
			
			<label for="description">Description :</label>
			<textarea rows="8" cols="50" required="required" name="description" id="description"><?php echo @$description; ?></textarea><br />
			
			<label for="avatar">Avatar :</label><br />
			<input type="file" name="avatar" id="avatar" value="<?php echo @$avatar; ?>" /><br />
			
			<label for="banner">Bannière :</label><br />
			<input type="file" name="banner" id="banner" value="<?php echo @$banner; ?>" /><br />
			
			<label for="background">Arrière-plan :</label><br />
			<input type="file" name="background" id="background" value="<?php echo @$background; ?>" /><br />
			
			<input type="submit" name="editChannelSubmit" value="Créer la chaîne" />
		</form>
	</section>

</div>