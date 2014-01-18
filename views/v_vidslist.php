<div class="container">
	<div class="container">
		<div class='border-top'></div>
		<h1><?php echo $title; ?></h1>
		<div class='border-bottom'></div>
	</div>

	<br><br>

	<div class="container">
		<div class="row">
<?php
foreach ($vids as $vid)
{
?>
			<div class="col-sm-6 col-md-3">
			    <a href="#" class="thumbnail" style="width: 171px; height:113px;">
			      <img data-src="holder.js/171x110" src="img/videos/video.png">
			    </a>
				<p style="margin-left: 3%;"><?php echo '<b>'.$vid->getTitle().'</b>'; ?></p>
			    <img src="img/videos/user.png" style="width: 32px; height: 32px;">
			    <p style="display: inline-block; margin-left: 3%;"><?php echo User::getNameById($vid->getUserId() ); ?></p>
			    <p style="display: ;"><?php echo (strlen($vid->getDescription() ) > 30) ? substr($vid->getDescription(), 0, 30).'...' : $vid->getDescription(); ?></p>
			    <p style="display: inline-block; margin-top: -3%;"><?php echo $vid->getLikes().' '.$lang['likes'].' - '.$vid->getDislikes().' '.$lang['dislikes']; ?></p>
		 	</div>
<?php
}
?>
		</div>
	</div>
</div>