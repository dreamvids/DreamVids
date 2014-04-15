<div class="content">

	<section class="">
		<h1 class="title">Chaînes</h1>

		<nav class="tabs four">
			<ul>
				<li><a href="<?php echo WEBROOT.'account'; ?>">Mon compte</a></li>
				<li><a href="<?php echo WEBROOT.'account/password'; ?>">Mot de passe</a></li>
				<li><a href="<?php echo WEBROOT.'account/videos'; ?>">Mes vidéos</a></li>
				<li class="current"><a href="<?php echo WEBROOT.'channels'; ?>">Chaînes</a></li>
				<li><a href="<?php echo WEBROOT.'account/messages'; ?>">Messagerie</a></li>
			</ul>
		</nav>
		
		<?php include VIEW.'layouts/messages.php'; ?>

		<span class="buttons">
		    <a href="<?php echo WEBROOT.'channels/add'; ?>">
			    <button>
			        Ajouter une chaîne
			    </button>
			</a>
    	</span>
	</section>

</div>