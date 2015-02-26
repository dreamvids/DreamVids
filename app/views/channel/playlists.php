<?php
include VIEW.'/layouts/channel_header.php';
?>
<div class="content">
	<aside class="full-cards-list">
	<?php
	foreach ($playlists as $play) {
	?>
		<div class="card video">
			<div class="thumbnail bg-loader" data-background="<?php echo Config::getValue_('default-thumbnail'); ?>">
				<div class="time"><?php echo count(json_decode($play->videos_ids)); ?> Vidéos</div>
				<a href="<?php echo WEBROOT.'playlists/'.$play->id.'/watch'; ?>" class="overlay"></a>
			</div>
			<div class="description">
				<a href="<?php echo WEBROOT.'playlists/'.$play->id.'/watch'; ?>"><h4><?php echo $play->name; ?></h4></a>
			</div>
		</div>
	<?php
	}
	?>
	</aside>
</div>