<div class="content">

	<section class="">
		<h1 class="title">Ajouter une chaîne</h1>

		<nav class="tabs four">
			<ul>
				<li><a href="<?php echo WEBROOT.'account'; ?>">Mon compte</a></li>
				<li><a href="<?php echo WEBROOT.'account/password'; ?>">Mot de passe</a></li>
				<li><a href="<?php echo WEBROOT.'account/videos'; ?>">Mes vidéos</a></li>
				<li class="current"><a href="<?php echo WEBROOT.'account/channels'; ?>">Chaînes</a></li>
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

		<form class="form" method="post" action="">
			<label for="name">Nom :</label>
			<input value="<?php echo @$name; ?>" type="text" name="name" required="required" id="name" placeholder="Nom de votre chaîne" /><br />
			
			<label for="description">Description :</label>
			<textarea rows="8" cols="50" required="required" name="description" id="description"><?php echo @$description; ?></textarea><br />
			
			<input type="submit" name="createChannelSubmit" value="Créer la chaîne" />
		</form>
	</section>

</div>