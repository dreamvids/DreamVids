<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
		<meta name="format-detection" content="telephone=no" />

		<title><?php echo (isset($TITLE)) ? $TITLE.' - ' : ''; echo NAME; ?></title>

		<link type="text/css" rel="stylesheet" href="<?= CSS . 'bootstrap.min.css'; ?>" media="screen" />
		<link type="text/css" rel="stylesheet" href="<?= CSS . 'style.css'; ?>" media="screen" />
	</head>

	<body>
		<?php require_once @$appView; ?>
		
		<script type="text/javascript" src="<?= JS . 'jquery.min.js'; ?>"></script>
		<script type="text/javascript" src="<?= JS . 'bootstrap.min.js'; ?>"></script>
		<script type="text/javascript" src="<?= JS . 'script.js'; ?>"></script>
	</body>
</html>