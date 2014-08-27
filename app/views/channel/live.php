<div class="content">
	<div id="video-top-infos">
		<div id="video-top-title">
			<div id="video-top-channel">
				<img src="<?php echo $channel->getAvatar(); ?>">
				<span id="hover_subscribe" data-channel="<?php echo $channel->id; ?>" class="<?php echo $subscribed ? 'subscribed' : ''; ?>">
					<i><?php echo $subscribed ? 'Abonné': 'S\'abonner'; ?></i>
				</span>
				<div id="video-top-channel-infos">
					<a id="video-top-pseudo" href="<?php echo WEBROOT.'channel/'.$channel->id; ?>" class="<?php echo $channel->isVerified() ? 'validate' : ''; ?>">
						<?php echo $channel->name; ?>
					</a>
					<hr>
					<p id="video-top-abonnes"><span class="strong"><?php echo $subscribers; ?></span> abonnés</p>
				</div>
			</div>
			<h1 class="<?php echo ($onAir) ? 'live' : 'title'; ?>">Live de <?php echo $channel->name; ?></h1>
		</div>
	</div>
	
	<?php if ($onAir) { ?>
	<div id="player">
		<video id="live-player" class="video-js vjs-default-skin" controls preload="auto" width="640" height="360" data-setup='{ "techOrder": ["flash"] }'>
			<source src="<?php echo Config::getValue_('livestream-source').$liveKey; ?>" type='rtmp/flv' />
		</video>
	</div>
	<?php } ?>

	<?php if (!$onAir) { ?>
		<p>Aucun live sur cette chaîne</p>
	<?php } ?>

	<section class="video-infos live">

		<b>CHAT</b>

	</section>
	
</div>

