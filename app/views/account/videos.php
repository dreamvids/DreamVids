<div class="content">

	<section class="profile">
		<h1 class="title">Espace membre</h1>

		<?php
			include VIEW.'layouts/account_menu.php';
		?>

		<?php @include $messages; ?>

		<aside class="long-cards-list">

			<?php if(!empty($videos)) { 
				foreach($videos as $video) {
			?>
			<div class="card video long">
				<div class="thumbnail bg-loader" data-background="<?php echo $video->getThumbnail(); ?>">
					<!--<div class="time">12:05</div>-->
					<a href="<?php echo WEBROOT.'watch/'.$video->id; ?>" class="overlay"></a>
				</div>
				<div class="description">
					<a href="<?php echo WEBROOT.'watch/'.$video->id; ?>"><h4><?php echo $video->title; ?></h4></a>
					<span class="buttons">
						<a href="<?php echo WEBROOT.'videos/'.$video->id.'/edit'; ?>"><button>Paramètres</button></a>
						<button class="orange" onclick="eraseVideo('<?php echo $video->id; ?>')">Supprimer</button>
					</span>
					<div><span class="view"><?php echo $video->views; ?></span><span class="plus"><?php echo $video->likes; ?></span><span class="moins"><?php echo $video->dislikes; ?></span></div>
				</div>
			</div>
			<?php
				} 
			}?>

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