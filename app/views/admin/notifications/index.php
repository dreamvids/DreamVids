<div class="row">
    <h1>Gestions des notifications</h1>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
               <i class="fa fa-gears"></i> Paramètres des notifications pushbullet
            </div>
            <div class="panel-body">
                <?php if($is_notif_enabled): ?>
                    <p>Vous recevez actuellement vos notification <span class="text-success">PushBullet</span> à l'adresse <?php echo $push_mail; ?></p>
                    <button class="btn btn-danger push-bullet-btn" data-value='0'><i class="fa fa-bell fa-fw"></i> Désactiver PushBullet</button>
                    <button class="btn btn-success push-bullet-btn-send"><i class="fa fa-paper-plane-o fa-fw"></i> Tester</button>
                <?php else: ?>
                    <p>Vous ne recevez actuellement <span class="label label-danger">aucune</span> notification <span class="text-success">PushBullet</span></p>
                    <button class="btn btn-primary push-bullet-btn" data-value='1'><i class="fa fa-bell fa-fw"></i> Activer PushBullet</button>
                <?php endif; ?>
            </div>
        </div>
        <?php include VIEW.'admin/notifications/send_notif.php'; ?>
    </div>
    <div class="col-md-6">
        <?php include VIEW.'admin/notifications/notifications.php'; ?>
    </div>
</div>