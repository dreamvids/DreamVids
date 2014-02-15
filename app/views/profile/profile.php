<h1 style="text-decoration: underline;">
	Mon compte <?php echo $data['username']; ?>  <a href="<?php echo WEBROOT.'login/signout'; ?>">Déconnexion</a>
</h1>
<a href="<?php echo WEBROOT.'profile/settings'; ?>">Modifier mes informations</a>
<br><br>

<h1 style="text-decoration: underline;">Statistiques</h1><br>
<p>Abonnés: <?php echo $data['user']->subscribers; ?></p>
<br><br>

<h1 style="text-decoration: underline;">Avatar</h1><br>
<img src="<?php echo IMG.'default_user.png'; ?>">
<form method="post" action="" role="form" enctype="multipart/form-data">
	<input type="file" id="avatar" name="avatar" />
</form>
<br><br>