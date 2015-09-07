                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Notifications 
                            
                            <?php if(!isset($notif_page) || !$notif_page): ?>
                                <?php if($is_notif_enabled): ?>
                                <button class="btn btn-danger btn-xs push-bullet-btn" data-value='0'><i class="fa fa-bell fa-fw"></i> Desactiver PushBullet</button> <em><?php echo htmlspecialchars(Session::get()->details->push_bullet_email); ?></em>
                                <?php else: ?>
                                <button class=" btn btn-primary btn-xs push-bullet-btn" data-value='1'><i class="fa fa-bell fa-fw"></i> Activer PushBullet</button> <em><?php echo htmlspecialchars(Session::get()->details->push_bullet_email); ?></em>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php if(empty($notifs)): ?>
                                <p class="text-center">Aucune notification</p>
                            <?php endif; ?>
                            <div class="list-group">
                                <?php foreach ($notifs as $k => $notif): 
                                    if(!$notif->canSee(Session::get())){ continue; }
                                ?>    
                                <a href="#" class="list-group-item <?php echo $notif->getLevel(); ?>">
                                    <i class="fa fa-<?php echo $notif->getIcon(); ?> fa-fw"></i> <?php echo $notif->getContent(); ?>
                                    <span class="pull-right text-muted small"><em><?php echo Utils::relative_time($notif->timestamp); ?></em>
                                    </span>
                                </a>
                                <?php endforeach; ?>
                            </div>
                            <!-- /.list-group -->
                            <a href="#" class="btn btn-default btn-block">View All Alerts</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>