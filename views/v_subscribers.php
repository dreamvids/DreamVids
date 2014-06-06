<?php $subscribers = Subscribers::getAll($user->getId()); ?>

<div class="container">

	<h1 class="title"><?php echo $user->getName(); ?><small> <?php echo count($subscribers); ?> Abonnés</small></h1>

	<div class="container">
		<div class="list-group">
			<?php

			foreach ($subscribers as $sub) {
				?>
				<a href="/@<?php echo $sub->getName(); ?>" class="list-group-item">
					<img src="<?php echo $sub->getAvatarPath(); ?>" style="width: 32px; height: 32px;">
					<?php echo $sub->getName(); ?>
				</a>
				<?php
			}

			?>
		</div>

	</div>
</div>