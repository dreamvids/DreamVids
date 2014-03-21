<div class="content">

	<section class="profile">
		<h1>Espace membre</h1>

		<nav class="tabs four">
			<ul>
				<li class="current"><a href="<?php echo WEBROOT.'account'; ?>">Mon compte</a></li>
				<li><a href="<?php echo WEBROOT.'account/password'; ?>">Mot de passe</a></li>
				<li><a href="<?php echo WEBROOT.'account/videos'; ?>">Mes vidéos</a></li>
				<li><a href="<?php echo WEBROOT.'account/channels'; ?>">Chaînes</a></li>
				<li><a href="<?php echo WEBROOT.'account/messages'; ?>">Messagerie</a></li>
			</ul>
		</nav>

		<form method="post" action="" enctype="multipart/form-data">
			<label for="email">Adresse email :</label>
			<input value="<?php echo $user->email; ?>" type="text" name="email" placeholder="Adresse email"><br />

			<label for="username">Pseudo :</label>
			<input value="<?php echo $user->username; ?>" type="text" name="username" placeholder="Pseudo"><br />

			<label for="avatar">
				<img class="preview" src="https://fr.gravatar.com/userimage/57826048/c82ae77d5ac9635e8ace8071f81941b9.png?size=100">
				Avatar :
			</label>
			<input type="file" name="avatarFile" accept="image/*"><br />

			<label for="channelBgFile">
				<img class="preview" src="http://dreamvids.fr/uploads/Dimou/background.JPG">
				Avatar :
			</label>
			<input type="file" name="channelBgFile" accept="image/*"><br />

			<!--<label for="language">Langue :</label>
			<select name="language">
				<option value="fr">Français</option>
				<option value="en">Anglais</option>
			</select>-->

			<input type="submit" name="profileSubmit" value="Enregistrer">
		</form>
	</section>

</div>