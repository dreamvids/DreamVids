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
						<li class="active"><a href="<?php echo WEBROOT.'admin/reports'; ?>"><i class="fa fa-edit"></i> Reports</a></li>
						<li><a href="<?php echo WEBROOT.'admin/users'; ?>"><i class="fa fa-wrench"></i> Gestion des utilisateurs</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right navbar-user">
						<li class="dropdown user-dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> ModoTropCool <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="fa fa-user"></i> Mon profile</a></li>
								<li class="divider"></li>
								<li><a href="#"><i class="fa fa-power-off"></i> Déconnexion</a></li>
							</ul>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</nav>

			<div id="page-wrapper">

				<div class="row">
					<div class="col-lg-12">
						<h1>Panel de modération <small>Gestion DreamVids</small></h1>
						<ol class="breadcrumb">
							<li class="active"><i class="fa fa-dashboard"></i> Reports</li>
						</ol>
					</div>
				</div><!-- /.row -->

				<div class="row">
					<div class="col-lg-3">
						<div class="panel panel-warning">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-6">
										<i class="fa fa-check fa-5x"></i>
									</div>
									<div class="col-xs-6 text-right">
										<p class="announcement-heading"><?php echo count($reportedVids); ?></p>
										<p class="announcement-text">Vidéos reportées</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /.row -->

				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-clock-o"></i> Vidéos reportées</h3>
							</div>
							<div class="panel-body">
								<div class="list-group">
									<?php foreach ($reportedVids as $vid) { ?>
									<a href="#" class="list-group-item">
										<!--<span class="badge pull-left">Il y a 4 minutes</span>-->
										<i></i> <?php echo $vid->title; ?>
										<span class="btn btn-success btn-xs pull-right">Annuler</span>
										<span class="btn btn-danger btn-xs pull-right">Suspendre</span>
									</a>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /.row -->

			</div><!-- /#page-wrapper -->

		</div><!-- /#wrapper -->

		<!-- JavaScript -->
		<script src="<?php echo PANEL.'js/jquery-1.10.2.js'; ?>"></script>
		<script src="<?php echo PANEL.'js/bootstrap.js'; ?>"></script>

		<!-- Page Specific Plugins -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
		<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
		<script src="<?php echo PANEL.'js/morris/chart-data-morris.js'; ?>"></script>
		<script src="<?php echo PANEL.'js/tablesorter/jquery.tablesorter.js'; ?>"></script>
		<script src="<?php echo PANEL.'js/tablesorter/tables.js'; ?>"></script>

	</body>
</html>
