<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="<?php echo isset($css) ? $css : CSS.'style.css'; ?>">

		<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/meta.php') : include(VIEW.'layouts/pages/default/meta.php'); ?>

		<link rel="icon" href="<?php echo IMG.'favicon.png'; ?>" />

		<title><?php echo (isset($currentPageTitle)) ? $currentPageTitle : 'DreamVids'; ?></title>
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
								<span id="top-nav-user-information-button">
									<img src="http://lorempicsum.com/simpsons/255/200/5" alt="Votre avatar" id="top-nav-user-information-button-img">
									<h4 id="top-nav-user-information-button-h4"><?php echo Session::isActive() ? Session::get()->username : 'Bienvenue, invité'; ?></h4>
									
									<?php if (Session::isActive()) { ?>
										<img src="<?php echo IMG.'arrow_top_nav.png'; ?>" alt="Voir vos informations" id="top-nav-user-arrow">
										<div id="top-nav-user-information-menu">
											<ul>
												<a href="<?php echo WEBROOT.'channel/'.Session::get()->username; ?>">Ma chaîne</a>
												<a href="<?php echo WEBROOT.'account'; ?>">Mon compte</a>
												<a href="messages">Mes messages</a>
												<a href="#">Déconnexion</a>
											</ul>
										</div>
									<?php } else { ?>
										<img src="<?php echo IMG.'arrow_top_nav.png'; ?>" alt="Voir vos informations" id="top-nav-user-arrow">
										<div id="top-nav-user-information-menu">
											<ul>
												<a href="<?php echo WEBROOT.'login'; ?>">Connexion</a>
												<a href="<?php echo WEBROOT.'register'; ?>">Inscription</a>
											</ul>
										</div>
									<?php } ?>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div id="bottom-nav">
					<div id="inner-bottom-nav">

						<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/nav.php') : include(VIEW.'layouts/pages/default/nav.php'); ?>

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

			<footer>
				<div id="inner-footer">
					<div class="row">
						<h1>DreamVids</h1>
						
						<a href="<?php echo WEBROOT.'contributors'; ?>">Contributeurs</a>
						<a href="http://dreamvids.net/">Blog de développement</a>
						<a href="<?php echo WEBROOT.'bugs'; ?>">Reporter un bug</a>
					</div>

					<div class="row">
						<h1>Partenaires</h1>
						
						<a href="http://twitter.com/iamauska" target="_blank">iamauska</a>
			      		<a href="http://www.webpodcasteurs.fr/" target="_blank">Web Podcasteurs</a>
			      		<a href="http://geek-info.org/" target="_blank">Geek-info</a>
			      		<a href="http://inthekey.fr/" target="_blank">InTheKey</a>
			      		<a href="javascript:void(0)" onclick="alert('Envoyez un E-Mail à \'jeremy [at] dreamvids [dot] fr\'')">Votre site ici ?</a>
					</div>

					<div class="row">
						<h1>Social</h1>
						
						<a href="https://twitter.com/DreamVids_">Twitter</a>
						<a href="https://facebook.com/DreamVids">Facebook</a>
						<a href="http://webchat.freenode.net/?channels=%23DreamVids">Chat IRC</a>
					</div>

					<div class="rights">
						<span class="love">Fait avec le <i>♥</i></span>
						
						<a class="license" rel="license" title="Cette œuvre est mise à disposition selon les termes de la Licence Creative Commons Attribution - Pas d’Utilisation Commerciale - Partage dans les Mêmes Conditions 4.0 International" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licence Creative Commons" src="<?php echo IMG.'license.png'; ?>" /></a>
						dreamvids.fr - CopyLeft DeamVids 2013-<?php echo date('Y'); ?>
						<a href="https://github.com/Vetiore/DreamVids" class="github">Code source sur Github</a>
					</div>
				</div>
			</footer>
		</div>

		<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/scripts.php') : include(VIEW.'layouts/pages/default/scripts.php'); ?>
	</body>
</html>