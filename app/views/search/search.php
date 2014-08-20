<div class="content">
	<aside class="aside-cards-list">
		<h3 class="title">Rechercher - "<?php echo $search; ?>"</h3>
		
		<?php foreach ($videos as $vid) {
			echo Utils::getVideoCardHTML($vid);
		} ?>
	</aside>
</div>