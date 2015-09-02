<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> News 
                            <button type="button" data-method="POST" data-toggle="modal"  data-target="#news_modal" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Ajouter une news</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php if(empty($news)): ?>
                                <h4 class="text-center"> Pas de news pour l'instant.</h4>
                            <?php endif; ?>
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
                                            <div id="modal_<?php echo $new->id; ?>"></div>
                                            <hr>
                                            <div class="btn-group">
                                                <button type="button" data-method="PUT" data-toggle="modal"  data-target="#news_modal" 
                                                    data-title="<?php echo $new->title; ?>"
                                                    data-content="<?php echo $new->content; ?>"
                                                    data-level="<?php echo $new->level; ?>"
                                                    data-icon="<?php echo $new->icon; ?>"
                                                    data-id="<?php echo $new->id; ?>"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fa fa-gear"></i> Editer
                                                </button>
                                                <button type="button" onclick="deleteNew(this)" data-id="<?php echo $new->id;?>" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Supprimer
                                                </button>
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
                    
<?php include VIEW.'layouts/dialogs/news_dialog.php'; ?>
