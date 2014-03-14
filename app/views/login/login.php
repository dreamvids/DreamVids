<?php

if(isset($data['error'])) {
	echo '<h1>ERROR ! '.$data['error'].'</h1><br><br>';
}

?>

<section id="login">
	<h1>Connexion</h1>

	<form method="post" action="">
		<label for="username">Pseudo :</label>
		<input type="text" name="username" id="username" placeholder="Pseudo" value=""/><br />
		<label for="pass">Mot de passe :</label>
		<input type="password" name="pass" id="pass" placeholder="Mot de passe" vaue=""/><br />
		<input type="checkbox" id="remember" name="remember"/><label for="remember">Se souvenir de moi</label><br />
		<input type="submit" name="submitLogin" value="Se connecter" class="btn btn-primary" />
	</form>
</section>