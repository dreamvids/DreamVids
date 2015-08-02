<div class="row">
	<h1>Dashboard</h1>
	<h2>Status global : </h2>
	<div class="col-md-12">
	</div>
	<div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-support fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= $tickets ?></div>
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
</div>
<div class="row">
  <h2>Moi : </h2>
  <div class="col-sm-6 col-md-4">
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
</div>