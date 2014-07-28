<div class="content">

	<section class="profile">
		<h1 class="title">Espace membre</h1>

		<?php
<<<<<<< HEAD
			include VIEW.'layouts/accountMenu.php';
			include VIEW.'layouts/messages.php';
		?>

		<form class="form" method="post" action="">
=======
			include VIEW.'layouts/account_menu.php';
			include VIEW.'layouts/messages.php';
		?>

		<form class="form" method="post" action="<?php echo WEBROOT.'account/password'; ?>">
			<input type="hidden" name="_method" value="put" />
			
>>>>>>> dreamvids-2.0-dev
			<label for="currentPass">Mot de passe actuel :</label>
			<input type="password" name="currentPass"><br />

			<label for="newPass">Nouveau mot de passe :</label>
			<input type="password" name="newPass"><br />

			<label for="newPassConfirm">Confirmation du nouveau mot de passe :</label>
			<input type="password" name="newPassConfirm"><br />

			<input type="submit" name="passwordSubmit" value="Enregistrer">
		</form>
	</section>

</div>