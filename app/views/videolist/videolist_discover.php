<h1></h1>
<?php foreach ($vids as $video) {
	?>

	<a style="color: #000; "href='<?php echo WEBROOT.'watch/'.$video->id; ?>'><?php echo $video->title; ?></a>
	<br>

	<?php
} ?>