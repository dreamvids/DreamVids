<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $lang['dreamvids']; ?></title>
		<meta charset="utf-8" />
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />

		<script src="jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>

		<!-- video.js video player -->
		<link href="video-js/video-js.css" rel="stylesheet" type="text/css">
		<script src="video-js/video.js"></script>
		<!-- End -->
	</head>
	
	<body>

	<div id="header">
		<div id="logo" class=""><a href="index.php"><img src="img/logo_white.png" alt="logo" style="height: 100px;"/></a></div>
		<br><br>
	</div>

	<div class="navbar navbar-default navbar-static-top" id="navbar">
		<div class="container">
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
			</button>

			<div class="collapse navbar-collapse navHeaderCollapse">
				<ul class="nav navbar-nav navbar-left">
					<li><a href="#"><?php echo $lang['discover']; ?></a></li>
					<li><a href="#"><?php echo $lang['news']; ?></a></li>
					<li><a href="#"><?php echo $lang['subscriptions']; ?></a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<?php if(isset($session)) { ?>
					<li><a href="index.php?page=upload"><?php echo $lang['up_vid']; ?></a></li>
					<li><a href="index.php?page=profile"><?php echo $lang['member_space']; ?></a></li>
					<li><a href="index.php?page=log&out=1"><?php echo $lang['logout']; ?></a></li>
					<?php } else { ?>
					<li><a href="index.php?page=log"><?php echo $lang['login']; ?></a></li>
					<li><a href="index.php?page=reg"><?php echo $lang['register']; ?></a></li>
					<li><a href="#"><?php echo $lang['infos']; ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
