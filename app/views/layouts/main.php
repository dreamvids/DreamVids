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
	
	<!-- BETA UNIQUEMENT. A RETIRER AVANT LA PRODUCTION FINALE -->
		<form method="post" onsubmit="sendBug(this);return false;">
			<input required="required" id="bug" name="bug" type="text" style="box-shadow:0px -2px 5px grey;position:fixed;bottom:0;background-color:#f44;color:white;font-weight:bold;font-size:24px;border:none;border-radius:0px;height:40px;width:100%;z-index:1000000000000;" placeholder="Un bug ? une suggestion ? Ecrivez ici ! (Entrée pour envoyer)" />
		</form>
	<!-- BETA UNIQUEMENT. A RETIRER AVANT LA PRODUCTION FINALE -->
		
		<script>

			/* BETA UNIQUEMENT. A RETIRER AVANT LA PRODUCTION FINALE */
				function sendBug(form) {
					marmottajax.post({
						url: _webroot_+'bugs',

						options: {
							bug: form.bug.value,
							url: document.location.href
						}
					}).then(function(result) {
						form.bug.value = 'Envoyé !';
						setTimeout(function() {
							form.bug.value = '';
						}, 1000);
					});
				}
			/* BETA UNIQUEMENT. A RETIRER AVANT LA PRODUCTION FINALE */

			var _currentpage_ = "<?php echo  isset($currentPage) ? $currentPage : 'default'; ?>";

			var _logged_ = false;

			var _webroot_ = "<?php echo WEBROOT ?>";

			<?php if (Session::isActive()) { ?>

			_logged_ = true;

			var _my_pseudo_ = "<?php echo Session::get()->username ?>",
				_my_avatar_ = "<?php echo Session::get()->getMainChannel()->getAvatar() ?>";

			<?php } ?>

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

							<form method="get" action="<?php echo WEBROOT.'search'; ?>">

								<input type="text" id="top-nav-search-input" name="q" required placeholder="Rechercher" value="<?php echo @$search; ?>">
								<input type="submit" value="">

							</form>

							<div class="user-information">

								<?php if (Session::isActive()) { ?>

									<span class="user-information-button" id="top-nav-user-information-button">

										<img src="<?php echo Session::get()->getMainChannel()->getAvatar() ?>" alt="Votre avatar" id="top-nav-user-information-button-img">
										<h4><?php echo Session::isActive() ? Session::get()->username : 'Bienvenue, invité'; ?></h4>
										<img class="arrow" src="<?php echo IMG.'arrow_top_nav.png'; ?>" alt="Voir vos informations">
										
										<div class="user-information-menu" id="top-nav-user-information-menu">
											<ul>
												<a href="<?php echo WEBROOT.'account/infos'; ?>">Mon compte</a>
												<a href="<?php echo WEBROOT.'account/channels'; ?>">Mes chaînes</a>
												<a href="<?php echo WEBROOT.'playlists'; ?>">Mes playlists</a>
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

						<nav id="header-menu-nav">
							<ul>
							<?php $nb_notifs = (Session::isActive()) ? ChannelAction::count(array('conditions' => "timestamp > ".Session::get()->last_visit." AND recipients_ids LIKE '%;".Session::get()->id.";%'")) : 0;
							$notifs = ($nb_notifs > 0) ? 'data-new="'.$nb_notifs.'"' : ''; ?>
								<li <?php echo (in_array(Utils::getCurrentURI(), array('', 'home'))) ? 'class="current"' : ''; ?>><a href="index.php">Accueil</a></li>
								<li <?php echo (Utils::getCurrentURI() == 'news') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'news'; ?>">Nouveautés</a></li>
								<li <?php echo $notifs; echo (Utils::getCurrentURI() == 'feed') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'feed'; ?>">Flux d'activité</a></li>
								<li <?php echo (Utils::getCurrentURI() == 'upload') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'upload'; ?>">Uploader</a></li>
								<li <?php echo (Utils::getCurrentURI() == 'lives') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'lives'; ?>">Diffuser</a></li>
								<li <?php echo (Utils::getCurrentURI() == 'account/videos') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/channelslist'; ?>">Mes Vidéos</a></li>
								<li><a href="http://dreamvids.spreadshirt.fr/" target="_blank">Boutique</a></li>
							</ul>
						</nav>

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
						DreamVids 2013-<?php echo date('Y'); ?>
						<a href="https://github.com/DreamVids/DreamVids" class="github">Code source sur Github</a>
						
					</div>

					<div class="row">

						<h1>DreamVids</h1>
						
						<a href="<?php echo WEBROOT.'pages/about'; ?>">Qui sommes nous ?</a>
						<a href="<?php echo WEBROOT.'pages/contributors'; ?>">Contributeurs</a>
						<a href="http://blog.dreamvids.fr/" target="_blank">Blog de développement</a>
						<a href="<?php echo WEBROOT.'pages/tos'; ?>">CGU</a>
						<a href="<?php echo WEBROOT.'pages/legal'; ?>">Mentions légales</a>

					</div>

					<div class="row">

						<h1>Partenaires</h1>
						
						<?php
						$partners = Partners::all();
						foreach ($partners as $part) {	
							echo '<a href="'.$part->url.'" target="_blank">'.$part->name.'</a>';
						}
						
						?>
						<a href="javascript:void(0)" onclick="alert('Envoyez un E-Mail à \'antoine [arobase] dreamvids [point] fr\'')">Votre site ici ?</a>

					</div>

					<div class="row">

						<h1>Social</h1>
						
						<a href="https://twitter.com/DreamVids_" target="_blank">Twitter</a>
						<a href="https://facebook.com/DreamVids" target="_blank">Facebook</a>
						<a href="https://github.com/DreamVids" target="_blank">GitHub</a>

					</div>

				</div>

			</footer>

		</div> <!-- #page -->

		<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/scripts.php') : include(VIEW.'layouts/pages/default/scripts.php'); ?>

	</body>

</html>