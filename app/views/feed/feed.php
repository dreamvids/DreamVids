<div class="content">
	<aside class="aside-channels">
		<h3 class="title">Mes abonnements</h3>
		<ul class="limited">

			<?php $channel_subscribed_number = 0; ?>

			<?php if(empty($subscriptions)): ?>
				<p style="text-align: center; color: #858484;">Vous n'avez aucun abonnement !</p>
			<?php endif ?>

			<?php foreach($subscriptions as $subscription): ?>
				<?php if ($subscription): ?>
					<?php $channel_subscribed_number ++; ?>
					<a href="<?php echo WEBROOT.'channel/'.$subscription->name; ?>" class="channels">
						<span style="background-image: url(<?php echo $subscription->getAvatar(); ?>)" class="avatar"></span>
						<span class="name"><?php echo $subscription->name; ?></span>
						<p class="subscribers"><b><?php echo $subscription->subscribers; ?></b> Abonnés</p>
					</a>
				<?php endif ?>
			<?php endforeach ?>

			<?php 

				if ($channel_subscribed_number > 8) { ?>

					<input type="checkbox" onclick="p=this.parentNode;p.className=this.checked?p.className+' all':p.className.replace(' all','');"/>
					<span class="ch-more">Voir tout</span>
					<span class="ch-less">Voir moins</span>

				<?php }
			?>
			
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
					$channel_action = (UserChannel::exists($action->channel_id)) ? Utils::secureActiveRecordModel(UserChannel::find($action->channel_id)) : false;
					if ($channel_action !== false) {
						if($action->type == 'upload' && Video::exists($action->target)) {
							echo Utils::getVideoCardHTML(Utils::secureActiveRecordModel(Video::find($action->target)), $supp_class);
						}
						else if($action->type == "subscription" && UserChannel::exists($action->target)) {
							$target_channel = UserChannel::find($action->target);
							?>
								<div class="card<?php echo $supp_class; ?> channel">
									<?php if($action->infos['nb_subscription'] <= 1){ ?>
									<a href="<?php echo WEBROOT.'channel/'.$channel_action->name; ?>">
										<div class="avatar bg-loader" data-background-load-in-view data-background="<?php echo $channel_action->getBackground(); ?>"></div>
										<p><b><?php echo Utils::secure($channel_action->name); ?></b> s'est abonné à votre chaîne "<b><?php echo Utils::secure(UserChannel::find($action->target)->name); ?></b>"</p>
									<?php } else{ ?>
									<a href="<?php echo WEBROOT.'channel/'.$target_channel->name; ?>">
										<div class="avatar bg-loader" data-background-load-in-view data-background="<?php echo $target_channel->getBackground(); ?>"></div>
										<p><b><?php echo $action->infos['nb_subscription']; ?></b> personnes se sont abonnées à votre chaîne "<b><?php echo Utils::secure($target_channel->name); ?></b>"</p>
									<?php } ?>
									</a>
									<span class="subscriber"></span>
									<i><?php echo Utils::relative_time($action->timestamp) ?></i>
								</div>
							<?php
						}
						else if($action->type == 'like' && Video::exists($action->target)) {
								$video = Utils::secureActiveRecordModel(Video::find_by_id($action->target));
								$nb_like = $action->infos["nb_like"];
								$phrase = "<b>" . ($nb_like > 1 ? "$nb_like</b> personnes ont" : "$channel_action->name</b> a ") . "  aimé votre vidéo \"<b>$video->title</b>\"";
							?>
								<div class="card<?php echo $supp_class; ?> plus">
									<a href="<?php echo WEBROOT.'watch/'.$action->target; ?>">
										<div class="thumbnail bg-loader" data-background-load-in-view data-background="http://lorempicsum.com/up/350/200/6"></div>
										<p><?php echo $phrase; ?></p>
									</a>
									<i><?php echo Utils::relative_time($action->timestamp); ?></i>
								</div>
							<?php
						}
						else if($action->type == 'comment' && Video::exists($action->target)) {
 							$comment = Comment::getByChannelAction($action);
							$video = Utils::secureActiveRecordModel(Video::find($action->target));
							?>
								<div class="card<?php echo $supp_class; ?> comment">
									<a href="<?php echo WEBROOT.'watch/'.$action->target; ?>">
										<p><b><?php echo Utils::secure($channel_action->name); ?></b> a commenté votre vidéo "<b><?php echo $video->title; ?></b>" :</p>
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
										<p><b><?php echo Utils::secure($channel_action->name); ?></b> a posté un message !</p>
										<blockquote>
											<?php echo Utils::secure(substr($action->target, 0, 80)); ?>
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
										<div class="thumbnail bg-loader" data-background-load-in-view data-background="http://lorempicsum.com/futurama/350/200/6"></div>
										<p>Vous avez été nommé administrateur de la chaîne "<b><?php echo Utils::secureActiveRecordModel($channel_action)->name; ?></b>"</p>
									</a>
									<i><?php echo Utils::relative_time($action->timestamp); ?></i>
								</div>
							<?php
						}
						else if($action->type == 'unadmin') {
							?>
								<div class="card<?php echo $supp_class; ?> plus">
									<a href="<?php echo WEBROOT.'channels/'.$channel_action->id; ?>">
										<div class="thumbnail bg-loader" data-background-load-in-view data-background="http://lorempicsum.com/futurama/255/200/2"></div>
										<p>Vous n'êtes plus administrateur de la chaîne "<b><?php echo Utils::secureActiveRecordModel($channel_action)->name; ?></b>"</p>
									</a>
									<i><?php echo Utils::relative_time($action->timestamp); ?></i>
								</div>
							<?php
						}
						else if($action->type == 'like_comment' && Comment::exists($action->target)) {
							?>
								<div class="card<?php echo $supp_class; ?> comment">
									<a href="<?php echo WEBROOT.'watch/'.Comment::find($action->target)->video_id; ?>">
										<p><b><?php echo Utils::secure($channel_action->name); ?></b> a aimé votre commentaire</p>
										<blockquote>
											<?php echo Utils::secure(substr(Comment::find($action->target)->comment, 0, 80)); ?>
										</blockquote>
									</a>
									<i><?php echo Utils::relative_time($action->timestamp); ?></i>
								</div>
							<?php
						}
						else if($action->type == 'pm') {
							$pluriel = $action->infos['nb_msg'] > 1 ? "messages privés" : "message privé";
							?>
								<div class="card<?php echo $supp_class; ?> plus">
									<a href="<?php echo WEBROOT.'account/messages'; ?>">
										<div class="thumbnail bg-loader" data-background-load-in-view data-background="http://lorempicsum.com/up/350/200/1"></div>
										<p>Vous avez <?php echo $action->infos['nb_msg'] . " " . $pluriel ?></p>
									</a>
									<i><?php echo Utils::relative_time($action->timestamp); ?></i>
								</div>
							<?php
						}else if ($action->type == 'welcome') { ?>
								<div class="card<?php echo $supp_class; ?> plus">
									<a href="<?php echo WEBROOT.'upload'; //TODO visite guidée ?>">
										<div class="thumbnail bg-loader" data-background-load-in-view data-background="<?php echo WEBROOT.'assets/img/default-thumbnail.png'; ?>"></div>
										<p>Bienvenue sur DreamVids ! Commencez à envoyer une vidéo dès maintenant !</p>
									</a>
									<i><?php echo Utils::relative_time($action->timestamp); ?></i>
								</div>
						<?php }else if($action->type == "welcomeback"){ ?>
							
								<div class="card<?php echo $supp_class; ?> plus">
									<a href="<?php echo WEBROOT; ?>">
										<div class="thumbnail bg-loader" data-background-load-in-view data-background="<?php echo WEBROOT.'assets/img/logo_words.jpg'; ?>"></div>
										<p>Bienvenue sur la V2 de DreamVids ! Vous allez voir, ça va être super !</p>
									</a>
									<i><?php echo Utils::relative_time($action->timestamp); ?></i>
								</div>							
							
						<?php }else if($action->type == "staff_select"){ 
							$video = Utils::secureActiveRecordModel(Video::find_by_id($action->target));
							?>
							
								<div class="card<?php echo $supp_class; ?> plus">
									<a href="<?php echo WEBROOT . 'watch/' . $video->id; ?>">
										<div class="thumbnail bg-loader" data-background-load-in-view data-background="<?php echo $video->getThumbnail(); ?>"></div>
										<p><b>Félicitation !</b> Votre vidéo <br><b><?php echo $video->title; ?></b> vient d'être mise en avant sur la page d'accueil !</p>
									</a>
									<i><?php echo Utils::relative_time($action->timestamp); ?></i>
								</div>							
							
							<?php }
					}
				}
			}
		?>

	</aside>
</div>
