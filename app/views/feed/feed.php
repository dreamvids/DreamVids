<div class="content">
	<aside class="aside-channels">
		<h3 class="title">Mes abonnements</h3>
		<ul class="limited">
			<?php if(empty($subscriptions)): ?>
				<p style="text-align: center; color: #858484;">Vous n'avez aucun abonnement !</p>
			<?php endif ?>

			<?php foreach($subscriptions as $subscription): ?>
				<?php if ($subscription): ?>
					<a href="<?php echo WEBROOT.'channel/'.$subscription->name; ?>" class="channels">
						<span style="background-image: url(<?php echo $subscription->getAvatar(); ?>)" class="avatar"></span>
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

		<?php if(@empty($actions)){ ?>
			<p style="text-align: center; color: #858484;">Aucun évenement récent</p>
		<?php } ?>

		<?php
			foreach(@$actions as $action) {
				if($action) {
					if($action->type == 'upload') {
						?>
							<div class="card video">
								<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/nemo/350/200/1">
									<div class="time"><?php echo Video::find($action->target)->duration; ?></div>
									<a href="<?php echo WEBROOT.'watch/'.$action->target; ?>" class="overlay"></a>
								</div>
								<div class="description">
									<a href="<?php echo WEBROOT.'watch/'.$action->target; ?>"><h4><?php echo Video::find($action->target)->title; ?></h4></a>
									<div>
										<span class="view"><?php echo Video::find($action->target)->views; ?></span>
										<a class="channel" href="<?php echo WEBROOT.'channel/'.$action->channel_id; ?>"><?php echo UserChannel::getNameById($action->channel_id); ?></a>
									</div>
								</div>
							</div>
						<?php
					}
					else if($action->type == "subscription") {
						$user_action_name = User::getNameById($action->user_id);
						?>
							<div class="card channel">
								<a href="<?php echo WEBROOT.'channel/'.$user_action_name; ?>">
									<div class="avatar bgLoader" data-background="<?php echo User::find($action->user_id)->getMainChannel()->getBackground(); ?>"></div>
									<p><b><?php echo $user_action_name ?></b> s'est abonné à votre chaîne</p>
								</a>
								<!-- <span class="subscriber"><b>64 520</b> Abonnés</span> -->
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
					else if($action->type == 'comment' && Comment::getByChannelAction($action)) {
						?>
							<div class="card comment">
								<a href="<?php echo WEBROOT.'watch/'.$action->target; ?>">
									<p><b><?php echo UserChannel::getNameById($action->channel_id); ?></b> à commenté votre vidéo "<b><?php echo Video::find($action->target)->title; ?></b>" :</p>
									<blockquote>
										<?php echo Comment::getByChannelAction($action)->comment; ?>
									</blockquote>
								</a>
								<i><?php echo Utils::relative_time($action->timestamp); ?></i>
							</div>
						<?php
					}
					else if($action->type == 'message') {
						?>
							<div class="card comment">
								<a href="<?php echo WEBROOT.'channel/'.$action->channel_id; ?>">
									<p><b><?php echo UserChannel::getNameById($action->channel_id); ?></b> à posté un message !</p>
									<blockquote>
										<?php echo $action->target; ?>
									</blockquote>
								</a>
								<i><?php echo Utils::relative_time($action->timestamp); ?></i>
							</div>
						<?php
					}
				}
			}
		?>

	</aside>
</div>