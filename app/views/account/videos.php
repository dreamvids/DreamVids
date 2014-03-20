<div class="content">

	<section class="profile">
		<h1>Espace membre</h1>

		<nav class="tabs four">
			<ul>
				<li><a href="<?php echo WEBROOT.'account'; ?>">Mon compte</a></li>
				<li><a href="<?php echo WEBROOT.'account/password'; ?>">Mot de passe</a></li>
				<li class="current"><a href="<?php echo WEBROOT.'account/videos'; ?>">Mes vidéos</a></li>
				<li><a href="<?php echo WEBROOT.'account/channels'; ?>">Chaînes</a></li>
				<li><a href="<?php echo WEBROOT.'account/messages'; ?>">Messagerie</a></li>
			</ul>
		</nav>

		<aside class="long-cards-list">

			<?php if(!empty($videos)) { ?>
			<?php foreach($videos as $video) { ?>

			<div class="card video long">
				<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/up/350/200/1">
					<!--<div class="time">12:05</div>-->
					<a href="<?php echo WEBROOT.'watch/'.$video->id; ?>" class="overlay"></a>
				</div>
				<div class="description">
					<a href="<?php echo WEBROOT.'watch/'.$video->id; ?>"><h4><?php echo $video->title; ?></h4></a>
					<span class="buttons">
						<button>Paramètres</button>
						<button>Supprimer</button>
					</span>
					<div><span class="view"><?php echo $video->views; ?></span><span class="plus"><?php echo $video->likes; ?></span><span class="moins"><?php echo $video->dislikes; ?></span></div>
				</div>
			</div>

			<?php } ?>
			<?php } else echo "Vous n'avez pas encore mis de vidéo en ligne"; ?>

			<!--<nav class="pagination">
				<ul>
					<a href="?page=2"><li>Précédent</li></a>
					<li class="current">3</li>
					<a href="?page=4"><li>4</li></a>
					...
					<a href="?page=11"><li>11</li></a>
					<a href="?page=12"><li>12</li></a>
					<a href="?page=4"><li>Suivant</li></a>
				</ul>
			</nav>-->
		</aside>
	</section>

</div>