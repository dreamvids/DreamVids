<?php $this->renderView('admin/_top', $data, false); ?>

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
						<a href="<?php echo WEBROOT.'watch/'.$vid->id; ?>" class="list-group-item">
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

<?php $this->renderView('admin/_btm', $data, false); ?>