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
					<a class="navbar-brand" href="index.html">DreamVids - Gestion</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav side-nav">
						<li class="active"><a href="<?php echo WEBROOT.'admin'; ?>"><i class="fa fa-dashboard"></i> Vue globale</a></li>
						<li><a href="<?php echo WEBROOT.'admin/reports'; ?>"><i class="fa fa-edit"></i> Reports</a></li>
						<li><a href="<?php echo WEBROOT.'admin/users'; ?>"><i class="fa fa-wrench"></i> Gestion des utilisateurs</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right navbar-user">
						<li class="dropdown user-dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo Session::get()->username ?> <b class="caret"></b></a>
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
							<li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
						</ol>
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Bienvenue, cher(e) modérateur/administrateur DreamVids ! Ici se trouvent toute les informations et options de gestion dont vous disposez. Utilisez-les avec précautions !
						</div>
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
							<a href="<?php echo WEBROOT.'admin/reports'; ?>">
								<div class="panel-footer announcement-bottom">
									<div class="row">
										<div class="col-xs-6">
											Gérer
										</div>
										<div class="col-xs-6 text-right">
											<i class="fa fa-arrow-circle-right"></i>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div><!-- /.row -->

				<div class="row">
					<div class="col-lg-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-clock-o"></i> Dernières vidéos reportées</h3>
							</div>
							<div class="panel-body">
								<div class="list-group">
									<?php foreach ($lastReportedVids as $vid) { ?>
									<a href="#" class="list-group-item">
										<span class="badge">Tout de suite</span>
										<i class="fa fa-edit"></i> <?php echo $vid->title; ?>
									</a>
									<?php } ?>
								</div>
								<div class="text-right">
									<a href="#">Touts les reports <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title"><i class="fa fa-money"></i> Utilisateurs les plus signalés</h3>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-bordered table-hover table-striped tablesorter">
										<thead>
											<tr>
												<th>Nom <i class="fa fa-sort"></i></th>
												<th>Abonnés <i class="fa fa-sort"></i></th>
												<th>Date d'inscription <i class="fa fa-sort"></i></th>
												<th>Nombre de reports <i class="fa fa-sort"></i></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>PoneySataniste</td>
												<td>45</td>
												<td>666/666/666</td>
												<td>5</td>
											</tr>
											<tr>
												<td>TaMère</td>
												<td>3</td>
												<td>10/21/2013</td>
												<td>4</td>
											</tr>
											<tr>
												<td>LeChienMéchant</td>
												<td>6</td>
												<td>45/789/2013</td>
												<td>2</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="text-right">
									<a href="#">Voir tout les délinquants <i class="fa fa-arrow-circle-right"></i></a>
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
