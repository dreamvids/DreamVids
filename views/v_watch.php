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
		<video controls>
			<source src="<?php echo $path; ?>">
		</video>

		<br><br>

		<button class="btn btn-success">+1</button>
		<button class="btn btn-danger">-1</button>

		<button class="btn btn-primary">S'abonner</button>
		<button class="btn btn-danger">Reporter</button>
	</div>
</div>