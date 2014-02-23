<?php $this->renderView('admin/_top', $data, false); ?>

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
						<a class="list-group-item">
							<!--<span class="badge pull-left">Il y a 4 minutes</span>-->
							<i></i> <?php echo $vid->title.' - ID: '.$vid->id; ?>
							<span class="btn btn-success btn-xs pull-right" onclick="cancelFlag('<?php echo $vid->id; ?>');">Annuler</span>
							<span class="btn btn-danger btn-xs pull-right" onclick="suspendVideo('<?php echo $vid->id; ?>');">
								Suspendre
							</span>
							<span class="btn btn-info btn-xs pull-right" onclick="window.location = '<?php echo WEBROOT.'watch/'.$vid->id; ?>'">Voir</span>
						</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.row -->

</div><!-- /#page-wrapper -->

<?php $this->renderView('admin/_btm', $data, false); ?>