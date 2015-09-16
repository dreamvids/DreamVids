<div class="row">
    <h1>Gestion des partenaires</h1>
	<?php include VIEW.'layouts/messages_bootstrap.php'; ?>
    <table class="table table-bordered table-hover table-striped table-to-sort">
			<thead>
				<tr>
                    <th>ID</th>
					<th>Nom</th>
					<th>Url</th>
					<th>E-mail</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
    <?php foreach($partners as $partner): ?>
            <tr>
        <form action="<?= WEBROOT ?>admin/partners/<?php echo $partner->id; ?>" method="post">
            <input type="hidden" name="_method" value="PUT">
                <td><?= $partner->id; ?></td>
                <td><input class="form-control" name="name" value="<?= $partner->name; ?>" placeholder="Nom"></td>
                <td><input class="form-control" name="url" value="<?= $partner->url; ?>" placeholder="URL"></td>
                <td><input class="form-control" name="contact_email" value="<?= $partner->contact_email; ?>" placeholder="Email de contact"></td>
                <td>
                    <button type="submit" class="btn btn-success">Valider</button>
                    <a onclick="if(confirm('Supprimer le partenraire ?')){$.ajax(_webroot_+'admin/partners/<?= $partner->id ?>',{method: 'delete', complete: function(){document.location.href = _webroot_+'admin/partners';}});}" class="btn btn-danger">Supprimer</a>
                </td>
        </form>
            </tr>
    <?php endforeach; ?>
            <tr>
        <form action="<?= WEBROOT ?>admin/partners" method="post">
            <input type="hidden" name="_method" value="POST">
                <td><b>Nouveau </b></td>
                <td><input class="form-control" name="name" value="<?php echo isset($params['name']) ? $params['name'] : ''; ?>" placeholder="Nom"></td>
                <td><input class="form-control" name="url" value="<?php echo isset($params['url']) ? $params['url'] : ''; ?>" placeholder="URL"></td>
                <td><input class="form-control" name="contact_email" value="<?php echo isset($params['contact_email']) ? $params['contact_email'] : ''; ?>" placeholder="Email de contact"></td>
                <td>
                    <button type="submit" class="btn btn-success">Valider</a>
                </td>
        </form>
            </tr>
            </tbody>
    </table>
</div>