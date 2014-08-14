<section class="middle">
	<h1 class="title">Connexion <a href="register">Inscription</a></h1>

	<?php @include $messages; ?>

	<form method="post" action="<?php echo WEBROOT.'login'; ?>" class="form middle">
		<label for="username">Pseudo :</label>
		<input type="text" name="username" id="username" placeholder="Pseudo" value="<?php echo @$username; ?>"/><br />
		<label for="pass">Mot de passe :</label>
		<input type="password" name="pass" id="pass" placeholder="Mot de passe" vaue=""/><br />
		<input type="submit" name="submitLogin" value="Se connecter" />
	</form>
</section>