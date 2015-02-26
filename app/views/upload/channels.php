<div class="content">

	<section class="profile">
		<h3 class="title">Choisissez sur quelle chaîne vous souhaitez uploader votre vidéo</h3>

		<?php @include $messages; ?>

		<aside class="long-cards-list">

			<?php
			if(!empty($channel)) { 
				foreach($channel as $chan) { ?>

			<div class="card video">
				<div class="thumbnail bg-loader" data-background="<?php echo $chan->getBackground(); ?>">
					<a href="<?php echo WEBROOT.'upload/'.$chan->id; ?>" class="overlay"></a>
				</div>
				<div class="description">
					<a href="<?php echo WEBROOT.'upload/'.$chan->id; ?>"><h4>Uploader sur la chaîne "<?php echo $chan->name; ?>"</h4></a>
					<div>
						<span class="view"><?php echo $chan->views; ?></span>
						<a class="channel" href="#"></a>
					</div>
				</div>
			</div>

			<?php }
			}
			?>
		</aside>
	</section>

</div>