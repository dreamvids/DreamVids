<nav class="tabs four">
	<ul>
		<li <?php echo (isset($current) && $current == 'account') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account'; ?>">Adresse E-Mail</a></li>
		<li <?php echo (isset($current) && $current == 'password') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/password'; ?>">Mot de passe</a></li>
		<li <?php echo (isset($current) && $current == 'videos') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/videos'; ?>">Mes vidéos</a></li>
		<li <?php echo (isset($current) && $current == 'channels') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/channels'; ?>">Chaînes</a></li>
		<li <?php echo (isset($current) && $current == 'messages') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/messages'; ?>">Messagerie</a></li>
	</ul>
</nav>