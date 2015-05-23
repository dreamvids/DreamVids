<div id="home-large-modal">
	<div id="backgroundLoader" class="bg-loader" data-background="<?php echo $background; ?>"></div>
	<section>
		<div id="boxPages" class="channel">
			<div id="pageChannel">
				<a href="<?php echo WEBROOT.'channel/'.$channelName; ?>">
					<span class="avatar bg-loader" data-background="<?php echo $avatar; ?>"></span>
					<h3><?php echo Session::get()->username; ?></h3>
				</a>
			</div>
		</div>

		
		<div id="boxBest">
			<h3>Vidéos à découvrir :</h3>
			
			<?php for($i = 0; $i < count($discoverVids); $i++) { ?>
				<div class="card video">
					<div class="thumbnail bg-loader" style="height: 75%;" data-background="<?php echo $discoverVids[$i]->getThumbnail(); ?>"><a href="<?php echo WEBROOT.'watch/'.$discoverVids[$i]->id; ?>" class="overlay"></a></div>
					<div class="description">
						<a href="<?php echo WEBROOT.'watch/'.$discoverVids[$i]->id; ?>"><h4><?php echo $discoverVids[$i]->title; ?></h4></a>
					</div>
				</div>
			<?php } ?>

		</div>
	</section>
</div>

<div class="content">
	<aside class="aside-channels">
		<h3 class="title">Mes abonnements</h3>
		<ul class="limited">
			<?php if(sizeof($subscriptions) != 0) { ?>
				<?php foreach($subscriptions as $sub) { 
						if(!is_object($sub)) continue;
					?>
					<a href="<?php echo WEBROOT.'channel/'.$sub->name; ?>" class="channels">
						<span style="background-image: url(<?php echo $sub->getAvatar(); ?>)" class="avatar"></span>
						<span class="name" href="#"><?php echo $sub->name; ?></span>
						<p class="subscribers"><b><?php echo count($sub->getSubscribedUsersAsList()); ?></b> Abonnés</p>
					</a>
				<?php } ?>

				<input type="checkbox" onclick="p=this.parentNode;p.className=this.checked?p.className+' all':p.className.replace(' all','');"/>
				<span class="ch-more">Voir tout</span>
				<span class="ch-less">Voir moins</span>
				
			<?php } else { ?>
				<p style="text-align: center; color: #858484;">Vous n'avez aucun abonnement !</p>
			<?php } ?>
		</ul>
	</aside>
		
	<aside class="aside-cards-list">
		<h3 class="title">Vidéos de mes abonnements</h3>
		
		<?php foreach($subscriptions_vids as $vid) {
			echo Utils::getVideoCardHTML($vid);
		} ?>

		<?php if(sizeof($subscriptions_vids) == 0) { ?>
			<p style="text-align: center; color: #858484;">Aucune nouvelles vidéos de vos abonnement</p>
			<p style="text-align: center; color: #858484;">Allez <a href="<?php echo WEBROOT.'news'; ?>">découvrir</a> de nouveux créateurs !</p>
		<?php } ?>

		<!--<a href="<?php echo WEBROOT.'feed'; ?>" class="big-button">Voir mon flux d'acivité</a>-->
	</aside>

	<aside class="full-cards-list">
		<h3 class="title">Meilleures vidéos</h3>
		<?php foreach($bestVids as $vid) {
			echo Utils::getVideoCardHTML($vid);
		} ?>
	</aside>
</div>