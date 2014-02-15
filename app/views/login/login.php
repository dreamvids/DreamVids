<h1>Login</h1><br><br>

<?php

if(isset($data['error'])) {
	echo '<h1>ERROR ! '.$data['error'].'</h1><br><br>';
}

?>

<form role="form" method='post' action=''>
	<label for="username">Nom d'utilisateur</label><br>
	<input type="text" name="username" required="" placeholder="" value="" class="form-control"/><br>
	<label for="pass">Mot de passe</label><br>
	<input type="password" name="pass" required="" placeholder="" vaue="" class="form-control"/><br><br>
	<input type="checkbox" value="remember" id="remember" name="remember" /> <label for="remember">Se rappeller de moi</label><br>

	<input type="submit" name="submitLogin" value="Connexion" class="btn btn-primary" />
</form>