<div class="content">
	<aside class="aside-channels">
		<h3 class="title">Mes abonnements</h3>
		<ul class="limited">
			<?php if (empty($subscriptions)): ?>
				<p style="text-align: center; color: #858484;">Vous n'avez aucun abonnement !</p>
			<?php endif ?>

			<?php foreach ($subscriptions as $subscription): ?>
				<?php if ($subscription): ?>
					<a href="<?php echo WEBROOT.'channel/'.$subscription->name; ?>" class="channels">
						<span style="background-image: url(http://lorempicsum.com/simpsons/255/200/2)" class="avatar"></span>
						<span class="name"><?php echo $subscription->name; ?></span>
						<p class="subscribers"><b><?php echo $subscription->subscribers; ?></b> Abonnés</p>
					</a>
				<?php endif ?>
			<?php endforeach ?>

			<input type="checkbox" onclick="p=this.parentNode;p.className=this.checked?p.className+' all':p.className.replace(' all','');"/>
			<span class="ch-more">Voir tout</span>
			<span class="ch-less">Voir moins</span>
		</ul>
	</aside>

	<aside class="aside-cards-list">
		<h3 class="title">Flux d'activité</h3>

		<?php
			foreach($subscriptionActions as $action) {
				if($action) {
					if($action->type == 'upload') {
						?>
							<div class="card video">
								<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/nemo/350/200/1">
									<div class="time"><?php echo Video::find($action->target)->duration; ?></div>
									<a href="video" class="overlay"></a>
								</div>
								<div class="description">
									<a href="video"><h4><?php echo Video::find($action->target)->title; ?></h4></a>
									<div>
										<span class="view"><?php echo Video::find($action->target)->views; ?></span>
										<a class="channel" href="<?php echo WEBROOT.'channel/'.$action->channel_id; ?>"><?php echo UserChannel::getNameById($action->channel_id); ?></a>
									</div>
								</div>
							</div>
						<?php
					}
				}
			}
		?>

		<?php
			foreach($personalActions as $action) {
				if($action) {
					if($action->type == "subscription") {
						?>
							<div class='card subscribe'>
								<a href="channel">
									<div class="avatar bgLoader" data-background="http://lorempicsum.com/futurama/255/200/2"></div>
									<p><b><?php echo User::getNameById($action->user_id) ?></b> s'est abonné à votre chaîne</p>
								</a>
								<i><?php echo Utils::relative_time($action->timestamp) ?></i>
							</div>
						<?php
					}
					else if($action->type == 'unsubscription') {
						?>
							<div class="card subscribe">
								<a href="channel">
									<div class="avatar bgLoader" data-background="http://lorempicsum.com/futurama/255/200/2"></div>
									<p><b><?php echo User::getNameById($action->user_id) ?></b> s'est a annulé son abonnement à votre chaîne</p>
								</a>
								<i><?php echo Utils::relative_time($action->timestamp) ?></i>
							</div>
						<?php
					}
					else if($action->type == 'like') {
						?>
							<div class="card plus">
								<a href="channel">
									<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/simpsons/627/300/4"></div>
									<p><b><?php echo User::getNameById($action->user_id) ?></b> à aimé votre vidéo "<b><?php echo Video::find_by_id($action->target)->title; ?></b>"</p>
								</a>
								<i><?php echo Utils::relative_time($action->timestamp); ?></i>
							</div>
						<?php
					}
				}
			}
		?>
		
		<!--<div class="card video">
			<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/up/350/200/1">
				<div class="time">12:05</div>
				<a href="video" class="overlay"></a>
			</div>
			<div class="description">
				<a href="video"><h4>Up !</h4></a>
				<div>
					<span class="view">12 530</span>
					<a class="channel" href="channel">Papy</a>
				</div>
			</div>

		<div class="card video">
			<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/nemo/350/200/1">
				<div class="time">16:17</div>
				<a href="video" class="overlay"></a>
			</div>
			<div class="description">
				<a href="video"><h4>Nemo</h4></a>
				<div>
					<span class="view">10 576</span>
					<a class="channel" href="channel">Dori</a>
				</div>
			</div>
		</div>

		<div class="card comment multiple">
			<a href="video">
				<p><b>3 personnes</b> ont commentés votre vidéo "<b>Nyan Cat</b>" :</p>
				<blockquote>
					A quand une version 1 heure ?
				</blockquote>
				<blockquote>
					Nyan Nyan Nyan Nyan Nyan Nyan Nyan !
				</blockquote>
				<blockquote>
					C'est quoi ce chat ?
				</blockquote>
				<blockquote>
					A quand une version 1 heure ?
				</blockquote>
				<blockquote>
					Nyan Nyan Nyan Nyan Nyan Nyan Nyan !
				</blockquote>
				<blockquote>
					C'est quoi ce chat ?
				</blockquote>
			</a>
			<i>Il y a 2 minutes</i>
		</div>

		<div class="card video">
			<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/nemo/627/300/4">
				<div class="time">3:27</div>
				<a href="video" class="overlay"></a>
			</div>
			<div class="description">
				<a href="video"><h4>Nemo [Bande Annonce]</h4></a>
				<div>
					<span class="view">32 546</span>
					<a class="channel" href="channel">Nemo</a>
				</div>
			</div>
		</div>

		<div class="card subscribe">
			<a href="#">
				<div class="avatar bgLoader" data-background="http://lorempicsum.com/simpsons/255/200/5"></div>
				<p><b>6 personnes</b> se sont abonnés à votre chaîne</p>
			</a>
			<span class="subscriber"><b>64 520</b> Abonnés</span>
			<i>Il y a 1 heure</i>
		</div>

		<div class="card comment">
			<a href="video">
				<p><b>Bidule</b> à commenté votre vidéo "<b>Nom Nom Nom</b>" :</p>
				<blockquote>
					J'aime trop cette vidéo parce que Nom Nom Nom Nom Nom Nom Nom Nom !
				</blockquote>
			</a>
			<i>Il y a 1 jour</i>
		</div>-->

	</aside>
</div>