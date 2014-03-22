<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="<?php echo isset($css) ? $css : CSS.'style.css'; ?>">

		<meta name="viewport" content="width = device-width, initial-scale = 0.9, maximum-scale = 1.0, user-scalable = no">

		<link rel="icon" href="<?php echo IMG.'favicon.png'; ?>" />

		<title>DreamVids</title>
	</head>

	<body>
		<div id="page">
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

							<form method="get" action="search">
								<input type="text" id="top-nav-search-input" name="q" placeholder="Rechercher">
								<input type="submit" value="">
							</form>

							<div id="top-nav-user-information">
								<a id="top-nav-user-information-button">
									<?php if(Session::isActive()) { ?>
										<img src="http://lorempicsum.com/simpsons/255/200/5" alt="Votre avatar" id="top-nav-user-information-button-img">
										<h4 id="top-nav-user-information-button-h4"><?php echo Session::get()->username; ?></h4>
										<img src="<?php echo IMG.'arrow_top_nav.png'; ?>" alt="Voir vos informations" id="top-nav-user-arrow">

										<div id="top-nav-user-information-menu">
											<ul>
												<li><a href="<?php echo WEBROOT.'channel/'.Session::get()->username; ?>">Ma chaîne</a></li>
												<li><a href="<?php echo WEBROOT.'account'; ?>">Mon compte</a></li>
												<li><a href="<?php echo WEBROOT.'login/signout'; ?>">Déconnection</a></li>
											</ul>
										</div>
									<?php } else { ?>
										<img src="http://lorempicsum.com/simpsons/255/200/5" alt="Votre avatar" id="top-nav-user-information-button-img">
										<h4 id="top-nav-user-information-button-h4">Bienvenue, invité !</h4>

										<img src="<?php echo IMG.'arrow_top_nav.png'; ?>" alt="Voir vos informations" id="top-nav-user-arrow">

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
								<li><a href="<?php echo WEBROOT; ?>">Accueil</a></li>
								<li><a href="<?php echo WEBROOT.'discover'; ?>">Découvrir</a></li>
								<li><a href="<?php echo WEBROOT.'feed'; ?>">Flux d'activité</a></li>
								<li><a href="<?php echo WEBROOT.'upload'; ?>">Uploader</a></li>
							</ul>
						</nav>
						<span id="mobile-nav-icon"><p></p></span>
						<div id="bottom-nav-social">
							<ul>
								<li><a href="https://www.facebook.com/dreamvids" target="_blank"><img src="<?php echo IMG.'icon_facebook.png'; ?>" alt="Facebook"></a></li>
								<li><a href="https://twitter.com/DreamVids_" target="_blank"><img src="<?php echo IMG.'icon_twitter.png'; ?>" alt="Twitter"></a></li>
							</ul>
						</div>
					</div>
				</div>
			</header>

			<?php include($content); ?>
			<br>

			<footer>
				<div id="inner-footer">
					<div class="rights">
						<span class="love">Made with <i>♥</i> approximately in France</span>

						<a class="license" rel="license" title="Cette œuvre est mise à disposition selon les termes de la Licence Creative Commons Attribution - Pas d’Utilisation Commerciale - Partage dans les Mêmes Conditions 4.0 International" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licence Creative Commons" src="<?php echo IMG.'license.png'; ?>" /></a>
						dreamvids.fr - CopyLeft DeamVids 2013-2014
						<a href="https://github.com/Vetiore/DreamVids" class="github">Code source sur Github</a>
					</div>
				</div>
			</footer>
		</div>

		<script src="<?php echo JS.'ajax.js'; ?>"></script>
		<script src="<?php echo JS.'interactions.js'; ?>"></script>
		<script src="<?php echo JS.'slider.js'; ?>"></script>
		<script src="<?php echo JS.'bgLoader.js'; ?>"></script>
	</body>
</html>