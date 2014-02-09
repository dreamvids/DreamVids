<div class='container'>
	<div class="container" style="">
		<div class='border-top'></div>
			<h1>Panel modérateur<small> Vidéos reportées</small></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class='container'>
		<?php
		$flaggedVids = Moderation::getFlaggedVideos();

		if(count($flaggedVids) > 0) {
			?>

			<div class="list-group">

			<?php
			foreach ($flaggedVids as $vid) {
				?>

				<a href="/watch-<?php echo $vid->getId(); ?>" class="list-group-item">
					<h4 class="list-group-item-heading"><?php echo $vid->getTitle().' - By '.User::getNameById($vid->getUserId()); ?></h4>
					<p class="list-group-item-text"><?php echo $vid->getDescription(); ?></p>
				</a>

				<?php
			}

			?>

			</div>

			<?php
		}
		else {
			?>

			<div class="alert alert-danger"><?php echo $lang['no_flagged_videos']; ?></div>

			<?php
		}

		?>

	</div>
</div>