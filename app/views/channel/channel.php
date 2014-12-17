<?php
include VIEW.'/layouts/channel_header.php';
?>
<div class="content">
	<aside class="full-cards-list">

		<?php foreach($videos as $vid) {
			echo Utils::getVideoCardHTML($vid);
		} ?>
	</aside>
</div>