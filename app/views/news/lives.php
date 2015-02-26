<div class="content">
	<aside class="full-cards-list">
		<h3 class="title">Lives en cours</h3>

<?php
	if (count($lives) > 0) {
		foreach ($lives as $live) {
			$channel = UserChannel::find($live->channel_id);
?>
		<div class="card video card--live">
			<div class="thumbnail bg-loader" data-background-load-in-view data-background="<?php echo $channel->avatar; ?>">
				<a href="<?php echo WEBROOT.'lives/'.$channel->name; ?>" class="overlay"></a>
			</div>
			<div class="description">
				<a href="<?php echo WEBROOT.'lives/'.$channel->name; ?>"><h4>Live de <?php echo $channel->name; ?></h4></a>
				<div>
					<span class="view"><?php echo $live->viewers; ?> visionneur<?php echo ($live->viewers) > 1 ? 's' : ''; ?> en ligne</span>
					<a class="channel" href="<?php echo WEBROOT.'channel/'.$channel->name; ?>"><?php echo $channel->name; ?></a>
				</div>
			</div>
		</div>
<?php
		}
	}
	else {
?>
	<div class="message error">
			<div class="message-icn"><img src="<?php echo IMG . 'message_error_icon.png'; ?>" alt="Message d'erreur"></div>
			<p>Aucun live en cours pour le moment. <a href="<?php echo WEBROOT.'lives'; ?>">Commencez-en un !</a></p>
	</div>
<?php
	}
?>
	</aside>
</div>