<div class="content wide channel">
<<<<<<< HEAD
	<div class="bgLoader" id="background-wide" data-background="<?php echo IMG.'backgrounds/003.jpg'; ?>"></div>
=======
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

			<?php if(!$channelBelongsToUser): ?>
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
			<li class="channel/current"><a href="<?php echo WEBROOT.'channel/'.$name; ?>">Vidéos</a></li>
<<<<<<< HEAD
			<li><a href="<?php echo WEBROOT.'channel/social/'.$name; ?>">Social</a></li>
=======
			<li class="channel/current"><a href="<?php echo WEBROOT.'channel/'.$name.'/social/'; ?>">Social</a></li>
>>>>>>> dreamvids-2.0-dev
		</ul>
	</nav>

	<aside class="full-cards-list">

		<?php foreach($videos as $vid) { ?>
			<div class="card video">
				<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/up/350/200/1">
					<!--<div class="time">12:05</div>-->
					<a href="<?php echo WEBROOT.'watch/'.$vid->id; ?>" class="overlay"></a>
				</div>
				<div class="description">
					<a href="<?php echo WEBROOT.'watch/'.$vid->id; ?>"><h4><?php echo $vid->title; ?></h4></a>
					<div>
						<span class="view"><?php echo $vid->views; ?></span>
						<a class="channel" href="<?php echo WEBROOT.'channel/'.UserChannel::getNameById($vid->poster_id); ?>"><?php echo UserChannel::getNameById($vid->poster_id); ?></a>
					</div>
				</div>
			</div>
		<?php } ?>
	</aside>
</div>