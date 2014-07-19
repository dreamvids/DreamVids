<!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="<?php echo isset($css) ? $css : CSS.'style.min.css'; ?>">

		<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/meta.php') : include(VIEW.'layouts/pages/default/meta.php'); ?>

		<link rel="icon" href="<?php echo IMG.'favicon.png'; ?>" />

		<title><?php echo (isset($currentPageTitle)) ? $currentPageTitle : 'DreamVids'; ?></title>

	</head>

	<body>
		
		<script>

			var _currentpage_ = "<?php echo  isset($currentPage) ? $currentPage : 'default'; ?>";

		</script>

		<div id="page">

			<header class="header">

				<div class="top">

					<div class="inner">

						<div class="left">

							<a href="<?php echo WEBROOT; ?>">
								<img src="<?php echo IMG.'icon_logo.png'; ?>" alt="Logo DreamVids" id="top-nav-logo-icon" class="top-nav-icon-logo" />
								<img src="<?php echo IMG.'text_logo.png'; ?>" alt="DreamVids" id="top-nav-logo-text" class="top-nav-text-logo" />
							</a>

						</div>

						<div class="right">

							<form method="get" action="search">

								<input type="text" id="top-nav-search-input" name="q" placeholder="Rechercher">
								<input type="submit" value="">

							</form>

							<div class="user-information">

								<?php if (Session::isActive()) { ?>

									<span class="user-information-button" id="top-nav-user-information-button">

										<img src="http://lorempicsum.com/simpsons/255/200/5" alt="Votre avatar" id="top-nav-user-information-button-img">
										<h4><?php echo Session::isActive() ? Session::get()->username : 'Bienvenue, invité'; ?></h4>
										<img class="arrow" src="<?php echo IMG.'arrow_top_nav.png'; ?>" alt="Voir vos informations">
										
										<div class="user-information-menu" id="top-nav-user-information-menu">
											<ul>
												<a href="<?php echo WEBROOT.'account'; ?>">Mon compte</a>
												<a href="<?php echo WEBROOT.'account/channels'; ?>">Mes chaînes</a>
												<a href="<?php echo WEBROOT.'account/messages'; ?>">Mes messages</a>
												<a href="<?php echo WEBROOT.'login/signout' ?>">Déconnexion</a>
											</ul>
										</div>

									</span>

								<?php } else { ?>

									<div class="connection">

										<a href="<?php echo WEBROOT.'login'; ?>">Connexion</a>
										<p>/</p>
										<a href="<?php echo WEBROOT.'register'; ?>">Inscription</a>

									</div>

								<?php } ?>

							</div>

						</div>
						
					</div>

				</div> <!-- .top -->

				<div class="bottom">

					<div class="inner">

						<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/nav.php') : include(VIEW.'layouts/pages/default/nav.php'); ?>

						<span class="mobile-nav-icon" id="mobile-nav-icon"><p></p></span>

						<div class="nav-social">
							<ul>
								<li><a href="https://www.facebook.com/dreamvids" target="_blank"><img src="<?php echo IMG.'icon_facebook.png'; ?>" alt="Facebook"></a></li>
								<li><a href="https://twitter.com/DreamVids_" target="_blank"><img src="<?php echo IMG.'icon_twitter.png'; ?>" alt="Twitter"></a></li>
							</ul>
						</div>

					</div>

				</div> <!-- .bottom -->
			</header>

			<?php include($content); ?>
			<br>

			<footer class="footer">

				<div class="inner">

					<div class="rights">

						<span class="love">Fait avec le <i>♥</i></span>

						<a class="license" rel="license" title="Cette œuvre est mise à disposition selon les termes de la Licence Creative Commons Attribution - Pas d’Utilisation Commerciale - Partage dans les Mêmes Conditions 4.0 International" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licence Creative Commons" src="<?php echo IMG.'license.png'; ?>" /></a>
						dreamvids.fr - CopyLeft DeamVids 2013-<?php echo date('Y'); ?>
						<a href="https://github.com/DreamVids/DreamVids" class="github">Code source sur Github</a>
						
					</div>

				</div>

			</footer>

		</div> <!-- #page -->

		<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/scripts.php') : include(VIEW.'layouts/pages/default/scripts.php'); ?>

	</body>

</html>