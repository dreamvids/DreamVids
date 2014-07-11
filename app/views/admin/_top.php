<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Panel de gestion - DreamVids</title>

		<!-- Bootstrap core CSS -->
		<link href="<?php echo PANEL.'css/bootstrap.css'; ?>" rel="stylesheet">

		<!-- Add custom CSS here -->
		<link href="<?php echo PANEL.'css/sb-admin.css'; ?>" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo PANEL.'font-awesome/css/font-awesome.min.css'; ?>">
		<!-- Page Specific CSS -->
		<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
	</head>

	<body>

		<div id="wrapper">

			<!-- Sidebar -->
			<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.html">DreamVids - Reports de vidéos</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav side-nav">
						<li><a href="<?php echo WEBROOT.'admin'; ?>"><i class="fa fa-dashboard"></i> Vue globale</a></li>
						<li><a href="<?php echo WEBROOT.'admin/reports'; ?>"><i class="fa fa-edit"></i> Reports</a></li>
						<li><a href="<?php echo WEBROOT.'admin/users'; ?>"><i class="fa fa-wrench"></i> Gestion des utilisateurs</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right navbar-user">
						<li class="dropdown user-dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo Session::get()->username ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="fa fa-user"></i> Mon profile</a></li>
								<li class="divider"></li>
								<li><a href="<?php echo WEBROOT.'login/signout'; ?>"><i class="fa fa-power-off"></i> Déconnexion</a></li>
							</ul>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</nav>

			<!-- content -->
