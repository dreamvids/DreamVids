<h1>Feed</h1><br><br>

<?php foreach($vids as $vid) { ?>

<div class="vid">
	<h3><a  style="color: #000;" href="<?php echo WEBROOT.'watch/'.$vid->id; ?>"><?php echo $vid->title; ?></a></h3>
</div>

<?php } ?>