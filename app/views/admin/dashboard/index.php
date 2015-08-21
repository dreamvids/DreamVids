<script type="text/javascript">var servers = [];</script>
<div class="row">
	<h1>Dashboard</h1>
	<h2>Status global : </h2>
	<div class="col-md-12">
	</div>
<?php foreach($storage_server as $srv): ?>
	<script type="text/javascript">servers.push('<?= $srv; ?>');</script>
	<div class="col-lg-3 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-hdd-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge" id="<?=$srv; ?>_space">-</div>
                        <div>Espace restant [<?= $srv ?>]</div>
                    </div>
                </div>
            </div>
            <a href="<?= WEBROOT . 'admin/disk'; ?>">
                <div class="panel-footer">
                    <span class="pull-left">Plus d'info</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
	</div>
<?php endforeach; ?>
</div>

