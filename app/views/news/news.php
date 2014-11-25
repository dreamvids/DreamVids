<div class="content">
	<!-- <aside class="full-cards-list">
		<h3 class="title">Lives en cours</h3>
		
		<div class="card video card--live">
			<div class="thumbnail bg-loader" data-background-load-in-view data-background="http://lorempicsum.com/nemo/350/200/1">
				<a href="<?php echo WEBROOT; ?>lives/Dimou" class="overlay"></a>
			</div>
			<div class="description">
				<a href="<?php echo WEBROOT; ?>lives/Dimou"><h4>Live de Dimou</h4></a>
				<div>
					<span class="view">4 visionneurs en ligne</span>
					<a class="channel" href="<?php echo WEBROOT; ?>lives/Dimou">Dimou</a>
				</div>
			</div>
		</div>

		<div class="card video card--live">
			<div class="thumbnail bg-loader" data-background-load-in-view data-background="http://lorempicsum.com/nemo/350/200/1">
				<a href="<?php echo WEBROOT; ?>lives/Dimou" class="overlay"></a>
			</div>
			<div class="description">
				<a href="<?php echo WEBROOT; ?>lives/Dimou"><h4>Live de Dimou</h4></a>
				<div>
					<span class="view">4 visionneurs en ligne</span>
					<a class="channel" href="<?php echo WEBROOT; ?>lives/Dimou">Dimou</a>
				</div>
			</div>
		</div>

	</aside> -->

	<aside class="full-cards-list">
		<h3 class="title">Dernières vidéos postées</h3>
		
		<?php foreach ($vids as $vid) {
			echo Utils::getVideoCardHTML($vid);
		} ?>
	</aside>
</div>