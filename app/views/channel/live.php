<div class="content">
	<h1 class="title">Live de <?php echo $channel->name; ?></h1>

	<?php if ($onAir): ?>
		<video id="live-player" class="video-js vjs-default-skin" controls preload="auto" width="640" height="360" data-setup='{ "techOrder": ["flash"] }'>
			<source src="<?php echo Config::getValue_('livestream-source').$liveKey; ?>" type='rtmp/flv'>
		</video>

	<?php endif ?>

	<?php if (!$onAir): ?>
		<p>Aucun live sur cette chaîne</p>
	<?php endif ?>
</div>