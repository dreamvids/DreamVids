<div class="row">
    <h1>Gestion des types de tickets à traiter</h1>
	<?php include VIEW.'layouts/messages_bootstrap.php'; ?>
    <form action="<?= WEBROOT; ?>admin/ticketlevels/edit_users" method="post">
        <input type="hidden" name="_method" value="PUT">
    <?php foreach($users as $user): 
            $lvls_id = $user->getAssignedLevelsIds();
    ?>
            <div class="col-md-3">
                <div class="well">
                    <div class="form-group">
                        <label><?= Utils::secure(StaffContact::getShownName($user)); ?></label>
                        <?php foreach($levels as $level): 
                            $checked = in_array($level->id, $lvls_id) ? 'checked' : '';
                        ?>
                        <div class="checkbox">
                            <label>
                            <input name="<?= $level->id . '_' . $user->id ?>" type="checkbox" <?= $checked ?>><?= $level->label; ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
    <?php endforeach; ?>
    <div class="clearfix"></div>
    <div class="col-md-3">
        <div class="well">
            <button class="btn btn-primary">Valider</button>
        </div>
    </div>
    </form>
</div>