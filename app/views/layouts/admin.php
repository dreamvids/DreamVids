<!DOCTYPE html>
<html>
	<head>
		<title>DreamVids - Administration</title>
		<meta charset="utf-8">

		<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/meta.php') : include(VIEW.'layouts/pages/default/meta.php'); ?>

		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<link rel="stylesheet" href="<?php echo CSS.'admin.css'; ?>">
	</head>

	<body>
		<div class="page">
			<div id="menu">
				<div class="pure-menu pure-menu-open">
					<a class="pure-menu-heading" href="<?php echo WEBROOT.'admin'; ?>">DreamVids</a>

					<ul>
						<li><a href="<?php echo WEBROOT.'admin/dashboard'; ?>">Tableau de bord</a></li>
						<li><a href="<?php echo WEBROOT.'admin/videos'; ?>">Videos</a></li>
						<li><a href="<?php echo WEBROOT.'admin/channels'; ?>">Chaînes</a></li>
						<li><a href="<?php echo WEBROOT.'admin/comments'; ?>">Commentaires</a></li>
						<li><a href="<?php echo WEBROOT.'admin'; ?>">Déconnexion</a></li>
					</ul>
				</div>
			</div>

			<?php include($content); ?>
			<br>
		</div>

		<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/scripts.php') : include(VIEW.'layouts/pages/default/scripts.php'); ?>
	</body>
</html>