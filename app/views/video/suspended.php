<div id="suspended-icn">
	<div id="cross">
		<div class="cross-bar" id="cross-bar-1"></div>
		<div class="cross-bar" id="cross-bar-2"></div>
	</div>
</div>
<div id="suspended-text">
	<h2>La vidéo <span class="video-name"><?php echo $video->title; ?></span> à été suspendue.</h2>
	<p>Retour à la chaîne :</p>
	<div class="channel-access">
		<img src="<?php echo $author->getAvatar(); ?>" alt="Avatar de la chaîne">
		<p><?php echo $author->name; ?></p>
		<a href="<?php echo WEBROOT.'channel/'.$author->id; ?>"><div class="channel-access-btn"><img src="<?php echo IMG.'arrow_right.png'; ?>" alt="Allez sur la chaîne"></div></a>
	</div>
	
	
<?php if (Session::isActive() && (Session::get()->isModerator() || Session::get()->isAdmin())) { ?>
	<form method="post" action="" role="form" class="moderating-commands" onsubmit="return false">
		<button class="blue" onclick="unSuspendVideo('<?php echo $video->id; ?>')">Ré-activer</button>
	</form>
<?php } ?>
</div>