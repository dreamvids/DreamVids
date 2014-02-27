<div id="bottom">
	<aside id="aside-channels">
		<h3>Mes abonnements</h3>
		<ul class="limited" id="list-flux-channels">

			<?php foreach($subscriptions as $sub) { ?>

			<a href="<?php echo WEBROOT.'feed/'.$sub->id; ?>" class="channels">
				<span style="background-image: url(http://lorempicsum.com/simpsons/255/200/2)" class="avatar"></span>
				<span class="name" href="#"><?php echo $sub->username; ?></span>
				<p class="subscribers"><b><?php echo $sub->subscribers; ?></b> Abonnés</p>
			</a>

			<?php } ?>

			<input type="checkbox" onclick="toogleFluxChannelVisibility(this.checked)"/>
			<span class="ch-more">Voir tout</span>
			<span class="ch-less">Voir moins</span>
		</ul>
	</aside>

	<aside id="aside-flux">
		<h3>Flux d'activité</h3>
		
		<?php foreach ($vids as $vid) { ?>

		<div class="card video">
			<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/up/350/200/1">
				<div class="time">12:05</div>
				<a href="video" class="overlay"></a>
			</div>
			<div class="description">
				<a href="video"><h4><?php echo $vid->title; ?></h4></a>
				<div>
					<span class="view"><?php echo $vid->views; ?></span>
					<a class="channel" href="#"><?php echo $this->model->getNameById($vid->user_id); ?></a>
				</div>
			</div>
		</div>

		<?php } ?>

	</aside>
</div>

<script src="<?php echo JS.'bgLoader.js'; ?>"></script>