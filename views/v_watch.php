<?php

?>

<div class="container">
	<div class="container" style="">
		<div class="border-top"></div>
			<h1><?php echo $title; ?><small> <?php echo $lang['by']; ?> <a href="#"><?php echo $author->getName(); ?></a></small></h1>
		<div class="border-bottom"></div>

		<br><br>
	</div>

	<div class="container" style="">
		<div id="player">
			<video autobuffer preload="auto" autoplay><img src="img/loadervids.gif" alt="" /><br><b><?php echo $lang['loading_video']; ?></video>
			<span id="repeat">
				<span class="icon"></span>
			</span>
			<span id="qualitySelection" class="show"></span>
			<span id="bigPlay"></span>
			<span id="bigPause"></span>
			<div id="controls">
				<span id="progress">
					<span id="buffered"></span>
					<span id="viewed"></span>
					<span id="current"></span>
				</span>
				<span id="play-pause"></span>
				<span id="time"></span>
				<span id="qualityButton">SD</span>
				<span id="volume">
					<span id="barre"></span>
					<span id="icon"></span>
				</span>
				<span id="fullscreen"></span>
			</div>
		</div>
	</div>

	<br />
	
	<div class="container">
<?php
if ($session->getId() != $author->getId() )
{
	if (in_array($author->getId(), $session->getSubscriptions() ) )
	{
?>
<button id="subscribe-<?php echo $author->getId(); ?>" class="btn btn-danger" data-subscribe="S'abonner" data-unsubscribe="Abonné" data-onmouseover="Se désabonner" data-subscribers="<?php echo $author->getSubscribers(); ?>" onclick="unsubscribe(<?php echo $author->getId(); ?>)" onmouseover="this.innerHTML=this.getAttribute('data-onmouseover')" onmouseout="this.innerHTML=this.getAttribute('data-unsubscribe')">Abonné</button>
<?php 
	}
	else
	{
?>
<button id="subscribe-<?php echo $author->getId(); ?>" class="btn btn-success" data-subscribe="S'abonner" data-unsubscribe="Abonné" data-onmouseover="Se désabonner"data-subscribers="<?php echo $author->getSubscribers(); ?>" onclick="subscribe(<?php echo $author->getId(); ?>)">S'abonner (<?php echo $author->getSubscribers(); ?>)</button>
<?php 
	}
}
?>
		<br /><br />
		<div class="panel panel-primary" style="width: 56%;">
			<div class="panel-heading">
				<?php echo $lang['desc']; ?>
			</div>
			<div class="panel-body">
				<?php echo bbcode(secure($desc)); ?>
			</div>
		</div>
	</div>
</div>
<!-- video player body-->
	<script src="dreamplayer/js/player.js"></script>
	<script src="utils/videoinfo.php?vid=<?php echo $id; ?>"></script>
<!-- End -->