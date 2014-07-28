<section class="middle">
	<h1 class="title">Inscription <a href="login">Connexion</a></h1>

<<<<<<< HEAD
	<?php
	if(isset($data['error'])) echo '<h1>ERROR ! '.$data['error'].'</h1><br><br>';
	?>

	<form method="post" action="" class="middle form">
		<label for="username">Nom d'utilisateur :</label>
		<input type="text" name="username" id="username" placeholder="Pseudo" value=""/><br />
=======
	<?php @include $messages; ?>

	<form method="post" action="" class="middle form">
		<label for="username">Nom d'utilisateur :</label>
		<input type="text" name="username" id="username" placeholder="Pseudo" value="<?php echo @$username; ?>"/><br />
>>>>>>> dreamvids-2.0-dev
		<label for="pass">Mot de passe :</label>
		<input type="password" name="pass" id="pass" placeholder="Mot de passe" vaue=""/><br />
		<label for="pass-confirm">Confirmation :</label>
		<input type="password" name="pass-confirm" id="pass-confirm" placeholder="Mot de passe" vaue=""/><br />
		<label for="mail">Adresse e-mail: </label>
<<<<<<< HEAD
		<input type="text" name="mail" id="mail" placeholder="Adresse de contact" value=""/><br />
=======
		<input type="text" name="mail" id="mail" placeholder="Adresse de contact" value="<?php echo @$mail; ?>"/><br />
>>>>>>> dreamvids-2.0-dev

		<input type="submit" name="submitRegister" value="Valider" class="btn btn-primary" />
	</form>
</section>