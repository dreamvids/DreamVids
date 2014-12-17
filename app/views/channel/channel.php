<?php

echo ($average_background_color ? "<script>var avergage_background_color = [$average_background_color];</script>" : "");
include VIEW.'/layouts/channel_header.php';
?>
<div class="content">
	<aside class="full-cards-list">

		<?php foreach($videos as $vid) {
			echo Utils::getVideoCardHTML($vid);
		} ?>
	</aside>
</div>