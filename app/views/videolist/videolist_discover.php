<div class="content">
		<aside class="aside-cards-list">
		<h3 class="title">Découvrir - Videos aléatoires</h3>
		
		<?php foreach ($vids as $vid): ?>
			<div class="card video">
				<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/up/350/200/1">
					<div class="time"><?php echo $vid->duration; ?></div>
					<a href="<?php echo WEBROOT.'watch/'.$vid->id; ?>" class="overlay"></a>
				</div>
				<div class="description">
					<a href="<?php echo WEBROOT.'watch/'.$vid->id; ?>"><h4><?php echo $vid->title; ?></h4></a>
					<div>
						<span class="view"><?php echo $vid->views; ?></span>
						<a class="channel" href="channel"><?php echo UserChannel::getNameById($vid->poster_id); ?></a>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	</aside>
</div>