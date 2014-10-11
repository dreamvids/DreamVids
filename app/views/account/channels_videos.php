<div class="content">

	<section class="profile">
		<h1 class="title">Espace membre</h1>

		<?php
			include VIEW.'layouts/account_menu.php';
		?>

		<?php @include $messages; ?>

		<aside class="long-cards-list">

			<?php
			if(!empty($channel)) { 
				foreach($channel as $chan) { ?>

				<div class="card channel long">
					<a href="<?php echo WEBROOT.'account/videos/'.$chan->id; ?>">
						<div class="avatar bg-loader" data-background="<?php echo $chan->getBackground(); ?>"></div>
					</a>
	
					<div class="description">
						<a href="<?php echo WEBROOT.'account/videos/'.$chan->id; ?>"><b>Vidéos de la chaîne "<?php echo $chan->name; ?>"</b></a>
						<a href="<?php echo WEBROOT.'channel/'.$chan->id; ?>"><button>Acceder à la chaine</button></a>
						<b class="note"><?php echo $chan->views; ?> vues</b>
						<span class="subscriber"><b><?php echo $videos_count[$chan->id]; ?></b> vidéos</span>
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