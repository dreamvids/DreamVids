<div class="modal fade" id="news_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Ajouter une news</h4>
      </div>
      <form id="news_form">
        <div class="modal-body">
          <div class="form-group">
            <label for="input-title" class="control-label">Titre : </label>
            <input name="title" type="text" class="form-control" id="input-title">
          </div>
          <div class="form-group">
            <label for="input-content" class="control-label">Contenu : </label>
            <textarea name="content" class="form-control" id="input-content"></textarea>
          </div>
          <hr>
        <div class="form-group">
            <label for="input-level" class="control-label">Niveau : </label>
            <select id="input-level" name="level" class="form-control">
                <?php $possible_levels = ['', 'primary', 'info', 'success', 'warning', 'danger'];
                    foreach($possible_levels as $level){
                        echo "<option value='$level'>".ucfirst($level)."</option>";
                    }
                ?>
            </select>
            </div>
            <div class="form-group">
            <label for="input-icon" class="control-label">Icône <small><a target="_blank" href="https://fortawesome.github.io/Font-Awesome/icons/">Depuis cette liste</a> et sans le préfix "fa-"</small></label>
            <input type="text" name="icon" class="form-control" id="input-icon">
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Valider</button>
      </div>
      </form>
    </div>
  </div>
</div>