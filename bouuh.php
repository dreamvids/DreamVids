<?php
require 'includes/bdd.class.php';
require 'classes/Citrouille.php';

$bouuh = new Citrouille(0, $_GET['id']);
$bouuh->remove();
?><!doctype html>
<html>
	<head>
	<meta charset="utf-8" />
		<title>BOUUH !</title>
		<style type="text/css">
			body {
				background-image: url(img/bouuh.jpg);
				background-size: 100% 100%;
				background-position: center;
				background-attachment: fixed;
				background-repeat: no-repeat;
				color: white;
				font-family: ubuntu, verdana;
				text-align: center;
				padding-top: 25%;
			}
			
			h1 {
				font-size: 100px;
				margin: 0;
				padding: 0;
			}
			
			h2 {
				font-size: 40px;
				margin-top: 0;
				padding-top: 0;
			}
			
			input {
				font-size: 30px;
				text-align: center;
				width: 500px;
				max-width: 95%;
			}
		</style>
	</head>
	
	<body>
		<h1>BRAVO !</h1>
		<h2>TU AS GAGNE UNE CLE BÊTA</h2>
		<input type="text" value="<?php echo $bouuh->getKey(); ?>" />
	</body>
</html>