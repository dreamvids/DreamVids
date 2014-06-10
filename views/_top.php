<!DOCTYPE html>
<html>
	<head>
		<title><?php echo (isset($html_title) ) ? $html_title.' - ' : ''; echo $lang['dreamvids']; ?></title>
		<meta charset="utf-8" />		
		<meta http-equiv="Content-Type" content="text/html; charset = utf-8">
		<meta name="viewport" content="width = device-width, initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<link rel="icon" type="image/png" href="img/favicon.png" />
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/style.css?time=<?php echo time(); ?>" rel="stylesheet" />

		<script src="js/jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/ajax.js?time=<?php echo time(); ?>"></script>

		<link rel="stylesheet" type="text/css" href="dreamplayer/css/player.css?time=<?php echo time(); ?>"/>

		<meta property="og:site_name" content="<?php echo $lang['dreamvids']; ?>" />

		<?php if(@$_GET['page'] == "watch") { ?>

			<meta property="og:title" content="<?php echo str_replace('"', secure("''"), secure($title) ); ?>" />
			<meta property="og:type" content="video.movie" />
			<meta property="og:url" content="http://dreamvids.fr/&<?php echo htmlspecialchars($_GET['vid']); ?>" />
			<meta property="og:description" content="<?php echo str_replace('"', secure("''"), secure($desc) ); ?>" />
			<meta property="og:image" content="http://dreamvids.fr/<?php echo ($tumbnail != '') ? secure($tumbnail) : secure($path).'.jpg'; ?>" />
			<meta property="og:image:type" content="image/jpg" />

			<meta name="twitter:card" content="photo">
			<meta name="twitter:site" content="@DreamVids_">
			<meta name="twitter:creator" content="@DreamVids_">
			<meta name="twitter:title" content="<?php echo secure($title); ?>">
			<meta name="twitter:image:src" content="http://dreamvids.fr/<?php echo ($tumbnail != '') ? secure($tumbnail) : secure($path).'.jpg'; ?>">
			<meta name="twitter:domain" content="dreamvids.fr">
			<meta name="twitter:app:name:iphone" content="">
			<meta name="twitter:app:name:ipad" content="">
			<meta name="twitter:app:name:googleplay" content="">
			<meta name="twitter:app:url:iphone" content="">
			<meta name="twitter:app:url:ipad" content="">
			<meta name="twitter:app:url:googleplay" content="">
			<meta name="twitter:app:id:iphone" content="">
			<meta name="twitter:app:id:ipad" content="">
			<meta name="twitter:app:id:googleplay" content="">

		<?php } else if(@$_GET['page'] == "member") { ?>

			<meta property="og:title" content="<?php echo secure($pseudo); ?>" />
			<meta property="og:type" content="profile" />
			<meta property="profile:username" content="<?php echo secure($pseudo); ?>" />
			<meta property="og:url" content="http://dreamvids.fr/@<?php echo secure($pseudo); ?>" />
			<meta property="og:image" content="<?php echo $avatar; ?>" />

			<meta name="twitter:card" content="summary">
			<meta name="twitter:site" content="@DreamVids_">
			<meta name="twitter:title" content="<?php echo secure($pseudo); ?>">
			<meta name="twitter:description" content="<?php echo secure($member->getSubscribers() ); ?> abonnés">
			<meta name="twitter:creator" content="@DreamVids_">

			<?php if (preg_match("/gravatar/i", $avatar)) { ?>
				<meta name="twitter:image:src" content="<?php echo $avatar; ?>">
			<?php } else { ?>
				<meta name="twitter:image:src" content="http://dreamvids.fr/<?php echo $avatar; ?>">
			<?php } ?>

			<meta name="twitter:domain" content="dreamvids.fr">
			<meta name="twitter:app:name:iphone" content="">
			<meta name="twitter:app:name:ipad" content="">
			<meta name="twitter:app:name:googleplay" content="">
			<meta name="twitter:app:url:iphone" content="">
			<meta name="twitter:app:url:ipad" content="">
			<meta name="twitter:app:url:googleplay" content="">
			<meta name="twitter:app:id:iphone" content="">
			<meta name="twitter:app:id:ipad" content="">
			<meta name="twitter:app:id:googleplay" content="">

		<?php } else { ?>

			<meta property="og:title" content="<?php echo $lang['dreamvids']; ?>" />
			<meta property="og:type" content="website" />
			<meta property="og:image" content="http://dreamvids.fr/uploads/Chaine%20Communautaire%20DreamVids/o50bhZ.png" />
			<meta property="og:image:type" content="image/png" />

		<?php }?>
	</head>
	
	<body>

	<header>
		<div id="top-nav">
			<div id="inner-top-nav">
				<div id="inner-top-nav-left">
					<a href="index.php">
						<img src="img/icon_logo.png" alt="Logo DreamVids" id="top-nav-logo-icon" class="top-nav-icon-logo" />
						<img src="img/text_logo.png" alt="DreamVids" id="top-nav-logo-text" class="top-nav-text-logo" />
					</a>
				</div>
				<div id="inner-top-nav-right">

					<form role="search" method="get" action="search">
						<input type="text" required="required" id="top-nav-search-input" name="q" placeholder="<?php echo $lang['search'].'...'; ?>">
						<input type="submit" value="">
					</form>

					<div id="top-nav-user-information">

						<?php if (isset($session)) { ?>						

							<span id="top-nav-user-information-button">
								<img src="<?php echo secure($session->getAvatarPath() ); ?>" id="top-nav-user-information-button-img">
								<h4 id="top-nav-user-information-button-h4"><?php echo secure($session->getName() ); ?></h4>
								<img src="img/arrow_top_nav.png" alt="Voir vos informations" id="top-nav-user-arrow">
								<div id="top-nav-user-information-menu">
									<ul>
										<a href="/@<?php echo secure($session->getName() ); ?>">Ma chaîne</a>
										<a href="profile"><?php echo $lang['member_space']; ?></a>
										<a href="mail"><?php echo $lang['msg']; ?></a>
										<a href="logout"><?php echo $lang['logout']; ?></a>
									</ul>
								</div>
							</span>

						<?php } else { ?>
								
							<div id="top-connection">
								<a href="login"><?php echo $lang['login']; ?></a>
								<p>/</p>
								<a href="signup"><?php echo $lang['register']; ?></a>
							</div>

						<?php } ?>
					</div>

				</div>
			</div>
		</div>
		<div id="bottom-nav">
			<div id="inner-bottom-nav">
				<nav>
					<ul>
						<li><a class="bug" href="index.php?page=bugs">Un bug ?</a></li>
						<li><a href="discover"><?php echo $lang['discover']; ?></a></li>
						<li><a href="videoslist"><?php echo $lang['news']; ?></a></li>

						<?php if (isset($session)) { ?>

							<li><a href="subscriptions"><?php echo $lang['subscriptions']; ?></a></li>
							<li><a href="upload"><?php echo $lang['up_vid']; ?></a></li>

						<?php } ?>
					</ul>
				</nav>
				<span id="mobile-nav-icon"><p></p></span>
				<div id="bottom-nav-social">
					<ul>
						<li><a href="https://www.facebook.com/dreamvids" target="_blank"><img src="img/icon_facebook.png" alt="Facebook"></a></li>
						<li><a href="https://twitter.com/DreamVids_" target="_blank"><img src="img/icon_twitter.png" alt="Twitter"></a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>

	<!-- <div id="header">
	<?php
	if (isset($session) )
	{
	?>
		<div style="float:right;margin:20px"><center><a href="/@<?php echo secure($session->getName() ); ?>"><img src="<?php echo secure($session->getAvatarPath() ); ?>" alt="" width="50" /><br /><b style="color:white"><?php echo secure($session->getName() ); ?></b></a></center></div>
	<?php
	}
	?>
		<div id="logo" class=""><a href="./"><img src="img/logo_white_basic.png" class="img-responsive" alt="logo"/></a></div>
		<br><br>
	</div>
	
	<div class="navbar navbar-default navbar-static-top" id="navbar" <?php if(@$_GET['page'] == 'profile' || @$_GET['page'] == 'manager' || @$_GET['page'] == 'mail' || @$_GET['page'] == 'pass') echo 'style="margin-bottom:0px;"'; ?>>
		<div class="container">
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
			</button>
	
			<div class="collapse navbar-collapse navHeaderCollapse">
				<ul class="nav navbar-nav navbar-left">
					<li><a class="bug" href="index.php?page=bugs">Un bug ?</a></li>
					<li><a href="discover"><?php echo $lang['discover']; ?></a></li>
					<li><a href="videoslist"><?php echo $lang['news']; ?></a></li>
					<li><a href="subscriptions"><?php echo $lang['subscriptions']; ?></a></li>
				</ul>
	
				<ul class="nav navbar-nav navbar-right">
					<li><a href="upload"><?php echo $lang['up_vid']; ?></a></li>
					<?php if(isset($session)) { ?>
					<li><a href="profile"><?php echo $lang['member_space']; ?></a></li>
					<li><a href="logout"><?php echo $lang['logout']; ?></a></li>
					<?php } else { ?>
					<li><a href="login"><?php echo $lang['login']; ?></a></li>
					<li><a href="signup"><?php echo $lang['register']; ?></a></li>
					<?php } ?>
				</ul>
		<ul class="nav navbar-nav"><li><form class="navbar-form " role="search" method="get" action="/search">
	        <div class="form-group center-block">
	          <input type="search" required="required" name="q" size="35" class="form-control" placeholder="<?php echo $lang['search'].'...'; ?>">
	        </div>
	        <button type="submit" style="border-radius:25px" class="btn btn-default"><img src="img/search.png" width="14"></button>
	      </form></li></ul>
			</div>
		</div>
	</div> -->