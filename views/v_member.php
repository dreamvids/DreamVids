<?php

?>

<div class='container'>
	<div class="container" style=''>
		<div class='border-top'></div>
			<h1><?php echo $pseudo; ?></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class='container' style=''>
		<?php
			foreach ($vids as $video) {
				echo $video."<br>";
			}
		?>
	</div>
</div>
