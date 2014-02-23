<h1>Chaîne de <?php echo $data['name']; ?></h1><br><br>

<h1>Abonnés: <?php echo $data['subscribers']; ?></h1><br><br>

<h1>Videos</h1><br>

<?php foreach ($data['videos'] as $video) { ?>
	<a href="<?php echo WEBROOT.'watch/'.$video->id; ?>"><?php echo $video->title; ?></a><br>
<?php } ?>