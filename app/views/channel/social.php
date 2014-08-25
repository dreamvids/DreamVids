<div class="content wide channel">
	<div class="bg-loader" id="background-wide" data-background="<?php echo $background; ?>"></div>

	<section class="inner">
		<ul class="top">
			<li><b><?php echo $subscribers; ?></b> Abonnés</li>
			<li><b><?php echo count($videos); ?></b> Vidéos</li>
		</ul>

		<div class="left">
			<span class="bg-loader" data-background="<?php echo $avatar; ?>"></span>

			<p><?php echo $name; ?></p>

			<?php if(!$isUsersChannel): ?>
				<?php if (Session::isActive()) { ?>
					<button <?php if($subscribed) echo 'class="subscribed"'; ?> id="subscribe-button" data-text="S'abonner|Se désabonner" onclick="subscribeAction('<?php echo $id; ?>')">
						<?php echo $subscribed ? 'Se désabonner' : 'S\'abonner'; ?>
					</button>
				<?php } else { ?>
					<a href="<?php echo WEBROOT.'login' ?>">Connectez-vous</a> pour vous abonner a cette chaîne !
				<?php } ?>
			<?php endif ?>
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
			<li class="channel"><a href="<?php echo WEBROOT.'channel/'.$name; ?>">Vidéos</a></li>
			<li class="current"><a href="<?php echo WEBROOT.'channel/'.$name.'/social/'; ?>">Social</a></li>
		</ul>
	</nav>

	<?php if ($isUsersChannel) { ?>

		<form class="social-message-form" method="post" action="<?php echo WEBROOT.'posts'; ?>" onsubmit="return false;">

			<input type="hidden" name="channel" id="channel" value="<?php echo $id; ?>" />
			<div class="form-header-container">
				<span class="form-icn"><img src="<?php echo IMG.'/comment_icon.png'; ?>"></span>
				<span class="text">Poster un message</span>
				<button class="blue" onclick="postMessage('<?php echo $id; ?>', document.getElementById('post-content').value)"><img src="<?php echo IMG.'/post_comment_icon.png'; ?>" alt="Poster le message"></button>
			</div>
			<textarea id="post-content" rows="4" cols="10" placeholder="Message"></textarea>

		</form>

		<br><br>
	<?php } ?>

	<aside id="channel-posts">
		<?php foreach($posts as $post) { ?>
			<div class="channel-post"> 
				<img src="<?php echo $avatar ?>" alt="Avatar" />
				<p><span class="channel-name"><?php echo $name; ?></span> a posté un message :</p>
				<div class="social-message"><?php echo $post->content; ?></div>
			</div>
		<?php } ?>
	</aside>
</div>