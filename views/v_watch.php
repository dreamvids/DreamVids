<?php

?>

<div class='container'>
	<div class="container" style='width: 80%;'>
		<div class='lol'></div>
			<h1><?php echo $title; ?><small> de <a href='#'><?php echo $author; ?><a></small></h1>
		<div class='yolo'></div>

		<br><br>
	</div>

	<div class='container' style='width: 80%;'>
		<video id="player" width="640" height="360" style="width: 100%; height: 100%; position: absolute;" controls>
			<source src="<?php echo $path; ?>">
		</video>	
	</div>
</div>