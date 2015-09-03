<script type="text/javascript">var servers = [];</script>
<div class="row">
	<h1>Dashboard</h1>
  <div class="col-lg-3 col-sm-6 col-xs-12">
    <div class="thumbnail">
      <img src="<?= StaffContact::getImageName(Session::get()); ?>" alt="Avatar">
      <div class="caption">
        <h3><?= Utils::secure(StaffContact::getShownName(Session::get())); ?></h3>
        
        <p><?= Utils::secure(StaffContact::getDescription(Session::get())); ?>
            <a href="<?= WEBROOT . 'admin/staffContactDetails/edit_public_infos/' ?>" class="btn btn-primary" role="button">Changer mes infos officielles</a>
        </p>
        <p>
        </p>
      </div>
    </div>
  </div>
	<div class="col-lg-6 col-sm-6 col-xs-12">
<?php foreach($storage_server as $srv): ?>
	<script type="text/javascript">servers.push('<?= $srv; ?>');</script>
        <div class="panel panel-primary">
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
                   <div class="clearfix"></div>
                </div>
            </a>
        </div>
<?php endforeach; ?>
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-support fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $tickets ?> / <?= $all_tickets ?></div>
                        <div>Ticket<?= $tickets > 1 ? 's' : '' ?> à traiter</div>
                    </div>
                </div>
            </div>
            <a href="<?= WEBROOT . 'admin/tickets'; ?>">
                <div class="panel-footer">
                    <span class="pull-left">Voir les tickets</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
	</div>
    <div class="col-lg-3 col-md-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Informations :</div>
            <div class="panel-body">
                <p>Votre adresse email @dreamvids.fr est :<br>
                <b>[prénom]@dreamvids.fr</b><br>
                Pour acceder au webmail il suffit de se rendre sur <a href='https://webmail.dreamvids.fr/' target="_blank">https://webmail.dreamvids.fr/</a> (pensez à ajouter une exception de sécurité). Votre mot de passe vous a été communiqué par email à l'adresse que vous avez indiqué <a href="<?= WEBROOT; ?>admin/staffContactDetails">ICI</a>.</p>
                
            </div>
            <div class="panel-body">
                <p>Pour recuperer et envoyer des mail avec un client utilisez le nom d'utilisateur : <b>[prénom]@dreamvids.fr</b><br>
               Et utilisez le serveur <code>node-email-1.pulsepanel.eu</code> en utilisant TLS/SSL</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <?php include VIEW.'admin/news/home.php'; ?>
    </div>
</div>
