<div class="content">
	<h3 class="title">Flux d'actvivité - Détail</h3>

	<div class="feed-list">
		<?php foreach ($actions as $action): ?>
			<?php if ($action->type == 'upload'): ?>
				<div>
					<p>La chaîne <?php echo UserChannel::getNameById($action->channel_id) ?> a mis en ligne une video:</p>
					<a href="<?php echo WEBROOT.'watch/'.$action->target; ?>"><?php echo Video::find($action->target)->title; ?></a>
					<p><?php echo Utils::relative_time($action->timestamp); ?></p>
					<br><br>
				</div>
			<?php endif ?>

			<?php if ($action->type == 'subscription'): ?>
				<div>
					<p>L'utilisateur <a href="<?php echo WEBROOT.'channel/'.User::find($action->user_id)->getMainChannel()->id; ?>"><?php echo User::getNameById($action->user_id); ?></a> s'est abonné à votre chaîne</p>
					<p><?php echo Utils::relative_time($action->timestamp); ?></p>
					<br><br>
				</div>
			<?php endif ?>

			<?php if ($action->type == 'like'): ?>
				<div>
					<p>
						L'utilisateur <a href="<?php echo WEBROOT.'channel/'.User::find($action->user_id)->getMainChannel()->id; ?>"><?php echo User::getNameById($action->user_id); ?></a>
						a aimé votre vidéo <a href="<?php echo WEBROOT.'watch/'.$action->target; ?>"><?php echo Video::find($action->target)->title; ?></a>
					</p>
					<p><?php echo Utils::relative_time($action->timestamp); ?></p>
					<br><br>
				</div>
			<?php endif ?>
		<?php endforeach ?>
	</div>
</div>