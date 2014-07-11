<div id="home-large-modal">
	<div id="backgroundLoader" class="bgLoader" data-background="<?php echo IMG.'backgrounds/001.jpg'; ?>"></div>
	<section>
		<div id="boxPages" class="channel">
			<div id="pageChannel">
				<a href="channel">
					<span class="avatar bgLoader" data-background="http://lorempicsum.com/simpsons/255/200/5"></span>
					<h3><?php echo Session::get()->username; ?></h3>
				</a>
			</div>
		</div>

		
		<div id="boxBest">
			<h3>Vidéos à découvrir :</h3>
			<ul id="sliderList" class="slide1">
				<li onclick="slideTo(1);"></li>
				<li onclick="slideTo(2);"></li>
				<li onclick="slideTo(3);"></li>
			</ul>
			
			<section id="slider" class="slide1">
				<div id="slide">
					<?php for($i = 0; $i < count($discoverVids) - 4; $i++): ?>
						<div class="card video">
							<div class="thumbnail bgLoader" style="height: 75%;" data-background="http://lorempicsum.com/nemo/350/200/1"><a href="<?php echo WEBROOT.'watch/'.$discoverVids[$i]->id; ?>" class="overlay"></a></div>
							<div class="description">
								<a href="<?php echo WEBROOT.'watch/'.$discoverVids[$i]->id; ?>"><h4><?php echo $discoverVids[$i]->title; ?></h4></a>
							</div>
						</div>
					<?php endfor ?>
				</div>

				<div id="slide">
					<?php for($i = 2; $i < count($discoverVids) - 2; $i++): ?>
						<div class="card video">
							<div class="thumbnail bgLoader" style="height: 75%;" data-background="http://lorempicsum.com/nemo/350/200/1"><a href="<?php echo WEBROOT.'watch/'.$discoverVids[$i]->id; ?>" class="overlay"></a></div>
							<div class="description">
								<a href="<?php echo WEBROOT.'watch/'.$discoverVids[$i]->id; ?>"><h4><?php echo $discoverVids[$i]->title; ?></h4></a>
							</div>
						</div>
					<?php endfor ?>
				</div>

				<div id="slide">
					<?php for($i = 4; $i < count($discoverVids); $i++): ?>
						<div class="card video">
							<div class="thumbnail bgLoader" style="height: 75%;" data-background="http://lorempicsum.com/nemo/350/200/1"><a href="<?php echo WEBROOT.'watch/'.$discoverVids[$i]->id; ?>" class="overlay"></a></div>
							<div class="description">
								<a href="<?php echo WEBROOT.'watch/'.$discoverVids[$i]->id; ?>"><h4><?php echo $discoverVids[$i]->title; ?></h4></a>
							</div>
						</div>
					<?php endfor ?>
				</div>
			</section>
		</div>
	</section>
</div>

<div class="content">
	<aside class="aside-channels">
		<h3 class="title">Mes abonnements</h3>
		<ul class="limited">
			<?php if(sizeof($subscriptions) != 0) { ?>
				<?php foreach($subscriptions as $sub) { ?>
					<a href="<?php echo WEBROOT.'channel/'.$sub->name; ?>" class="channels">
						<span style="background-image: url(http://lorempicsum.com/simpsons/255/200/2)" class="avatar"></span>
						<span class="name" href="#"><?php echo $sub->name; ?></span>
						<p class="subscribers"><b><?php echo $sub->subscribers; ?></b> Abonnés</p>
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
		
		<?php foreach($subscriptions_vids as $vid) { ?>
			<div class="card video">
				<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/up/350/200/1">
					<div class="time"><?php echo $vid->duration; ?></div>
					<a href="<?php echo WEBROOT.'watch/'.$vid->id; ?>" class="overlay"></a>
				</div>
				<div class="description">
					<a href="<?php echo WEBROOT.'watch/'.$vid->id; ?>"><h4><?php echo $vid->title; ?></h4></a>
					<div>
						<span class="view"><?php echo $vid->views; ?></span>
						<a class="channel" href="<?php echo WEBROOT.'channel/'.$vid->poster_id; ?>"><?php echo UserChannel::getNameById($vid->poster_id); ?></a>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if(sizeof($subscriptions_vids) == 0) { ?>
			<p style="text-align: center; color: #858484;">Aucune nouvelles vidéos de vos abonnement</p>
			<p style="text-align: center; color: #858484;">Rendez-vous sur la page <a href="<?php echo WEBROOT.'discover'; ?>">Découvrir</a> pour découvrir de nouveux créateurs !</p>
		<?php } ?>

		<!--<a href="<?php echo WEBROOT.'feed'; ?>" class="big-button">Voir mon flux d'acivité</a>-->
	</aside>

	<aside class="aside-cards-list">
		<h3 class="title">Meilleures vidéos</h3>
		
		<div class="card video">
			<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/nemo/350/200/1">
				<div class="time">12:05</div>
				<a href="video" class="overlay"></a>
			</div>
			<div class="description">
				<a href="video"><h4>Nemo</h4></a>
				<div>
					<span class="view">12 530</span>
					<a class="channel" href="channel">Papy</a>
				</div>
			</div>
		</div>

		<div class="card video">
			<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/up/627/300/4">
				<div class="time">16:17</div>
				<a href="video" class="overlay"></a>
			</div>
			<div class="description">
				<a href="video"><h4>La Haut ! Bande Annonce</h4></a>
				<div>
					<span class="view">10 576</span>
					<a class="channel" href="channel">Dori</a>
				</div>
			</div>
		</div>
	</aside>
</div>