<div class="content wide channel">
	<div class="bgLoader" id="background-wide" data-background="<?php echo IMG.'backgrounds/003.jpg'; ?>"></div>

	<section class="inner">
		<ul class="top">
			<li><b><?php echo $subscribers; ?></b> Abonnés</li>
			<li><b><?php echo count($videos); ?></b> Vidéos</li>
		</ul>

		<div class="left">
			<span class="bgLoader" data-background="http://lorempicsum.com/up/350/200/6"></span>
			<p><?php echo $name; ?></p>
			<button id="subscribe-button" data-text="S'abonner|Se désabonner">S'abonner</button>
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
			<li><a href="#">Social</a></li>
		</ul>
	</nav>

	<aside class="full-cards-list">

		<?php foreach($videos as $vid) { ?>
			<div class="card video">
				<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/up/350/200/1">
					<!--<div class="time">12:05</div>-->
					<a href="video" class="overlay"></a>
				</div>
				<div class="description">
					<a href="video"><h4><?php echo $vid->title; ?></h4></a>
					<div>
						<span class="view"><?php echo $vid->views; ?></span>
						<a class="channel" href="<?php echo WEBROOT.'channel/'.User::getNameById($vid->poster_id); ?>"><?php echo User::getNameById($vid->poster_id); ?></a>
					</div>
				</div>
			</div>
		<?php } ?>
	</aside>
</div>