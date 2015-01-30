<?php require_once MODEL.'partners.php'; ?>

<!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8">

		<link rel="stylesheet" type="text/css" href="<?php echo isset($css) ? $css : CSS.'style.min.css'; ?>">

		<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/meta.php') : include(VIEW.'layouts/pages/default/meta.php'); ?>

		<link rel="icon" href="<?php echo IMG.'favicon.png'; ?>" />

		<title><?php echo (isset($currentPageTitle)) ? $currentPageTitle.' - ' : ''; ?>DreamVids</title>
	</head>

	<body>
<?php if(!(isset($_COOKIE['checkCookie']) && $_COOKIE['checkCookie'] == 1)) { ?>
		<!-- Encart pour les cookies mmmmh gateaux... -->

		<div id="cookie-box" class="cookie-box">En navigant sur ce site vous acceptez l'utilisation des <a class="cookie-box__link" href="<?php echo WEBROOT.'pages/cookies'; ?>">cookies</a>. 
<?php if(!(isset($currentPage) && $currentPage == "register")){ ?>		
			<a class="cookie-box__button" onclick="closeCookie(); setCookie('checkCookie', '1', 365);" title="J'accepte l'utilisation des cookies">J'ai compris</a>
<?php } ?>
		</div>
		<!-- Encart pour les cookies mmmmh gateaux... -->
<?php } ?>
		<script>

			var _currentpage_ = "<?php echo  isset($currentPage) ? $currentPage : 'default'; ?>";

			var average_background_color = [<?php echo (isset($average_background_color) ? $average_background_color : ''); ?>];
			
			var _logged_ = false;

			var _webroot_ = "<?php echo WEBROOT ?>";

			<?php if (Session::isActive()) { ?>

			_logged_ = true;

			var _my_pseudo_ = "<?php echo Session::get()->username ?>",
				_my_avatar_ = "<?php echo Session::get()->getMainChannel()->getAvatar() ?>",
				_last_volume_setting_ = <?php echo Session::get()->getSoundSetting() ?>,
				_last_definition_setting_ = <?php echo Session::get()->getDefinitionSetting() ?>;

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
						<div class="center">

							<form method="get" onsubmit="document.location.href=_webroot_+'search/&q='+encodeURIComponent(encodeURIComponent(document.getElementById('top-nav-search-input').value));return false;" action="<?php echo WEBROOT.'search'; ?>">

								<fieldset class="search_bar">
									<input type="text" id="top-nav-search-input" name="q" required placeholder="<?php echo Translator::get("header.search"); ?>" value="<?php echo @$_SESSION["last_search"]; ?>">
									<input type="submit" value="">
								</fieldset>

							</form>

						</div>
						<div class="right">

							<div class="user-information">

								<?php if (Session::isActive()) { ?>

									<span class="user-information-button" id="top-nav-user-information-button">

										<img src="<?php echo Session::get()->getMainChannel()->getAvatar() ?>" alt="Votre avatar" id="top-nav-user-information-button-img">
										<h4><?php echo Session::get()->username; ?></h4>
										<img class="arrow" src="<?php echo IMG.'arrow_top_nav.png'; ?>" alt="Voir vos informations">
										
										<div class="user-information-menu" id="top-nav-user-information-menu">
											<ul>
											<?php if (Session::get()->isAdmin() or Session::get()->isModerator() or Session::get()->isTeam()): ?>
												<a href="<?php echo WEBROOT.'admin'; ?>"><?php echo Translator::get("header.menu.user_submenu.admin"); ?></a>
											<?php endif ?>
												<a href="<?php echo WEBROOT.'account/infos'; ?>"><?php echo Translator::get("header.menu.user_submenu.account"); ?></a>
												<a href="<?php echo WEBROOT.'account/channels'; ?>"><?php echo Translator::get("header.menu.user_submenu.channels"); ?></a>
												<a href="<?php echo WEBROOT.'playlists'; ?>"><?php echo Translator::get("header.menu.user_submenu.playlists"); ?></a>
												<a href="<?php echo WEBROOT.'account/messages'; ?>"><?php echo Translator::get("header.menu.user_submenu.messages"); ?></a>
												<a href="<?php echo WEBROOT.'login/signout' ?>"><?php echo Translator::get("header.menu.user_submenu.logout"); ?></a>
											</ul>
										</div>

									</span>

								<?php } else { ?>

									<div class="connection">

										<a href="<?php echo Utils::generateLoginURL(); ?>"><?php echo Translator::get("header.menu.user_submenu.login"); ?></a>
										<p>/</p>
										<a href="<?php echo WEBROOT.'register'; ?>"><?php echo Translator::get("header.menu.user_submenu.register"); ?></a>

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
								<li <?php echo (in_array(Utils::getCurrentURI(), array('', 'home'))) ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT; ?>"><?php echo Translator::get("header.menu.home"); ?></a></li>
								<li <?php echo (Utils::getCurrentURI() == 'news') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'news'; ?>"><?php echo Translator::get("header.menu.news"); ?></a></li>
								<li <?php echo $notifs; echo (Utils::getCurrentURI() == 'feed') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'feed'; ?>"><?php echo Translator::get("header.menu.flux"); ?></a></li>
								<li <?php echo (Utils::getCurrentURI() == 'upload') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'upload'; ?>"><?php echo Translator::get("header.menu.upload"); ?></a></li>
								<li <?php echo (Utils::getCurrentURI() == 'lives') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'lives'; ?>"><?php echo Translator::get("header.menu.live"); ?></a></li>
								<li <?php echo (Utils::getCurrentURI() == 'account/videos') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/channelslist'; ?>"><?php echo Translator::get("header.menu.videos"); ?></a></li>
								<li <?php echo (Utils::getCurrentURI() == 'assistance') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'assistance'; ?>"><?php echo Translator::get("header.menu.assist"); ?></a></li>
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

					<div class="row">

						<h1>DreamVids</h1>
						
						<a href="<?php echo WEBROOT.'pages/about'; ?>"><?php echo Translator::get("footer.about"); ?></a>
						<a href="<?php echo WEBROOT.'pages/contributors'; ?>"><?php echo Translator::get("footer.contributors"); ?></a>
						<a href="<?php echo WEBROOT.'pages/tos'; ?>"><?php echo Translator::get("footer.tos"); ?></a>
						<a href="http://dreamvids.spreadshirt.fr/" target="_blank"><?php echo Translator::get("footer.shop"); ?></a>
						<a href="http://blog.dreamvids.fr/" target="_blank"><?php echo Translator::get("footer.dev_blog"); ?></a>
<?php if(Session::isActive()){ ?>						
						<a href="<?php echo WEBROOT.'account/language/'?>"><?php echo Translator::get("footer.language"); ?></a>
<?php } ?>
					</div>

					<div class="row">

						<h1><?php echo Translator::get("footer.partners"); ?></h1>
						
						<?php
						$partners = Partners::all();
						foreach ($partners as $part) {	
							echo '<a href="'.$part->url.'" target="_blank">'.$part->name.'</a>';
						}
						
						?>
						<a href="javascript:void(0)" onclick="alert('<?php echo Translator::get("footer.become_partner.popup"); ?>')"><?php echo Translator::get("footer.become_partner.title"); ?></a>

					</div>

					<div class="row">

						<h1>Social</h1>
						
						<a href="https://twitter.com/DreamVids_" target="_blank">Twitter</a>
						<a href="https://facebook.com/DreamVids" target="_blank">Facebook</a>
						<a href="https://github.com/DreamVids" target="_blank">GitHub</a>

					</div>

					<div class="rights">

						<span class="love"><?php echo Translator::get("footer.made-with"); ?><i>♥</i></span>

						<a class="license" rel="license" title="Cette œuvre est mise à disposition selon les termes de la Licence Creative Commons Attribution - Pas d’Utilisation Commerciale - Partage dans les Mêmes Conditions 4.0 International" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licence Creative Commons" src="<?php echo IMG.'license.png'; ?>" /></a>
						DreamVids 2013-<?php echo date('Y'); ?>
						<a href="https://github.com/DreamVids/DreamVids" class="github">Code source sur Github</a>
						
					</div>

					<!-- BETA UNIQUEMENT. A RETIRER AVANT LA PRODUCTION FINALE -->
						<br>
						<br>
					<!-- / -->

				</div>

			</footer>

		</div> <!-- #page -->

		<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/scripts.php') : include(VIEW.'layouts/pages/default/scripts.php'); ?>

	</body>

</html>
