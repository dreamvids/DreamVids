<h1 style="text-decoration: underline;">
	Mon compte <?php echo $data['username']; ?>  <a href="<?php echo WEBROOT.'login/signout'; ?>">Déconnexion</a>
</h1>
<a href="<?php echo WEBROOT.'profile'; ?>">Modifier mon profil</a>
<br><br>

<h1 style="text-decoration: underline;">Changer mon mot de passe</h1><br>
<form action="" method="post" role="form">
	<label for="actualPass">Mot de passe actuel</label><br>
	<input type="password" required name="actualPass" id="actualPass" class="form-control" /><br><br>

	<label for="pass1">Nouveau mot de passe</label><br>
	<input type="password" required name="pass1" id="pass2" class="form-control" /><br><br>

	<label for="pass2">Confirmer le nouveau mot de passe</label><br>
	<input type="password" required name="pass2" id="pass2" class="form-control" /><br><br>

	<input type="submit" name="submit" style="margin-bottom:20px" />
</form>