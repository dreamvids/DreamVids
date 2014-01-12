<?php

?>

<div class='container'>
	<div class="container" style=''>
		<div class='border-top'></div>
			<h1><?php echo $title; ?><small> de <a href='#'><?php echo $author; ?><a></small></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class='container' style=''>

		<video id="video_player" class="video-js vjs-default-skin"
		controls preload="auto" width="640" height="360" data-setup='{"video":true}'>
			<source src="<?php echo $path.'.mp4'; ?>" type='video/mp4' />
			<source src="<?php echo $path'.webm'; ?>" type='video/webm' />
			<source src="<?php echo $path; ?>" type='video/mp4' />
		</video>
	</div>

	<br>

	<div class="container">
		<div class="panel panel-primary" style="width: 56%;">
			<div class="panel-heading">
				Description
			</div>
			<div class="panel-body">
				<?php echo bbcode(secure($desc)); ?>
			</div>
		</div>
	</div>
</div>
