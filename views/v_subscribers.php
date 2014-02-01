<?php $subscribers = Subscribers::getAll($user->getId()); ?>

<div class="container">
	<div class="container">
		<div class='border-top'></div>
			<h1><?php echo $user->getName(); ?><small> <?php echo count($subscribers); ?> Abonnés</small></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class="container">
		<div class="list-group">
			<?php

			foreach ($subscribers as $sub) {
				?>
				<a href="./?page=member&uid=<?php echo $sub->getId(); ?>" class="list-group-item">
					<img src="<?php echo $sub->getAvatarPath(); ?>" style="width: 32px; height: 32px;">
					<?php echo $sub->getName(); ?>
				</a>
				<?php
			}

			?>
		</div>

	</div>
</div>