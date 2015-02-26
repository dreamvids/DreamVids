<!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="<?php echo isset($css) ? $css : CSS.'style.css'; ?>">


		<link rel="icon" href="<?php echo IMG.'favicon.png'; ?>" />

		<title>Erreur - DreamVids</title>
	</head>

	<body>


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
					</div>
				</div>
				</header>
			<?php include($content); ?>
			<br>

			<footer class="footer">

				<div class="inner">

					<div class="row">

						<h1>DreamVids</h1>
						
						<a href="<?php echo WEBROOT.'pages/about'; ?>">Qui sommes nous ?</a>
						<a href="<?php echo WEBROOT.'pages/contributors'; ?>">Contributeurs</a>
						<a href="<?php echo WEBROOT.'pages/tos'; ?>">CGU</a>
						<a href="http://dreamvids.spreadshirt.fr/" target="_blank">Boutique</a>
						<a href="http://blog.dreamvids.fr/" target="_blank">Blog de développement</a>

					</div>

					<div class="row">

						<h1>Social</h1>
						
						<a href="https://twitter.com/DreamVids_" target="_blank">Twitter</a>
						<a href="https://facebook.com/DreamVids" target="_blank">Facebook</a>
						<a href="https://github.com/DreamVids" target="_blank">GitHub</a>

					</div>

					<div class="rights">

						<span class="love">Fait avec le <i>♥</i></span>

						<a class="license" rel="license" title="Cette œuvre est mise à disposition selon les termes de la Licence Creative Commons Attribution - Pas d’Utilisation Commerciale - Partage dans les Mêmes Conditions 4.0 International" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licence Creative Commons" src="<?php echo IMG.'license.png'; ?>" /></a>
						DreamVids 2013-<?php echo date('Y'); ?>
						<a href="https://github.com/DreamVids/DreamVids" class="github">Code source sur Github</a>
						
					</div>
				</div>

			</footer>

		</div> <!-- #page -->

	</body>

</html>
