<<<<<<< HEAD
<?php echo $subscribed; ?>

<div class="content wide channel">
	<div class="bgLoader" id="background-wide" data-background="<?php echo IMG.'backgrounds/003.jpg'; ?>"></div>
=======
<div class="content wide channel">
	<div class="bgLoader" id="background-wide" data-background="<?php echo $background; ?>"></div>
>>>>>>> dreamvids-2.0-dev

	<section class="inner">
		<ul class="top">
			<li><b><?php echo $subscribers; ?></b> Abonnés</li>
			<li><b><?php echo count($videos); ?></b> Vidéos</li>
		</ul>

		<div class="left">
			<span class="bgLoader" data-background="http://lorempicsum.com/up/350/200/6"></span>
			<p><?php echo $name; ?></p>
<<<<<<< HEAD
			<button <?php if($subscribed) echo 'class="subscribed"'; ?> id="subscribe-button" data-text="S'abonner|Se désabonner" onclick="subscribeAction('<?php echo $id; ?>')">
				<?php echo $subscribed ? 'Se désabonner' : 'S\'abonner'; ?>
			</button>
=======

			<?php if(!$isUsersChannel): ?>
				<?php if (Session::isActive()) { ?>
					<button <?php if($subscribed) echo 'class="subscribed"'; ?> id="subscribe-button" data-text="S'abonner|Se désabonner" onclick="subscribeAction('<?php echo $id; ?>')">
						<?php echo $subscribed ? 'Se désabonner' : 'S\'abonner'; ?>
					</button>
				<?php } else { ?>
					<a href="<?php echo WEBROOT.'login' ?>">Connectez-vous</a> pour vous abonner a cette chaîne !
				<?php } ?>
			<?php endif ?>
>>>>>>> dreamvids-2.0-dev
		</div>

		<?php if($description != '') { ?>
			<div class="right">
				<?php echo $description; ?>
			</div>
		<?php } ?>
	</section>
</div>

<div class="content">
	<nav class="tabs">
		<ul>
			<li><a href="<?php echo WEBROOT.'channel/'.$name; ?>">Vidéos</a></li>
<<<<<<< HEAD
			<li class="channel/current"><a href="<?php echo WEBROOT.'channel/social/'.$name; ?>">Social</a></li>
=======
			<li class="channel/current"><a href="<?php echo WEBROOT.'channel/'.$name.'/social/'; ?>">Social</a></li>
>>>>>>> dreamvids-2.0-dev
		</ul>
	</nav>

	<?php if ($isUsersChannel): ?>
		<h2>Poster un message</h2>
<<<<<<< HEAD
		<form method="post" action="">
			<textarea rows="5" cols="65" name="post-content"></textarea><br>
			<input type="submit" value="Envoyer le message" name="post-message-submit" />
=======
		<form method="post" action="<?php echo WEBROOT.'posts'; ?>" onsubmit="return false;">
			<textarea rows="5" cols="65" id="post-content"></textarea><br>
			<input type="hidden" name="channel" id="channel" value="<?php echo $id; ?>" />
			<button class="blue" onclick="postMessage('<?php echo $id; ?>', document.getElementById('post-content').value)">Envoyer</button>
>>>>>>> dreamvids-2.0-dev
		</form>

		<br><br>
	<?php endif ?>

<<<<<<< HEAD
	<aside class="">
=======
	<aside class="" id="channel-posts">
>>>>>>> dreamvids-2.0-dev
		<?php foreach($posts as $post) { ?>
			<div class="channel-post" style="background-color: #40a6e0; width: 50%; padding: 10px; margin-bottom: 1%;"> <!-- Please Dimou, dont kill me ;( -->
				<?php echo $post->content; ?>
			</div>
		<?php } ?>
	</aside>
</div>