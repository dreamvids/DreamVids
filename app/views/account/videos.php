<h1>Videos</h1>
<br><br>

<div class="video-list">
	<?php
	if(!empty($videos)) {
		foreach($videos as $vid) {
	?>

	<div class="video-box">
		<a style="color: #000;" href="<?php echo WEBROOT.'watch/'.$vid->id; ?>"><?php echo $vid->title; ?></a>
	</div>

	<?php
		}
	}
	else
		echo "Vous n'avez pas encore mis de vidéo en ligne";
	?>
</div>