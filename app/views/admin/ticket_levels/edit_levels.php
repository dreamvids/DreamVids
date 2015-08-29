<div class="row">
    <h1>Gestion des niveaux des tickets</h1>
	<?php include VIEW.'layouts/messages_bootstrap.php'; ?>
    <table class="table table-bordered table-hover table-striped table-to-sort">
			<thead>
				<tr>
                    <th>ID</th>
					<th>Niveau</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
    <?php foreach($levels as $level): ?>
            <tr>
        <form action="<?= WEBROOT ?>admin/ticketlevels/edit_levels" method="post">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="<?= $level->id; ?>">
                <td><?= $level->id; ?></td>
                <td><input class="form-control" name="label" value="<?= $level->label; ?>"></td>
                <td>
                    <button type="submit" class="btn btn-success">Valider</button>
                    <?php if(!$level->isUsed()): ?>
                    <a onclick="$.ajax(_webroot_+'admin/ticketlevels/<?= $level->id ?>',{method: 'delete', complete: function(){document.location.href = _webroot_+'admin/ticketlevels/edit_levels';}});" class="btn btn-danger">Supprimer</a>
                    <?php else: ?>
                    <a class="btn btn-default" disabled>Supprimer [utilisé]</a>
                    <?php endif; ?>
                </td>
        </form>
            </tr>
    <?php endforeach; ?>
            <tr>
        <form action="<?= WEBROOT ?>admin/ticketlevels" method="post">
            <input type="hidden" name="_method" value="POST">
                <td><b>Ajouter un niveau</b></td>
                <td><input class="form-control" name="label" value="" placeholder="Label"></td>
                <td>
                    <button type="submit" class="btn btn-success">Valider</a>
                </td>
        </form>
            </tr>
            </tbody>
    </table>
</div>