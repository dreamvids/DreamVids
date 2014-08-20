<div class="content">
	<aside class="aside-cards-list">
		<h3 class="title">Dernières vidéos postées</h3>
		
		<?php foreach ($vids as $vid) {
			echo Utils::getVideoCardHTML($vid);
		} ?>
	</aside>
</div>