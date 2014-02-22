<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="<?php echo isset($css) ? $css : CSS.'index.css'; ?>">

		<meta name="viewport" content="width = device-width, initial-scale = 0.9, maximum-scale = 1.0, user-scalable = no">

		<link rel="icon" href="<?php echo IMG.'favicon.png'; ?>" />

		<title>DreamVids</title>
	</head>

	<body>
		<header>
			<div id="top-nav">
				<div id="inner-top-nav">
					<div id="inner-top-nav-left">
						<a href="<?php echo WEBROOT; ?>">
							<img src="<?php echo IMG.'icon_logo.png'; ?>" alt="Logo DreamVids" id="top-nav-logo-icon" class="top-nav-icon-logo" />
							<img src="<?php echo IMG.'text_logo.png'; ?>" alt="DreamVids" id="top-nav-logo-text" class="top-nav-text-logo" />
						</a>
					</div>
					<div id="inner-top-nav-right">

						<form action="post" action="#">
							<input type="text" id="top-nav-search-input" placeholder="Rechercher">
							<input type="submit" value="">
						</form>

						<div id="top-nav-user-information">
							<a id="top-nav-user-information-button">
								<img src="<?php echo IMG.'avatar_top_nav.png'; ?>" alt="Votre avatar" id="top-nav-user-information-button-img">

								<?php if(Session::isActive()) { ?>
									<h4 id="top-nav-user-information-button-h4"><?php echo Session::get()->username; ?></h4>
								<?php } else { ?>
									<h4 id="top-nav-user-information-button-h4">Espace membre</h4>
								<?php } ?>

								<img src="<?php echo IMG.'arrow_top_nav.png'; ?>" alt="Voir vos informations" id="top-nav-user-arrow">

								<?php if(Session::isActive()) { ?>
								<div id="top-nav-user-information-menu">
									<ul>
										<li><a href="#">Ma chaîne</a></li>
										<li><a href="#">Mon compte</a></li>
										<li><a href="#">Messagerie</a></li>
										<li><a href="<?php echo WEBROOT.'login/signout'; ?>">Déconnexion</a></li>
									</ul>
								</div>
								<?php } else { ?>
								<div id="top-nav-user-information-menu">
									<ul>
										<li><a href="<?php echo WEBROOT.'login'; ?>">Connexion</a></li>
										<li><a href="<?php echo WEBROOT.'register'; ?>">Inscription</a></li>
									</ul>
								</div>
								<?php } ?>
							</a>
						</div>

					</div>
				</div>
			</div>
			<div id="bottom-nav">
				<div id="inner-bottom-nav">
					<nav>
						<ul>
							<li><a href="<?php echo WEBROOT.'videolist/subscriptions'; ?>">Abonnements</a><div class="bottom-nav-underline"></div></li>
							<li><a href="<?php echo WEBROOT.'videolist/feed'; ?>">Flux</a><div class="bottom-nav-underline"></div></li>
							<li><a href="<?php echo WEBROOT.'videolist/discover'; ?>">Découvrir</a><div class="bottom-nav-underline"></div></li>
						</ul>
					</nav>
					<a href="#" id="mobile-nav-icon"><img src="<?php echo IMG.'nav_mobile_icon.png'; ?>" alt="Afficher le menu mobile"></a>
					<div id="bottom-nav-social">
						<ul>
							<li><a href="https://www.facebook.com/dreamvids" target="_blank"><img src="<?php echo IMG.'icon_facebook.png'; ?>" alt="Facebook"></a></li>
							<li><a href="https://twitter.com/DreamVids_" target="_blank"><img src="<?php echo IMG.'icon_twitter.png'; ?>" alt="Twitter"></a></li>
						</ul>
					</div>
				</div>
			</div>
		</header>

		<br>
		<?php include($content); ?>
		<br>

		

		<script src="<?php echo JS.'ajax.js'; ?>"></script>
		<script src="<?php echo JS.'interactions.js'; ?>"></script>
	</body>
</html>