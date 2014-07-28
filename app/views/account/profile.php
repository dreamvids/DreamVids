<div class="content">

	<section class="profile">
		<h1 class="title">Espace membre</h1>

		<?php
<<<<<<< HEAD
			include VIEW.'layouts/accountMenu.php';
			include VIEW.'layouts/messages.php';
		?>

		<form class="form" method="post" action="" enctype="multipart/form-data">
=======
			include VIEW.'layouts/account_menu.php';
			include VIEW.'layouts/messages.php';
		?>

		<form class="form" method="post" action="<?php echo WEBROOT.'account/mail'; ?>" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="put" />

>>>>>>> dreamvids-2.0-dev
			<label for="email">Adresse email :</label>
			<input value="<?php echo $email; ?>" type="text" name="email" placeholder="Adresse email"><br />

			<!-- <label for="username">Pseudo :</label>
			<input value="<?php echo $username; ?>" type="text" name="username" placeholder="Pseudo"><br />
			
			<label for="language">Langue :</label>
			<select name="language">
				<option value="fr">Français</option>
				<option value="en">Anglais</option>
			</select>-->

			<input type="submit" name="profileSubmit" value="Enregistrer">
		</form>
	</section>

</div>