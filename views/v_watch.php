<?php

?>

<div class="container">
	<div class="container" style="">
		<div class="border-top"></div>
			<h1><?php echo secure($title); ?><small> <?php echo $lang['by']; ?> <a href="#"><?php echo secure($author->getName() ); ?></a></small></h1>
		<div class="border-bottom"></div>

		<br><br>
	</div>

	<div class="container" style="">
		<div id="player">
			<video autobuffer preload="auto" poster="<?php echo ($tumbnail != '') ? secure($tumbnail) : secure($path).'.jpg'; ?>" autoplay><img src="img/loadervids.gif" alt="" /><br><b><?php echo $lang['loading_video']; ?></video>
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
if (isset($session) && $session->getId() != $author->getId() )
{
	if (in_array($author->getId(), $session->getSubscriptions() ) )
	{
?>
<button id="subscribe-<?php echo secure($author->getId() ); ?>" class="btn btn-danger" data-subscribe="S'abonner" data-unsubscribe="Abonné" data-onmouseover="Se désabonner" data-subscribers="<?php echo secure($author->getSubscribers() ); ?>" onclick="unsubscribe(<?php echo secure($author->getId() ); ?>)" onmouseover="this.innerHTML=this.getAttribute('data-onmouseover')" onmouseout="this.innerHTML=this.getAttribute('data-unsubscribe')">Abonné</button>
<?php 
	}
	else
	{
?>
<button id="subscribe-<?php echo secure($author->getId() ); ?>" class="btn btn-success" data-subscribe="S'abonner" data-unsubscribe="Abonné" data-onmouseover="Se désabonner"data-subscribers="<?php echo secure($author->getSubscribers() ); ?>" onclick="subscribe(<?php echo secure($author->getId() ); ?>)">S'abonner (<?php echo secure($author->getSubscribers() ); ?>)</button>
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
	<script src="utils/videoinfo.php?vid=<?php echo secure($id); ?>"></script>
<!-- End -->