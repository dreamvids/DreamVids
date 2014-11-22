<section class="middle">
	<h1 class="title">Inscription <a href="login">Connexion</a></h1>

	<?php @include $messages; ?>

	<form method="post" action="" class="middle form">
		<label for="username">Nom d'utilisateur (Sera également le nom de votre chaîne) :</label>
		<input type="text" name="username" id="username" placeholder="Pseudo" value="<?php echo @$username; ?>"/><br />
		<label for="pass">Mot de passe :</label>
		<input type="password" name="pass" id="pass" placeholder="Mot de passe" vaue=""/><br />
		<label for="pass-confirm">Confirmation :</label>
		<input type="password" name="pass-confirm" id="pass-confirm" placeholder="Mot de passe" vaue=""/><br />
		<label for="mail">Adresse e-mail: </label>
		<input type="email" name="mail" id="mail" placeholder="Adresse de contact" value="<?php echo @$mail; ?>"/><br />

		<input type="submit" name="submitRegister" value="Valider" />
	</form>
</section>