<div class="row">
	<h1>Gestion des chaînes </h1>

	<div class="col-lg-12">
		<table class="table table-bordered table-hover table-striped table-to-sort">
			<thead>
				<tr>
					<th>Ticket</th>
					<th>URL</th>
					<th>Utilisateur</th>
					<th>IP</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($tickets as $tick): ?>
					<tr>
						<td><?php echo $tick->description; ?></td>
						<td><?php echo $tick->url; ?></td>
						<td><?php echo $tick->username; ?></td>
						<td><?php echo $tick->ip; ?></td>
						<td>
							<button class="btn-success btn" onclick="alert('Pas encore implémenté')">Problème résolu</button>
							<button class="btn-warning btn" onclick="alert('Pas encore implémenté')">Résolution en cours</button>
							<button class="btn-danger btn" onclick="alert('Pas encore implémenté')">Ceci est un bug</button>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		
	</div>
</div>