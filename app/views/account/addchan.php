<div class="content">

	<section class="">
		<h1 class="title">Chaînes</h1>

		<nav class="tabs four">
			<ul>
				<li><a href="<?php echo WEBROOT.'account'; ?>">Mon compte</a></li>
				<li><a href="<?php echo WEBROOT.'account/password'; ?>">Mot de passe</a></li>
				<li><a href="<?php echo WEBROOT.'account/videos'; ?>">Mes vidéos</a></li>
				<li class="current"><a href="<?php echo WEBROOT.'account/channels'; ?>">Chaînes</a></li>
				<li><a href="<?php echo WEBROOT.'account/messages'; ?>">Messagerie</a></li>
			</ul>
		</nav>

		<form class="form" method="post" action="">
			<label for="name">Nom :</label>
			<input type="text" name="name" id="name" placeholder="Nom de votre chaîne" /><br />
			
			<label for="description">Description :</label>
			<textarea rows="8" cols="50" name="description" id="description"></textarea><br />
			
			<input type="submit" name="createChannelSubmit" value="Créer la chaîne" />
	</section>

</div>