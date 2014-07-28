<<<<<<< HEAD
<?php

if(isset($data['error'])) {
	echo '<h1>ERROR ! '.$data['error'].'</h1><br><br>';
}

?>

<section class="middle">
	<h1 class="title">Connexion <a href="register">Inscription</a></h1>

	<form method="post" action="" class="form middle">
		<label for="username">Pseudo :</label>
		<input type="text" name="username" id="username" placeholder="Pseudo" value=""/><br />
=======
<section class="middle">
	<h1 class="title">Connexion <a href="register">Inscription</a></h1>

	<?php @include $messages; ?>

	<form method="post" action="<?php echo WEBROOT.'login'; ?>" class="form middle">
		<label for="username">Pseudo :</label>
		<input type="text" name="username" id="username" placeholder="Pseudo" value="<?php echo @$username; ?>"/><br />
>>>>>>> dreamvids-2.0-dev
		<label for="pass">Mot de passe :</label>
		<input type="password" name="pass" id="pass" placeholder="Mot de passe" vaue=""/><br />
		<input type="checkbox" id="remember" name="remember"/><label for="remember">Se souvenir de moi</label><br />
		<input type="submit" name="submitLogin" value="Se connecter" class="btn btn-primary" />
	</form>
</section>