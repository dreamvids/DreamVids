<div class="row">
    <h1>Modification du niveau du ticket</h1>
    <?php include VIEW.'layouts/messages_bootstrap.php'; ?>
    <div class="col-md-4">
        <p>Choisir un niveau existant</p>
        <form method="post" class="well" action="<?= WEBROOT ?>admin/tickets/<?= $ticket->id; ?>">
            <input name="_method" value="PUT" type="hidden">
            <select name="level_id" class="form-control">
                <option></option>
                <?php foreach($levels as $lvl): ?>
              <option value="<?= $lvl->id ?>" <?= $ticket->ticket_levels_id == $lvl->id ? 'selected':'' ?>><?= $lvl->label; ?> (<?= $lvl->countUser() ?> staffs)</option>
              <?php endforeach; ?>
            </select><br>
            <button class="btn btn-success" type="submit">Valider</button>
        </form>
    </div>
    
    <div class="col-md-4">
        <p>Ou creer un nouveau niveau</p>
        <form method="post" class="well" action="<?= WEBROOT ?>admin/tickets/<?= $ticket->id; ?>">
            <input name="_method" value="PUT" type="hidden">
            <input name="new" value="1" type="hidden">
            <input class="form-control" name="label" value="" placeholder="Label"><br>
            <button class="btn btn-success" type="submit">Valider</button>
        </form>
    </div>
</div>