        <div class="panel panel-default">
            <div class="panel-heading">Push :</div>
            <div class="panel-body">
                <div class="msg-container"></div>
                <p>Vous pouvez envoyer une notification à un staff. <strong>Ne pas abuser</strong>:<br>
                <form id="send-private-notif">
                  <div class="form-group">
                      <select id="send-private-notif-to" class="form-control">
                          <option selected>Selectionnez</option>
                          <option value="send_to_all">Tout le monde</option>
                          <?php foreach($team as $user): ?>
                              <option value="<?php echo $user->id; ?>"><?php echo htmlspecialchars(StaffContact::getShownName($user)); ?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <option value= "" selected>Selectionnez</option>
                      <select id="send-private-notif-level" name="level" class="form-control">
                        <?php $possible_levels = ['', 'primary', 'info', 'success', 'warning', 'danger'];
                            foreach($possible_levels as $level){
                                echo "<option value='$level'>".ucfirst($level)."</option>";
                            }
                        ?>
                    </select>
                  </div>
                  <div class="form-group">
                        <label>Forcer la notification push
                            <input type="checkbox" <?php echo !Session::get()->isAdmin() ? 'disabled': ''; ?> id="send-private-notif-force-push"/>
                        </label>
                  </div>
                  <div class="form-group">
                      <textarea class="form-control" id="send-private-notif-content" placeholder="Contenu de la notification"></textarea>
                      <br><button id="send-private-notif-btn" class="btn btn-success" type="submit"><i class="fa fa-paper-plane-o"></i> Envoyer</button>
                  </div>  
                </form>
                </p>
                
            </div>
        </div> 
