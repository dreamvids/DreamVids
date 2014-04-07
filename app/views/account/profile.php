<div class="content">

	<section class="profile">
		<h1 class="title">Espace membre</h1>

		<nav class="tabs four">
			<ul>
				<li class="current"><a href="<?php echo WEBROOT.'account'; ?>">Mon compte</a></li>
				<li><a href="<?php echo WEBROOT.'account/password'; ?>">Mot de passe</a></li>
				<li><a href="<?php echo WEBROOT.'account/videos'; ?>">Mes vidéos</a></li>
				<li><a href="<?php echo WEBROOT.'account/channels'; ?>">Chaînes</a></li>
				<li><a href="<?php echo WEBROOT.'account/messages'; ?>">Messagerie</a></li>
			</ul>
		</nav>

		<?php if(isset($error)) { ?>
			<p style="color: #f00;"><?php echo $error ?></p>
			<br>
		<?php } ?>

		<?php if(isset($success)) { ?>
			<p style="color: #0f0;"><?php echo $success ?></p>
			<br>
		<?php } ?>

		<form class="form" method="post" action="" enctype="multipart/form-data">
			<label for="email">Adresse email :</label>
			<input value="<?php echo $mail; ?>" type="text" name="email" placeholder="Adresse email"><br />

			<label for="username">Pseudo :</label>
			<input value="<?php echo $username; ?>" type="text" name="username" placeholder="Pseudo"><br />

			<label for="avatar">
				<img class="preview filePreview" src="<?php if(isset($avatarPath) && $avatarPath != '') echo $avatarPath; ?>">
				Avatar :
			</label>
			<input type="file" name="avatarFile" accept="image/*"><br />

			<label for="channelBgFile">
				<img class="preview filePreview" src="<?php if(isset($bgPath) && $bgPath != '') echo $bgPath; ?>">
				Arrière-plan :
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