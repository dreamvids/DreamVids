<div class="content">

	<section class="profile">
		<h1 class="title">Espace membre</h1>

		<?php
			include VIEW.'layouts/account_menu.php';
		?>

		<?php @include $messages; ?>

		<aside class="long-cards-list">
			<h3 class="title">Choisissez la chaine pour dont vous souhaitez gérer les vidéos</h3>
			<?php
			if(!empty($channel)) { 
				foreach($channel as $chan) { ?>

				<div class="card video">
					<div class="thumbnail bg-loader" data-background="<?php echo $chan->getBackground(); ?>">
						<div class="time"><?php echo $videos_count[$chan->id]; ?></div>
						<a href="<?php echo WEBROOT.'account/videos/'.$chan->id; ?>" class="overlay"></a>
					</div>
					<div class="description">
						<a href="<?php echo WEBROOT.'account/videos/'.$chan->id; ?>"><h4>Vidéos de la chaîne "<?php echo $chan->name; ?>"</h4></a>
						<div>
							<span class="view"><?php echo $chan->views; ?></span>
							<a class="channel" href="#"></a>
						</div>
					</div>
				</div>
	
			<?php }
			}
			?>

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