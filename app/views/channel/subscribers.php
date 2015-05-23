<?php
	include VIEW.'/layouts/channel_header.php';
?>

<div class="content">
	<aside class="full-cards-list">
		<?php if(empty($subscribers)): ?>
			Cette chaîne n'a aucun abonné
		<?php else: ?>
			<?php foreach ($subscribers_users as $user): $main_user_channel = $user->getMainChannel(); ?>
				<div class="card video">
					<div class="thumbnail bg-loader bg-loaded" data-background-load-in-view data-background="<?= $main_user_channel->getAvatar() ?>" style="width: 50%; margin: auto;">
						<a href="<?=WEBROOT?>channel/<?= $user->username ?>" class="overlay"></a>
					</div>
					
					<div class="description">
						<a href="<?=WEBROOT?>channel/<?= $user->username ?>"><h4><?= $user->username ?></h4></a>
					<div>
						<span class="view"><?= $main_user_channel->getAllViews(); ?> / <?= $main_user_channel->getSubscribersNumber(); ?> Abonnés </span>
					</div>
					</div>
				</div>
			<?php endforeach ?>
		<?php endif ?>
	</aside>
</div>