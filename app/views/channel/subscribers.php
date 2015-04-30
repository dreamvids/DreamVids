<?php
	include VIEW.'/layouts/channel_header.php';
?>

<div class="content">
	<aside class="full-cards-list">
		<?php if(empty($subs_list)): ?>
			Cette chaîne n'a aucun abonné
		<?php else: ?>
			<?php foreach ($subs_list as $sub): ?>
				<?php $user = User::exists($sub) ? User::find($sub) : null; $user = $user->getMainChannel(); ?>
				<div class="card video">
					<div class="thumbnail bg-loader bg-loaded" data-background-load-in-view data-background="<?= $user->getAvatar() ?>" style="width: 50%; margin: auto;">
						<a href="/DreamVids/channel/<?= $user->name ?>" class="overlay"></a>
					</div>
					
					<div class="description">
						<a href="/DreamVids/channel/<?= $user->name ?>"><h4><?= $user->name ?></h4></a>
					<div>
						<span class="view"><?= $user->getAllViews(); ?> / <?= $user->getSubscribersNumber(); ?> Abonnés </span>
					</div>
					</div>
				</div>
			<?php endforeach ?>
		<?php endif ?>
	</aside>
</div>