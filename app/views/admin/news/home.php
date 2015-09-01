<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> News <a href="<?php echo WEBROOT; ?>admin/news/add" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Ajouter une news</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="timeline">
                                <?php foreach($news as $k => $new): ?>
                                
                                <li <?php echo ($k%2 != 0) ? 'class="timeline-inverted"' : ''; ?>>
                                    
                                    <?php echo $new->getBadge(); ?>

                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><?php echo $new->title; ?></h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> <?php echo Utils::relative_time($new->timestamp) . " par " . Utils::secure(StaffContact::getShownName($new->user)); ?></small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $new->content; ?></p>
                                            <?php if($new->belongsToUser(Session::get())): ?>
                                            <hr>
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-gear"></i> Editer
                                                </a>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                                
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                    </div>