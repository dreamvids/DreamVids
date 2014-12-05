<div class="content">
	<div id="video-top-infos">
		<div id="video-top-title">
			<div id="video-top-channel">
				<img src="<?php echo $channel->getAvatar(); ?>">
				<?php if (Session::get()->getMainChannel()->id != $channel->id) { ?>
				<span id="hover_subscribe" data-channel="<?php echo $channel->id; ?>" class="<?php echo $subscribed ? 'subscribed' : ''; ?>">
					<i><?php echo $subscribed ? 'Abonné': 'S\'abonner'; ?></i>
				</span>
				<?php } ?>
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
				<source src="<?php echo Config::getValue_('livestream-source').$channel->name; ?>" type='rtmp/flv' />
			</video>
		</div>
	<?php }

	else { ?>
		<div id="player" class="live-offline">
			<div class="live-offline__image"></div>
		</div>
	<?php } ?>

	<section class="video-infos live <?php if (!$onAir) { echo "live--offline"; } ?>">

		<div class="views" id="viewers"><?php echo $viewers; ?> viewers</div>

		<hr>

		<div class="live-chat">

			<div class="live-chat__messages" id="messages-panel"></div>
			
			<form class="live-chat__form" method="post" onsubmit="return false;" onclick="document.getElementById('live-chat-input').focus();">

				<input class="live-chat__form__input" id="live-chat-input" type="text" placeholder="Message">

			</form>

		</div>

	</section>

	<section class="share-live-block">

		<div class="inner-export">

			Intégrer ce live

			<br>
			<br>

			<input id="exporter-input" onclick="this.select();" type="text" spellcheck="false" value='<iframe width="640" height="360" src="//v2.dreamvids.fr/embed/live/<?php echo $channel->name; ?>" allowfullscreen frameborder="0"></iframe>'>

		</div>

	</section>
	
</div>

<script>
	var channelId = '<?php echo $channel->id; ?>';
	var chatLiveOptions = {
		ip: '<?php echo Config::getValue_('livechat-address'); ?>',
		port: <?php echo Config::getValue_('livechat-port'); ?>,
		channel: '<?php echo $channel->name; ?>',
		username: '<?php echo Session::get()->username; ?>',
		sessionId: '<?php echo Session::getId(); ?>'
	};

</script>
