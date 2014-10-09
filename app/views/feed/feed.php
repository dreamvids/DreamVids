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
					$supp_class = ($action->timestamp > $last_visit) ? ' card--new' : '';
					$channel_action = UserChannel::find($action->channel_id);
					if($action->type == 'upload') {
						echo Utils::getVideoCardHTML(Video::find($action->target));
					}
					else if($action->type == "subscription") {
						?>
							<div class="card<?php echo $supp_class; ?> channel">
								<a href="<?php echo WEBROOT.'channel/'.$channel_action->name; ?>">
									<div class="avatar bg-loader" data-background="<?php echo $channel_action->getBackground(); ?>"></div>
									<p><b><?php echo $channel_action->name ?></b> s'est abonné à votre chaîne "<b><?php echo UserChannel::find($action->target)->name; ?></b>"</p>
								</a>
								<span class="subscriber"><b><?php echo $channel_action->subscribers; ?></b> Abonnés</span>
								<i><?php echo Utils::relative_time($action->timestamp) ?></i>
							</div>
						<?php
					}
					else if($action->type == 'like') {
						?>
							<div class="card<?php echo $supp_class; ?> plus">
								<a href="<?php echo WEBROOT.'watch/'.$action->target; ?>">
									<div class="thumbnail bg-loader" data-background="http://lorempicsum.com/up/350/200/6"></div>
									<p><b><?php echo $channel_action->name ?></b> a aimé votre vidéo "<b><?php echo Video::find_by_id($action->target)->title; ?></b>"</p>
								</a>
								<i><?php echo Utils::relative_time($action->timestamp); ?></i>
							</div>
						<?php
					}
					else if($action->type == 'comment') {
						$comment = Comment::getByChannelAction($action);
						?>
							<div class="card<?php echo $supp_class; ?> comment">
								<a href="<?php echo WEBROOT.'watch/'.$action->target; ?>">
									<p><b><?php echo $channel_action->name; ?></b> a commenté votre vidéo "<b><?php echo Video::find($action->target)->title; ?></b>" :</p>
									<blockquote>
										<?php echo substr($comment->comment, 0, 80); ?>
									</blockquote>
								</a>
								<i><?php echo Utils::relative_time($action->timestamp); ?></i>
							</div>
						<?php
					}
					else if($action->type == 'message') {
						?>
							<div class="card<?php echo $supp_class; ?> comment">
								<a href="<?php echo WEBROOT.'channel/'.$action->channel_id.'/social'; ?>">
									<p><b><?php echo $channel_action->name; ?></b> a posté un message !</p>
									<blockquote>
										<?php echo substr($action->target, 0, 80); ?>
									</blockquote>
								</a>
								<i><?php echo Utils::relative_time($action->timestamp); ?></i>
							</div>
						<?php
					}
					else if($action->type == 'admin') {
						?>
							<div class="card<?php echo $supp_class; ?> plus">
								<a href="<?php echo WEBROOT.'channels/'.$channel_action->id; ?>">
									<div class="thumbnail bg-loader" data-background="http://lorempicsum.com/futurama/350/200/6"></div>
									<p>Vous avez été nommé administrateur de la chaîne "<b><?php echo $channel_action->name; ?></b>"</p>
								</a>
								<i><?php echo Utils::relative_time($action->timestamp); ?></i>
							</div>
						<?php
					}
					else if($action->type == 'unadmin') {
						?>
							<div class="card<?php echo $supp_class; ?> plus">
								<a href="<?php echo WEBROOT.'channels/'.$channel_action->id; ?>">
									<div class="thumbnail bg-loader" data-background="http://lorempicsum.com/futurama/255/200/2"></div>
									<p>Vous n'êtes plus administrateur de la chaîne "<b><?php echo $channel_action->name; ?></b>"</p>
								</a>
								<i><?php echo Utils::relative_time($action->timestamp); ?></i>
							</div>
						<?php
					}
					else if($action->type == 'like_comment') {
						?>
							<div class="card<?php echo $supp_class; ?> comment">
								<a href="<?php echo WEBROOT.'watch/'.Comment::find($action->target)->video_id; ?>">
									<p><b><?php echo $channel_action->name; ?></b> a aimé votre commentaire</p>
									<blockquote>
										<?php echo substr(Comment::find($action->target)->comment, 0, 80); ?>
									</blockquote>
								</a>
								<i><?php echo Utils::relative_time($action->timestamp); ?></i>
							</div>
						<?php
					}
					else if($action->type == 'pm') {
						?>
							<div class="card<?php echo $supp_class; ?> plus">
								<a href="<?php echo WEBROOT.'account/messages'; ?>">
									<div class="thumbnail bg-loader" data-background="http://lorempicsum.com/up/350/200/1"></div>
									<p>Vous avez un nouveau message privé !</p>
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