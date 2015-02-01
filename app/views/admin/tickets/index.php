<div class="row">
	<h1>Traitement des tickets</h1>

	<div class="col-lg-12">
		<table class="table table-bordered table-hover table-striped table-to-sort">
			<thead>
				<tr>
					<th>#</th>
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
						<td><?php echo $tick->id; ?></td>
						<td><?php echo $tick->description; ?></td>
						<td><?php echo $tick->url; ?></td>
						<td><?php echo (User::exists(array('id' => $tick->user_id))) ? User::find($tick->user_id)->username : '[Anonyme]'; ?></td>
						<td><?php echo $tick->ip; ?></td>
						<td>
							<div class="btn-group">
								<button class="btn-success btn" onclick="if(confirm('Êtes-vous sur que le problème est résolu ? Un E-Mail sera envoyé à l\'utilisateur pour lui confirmer la résolution de son problème et ce ticket sera définitivement supprimé.')){document.location.href=_webroot_+'admin/tickets/solved/<?php echo $tick->id; ?>';}">Problème résolu</button>
								<?php if ($tick->tech != ''): ?>
									<button class="btn-warning btn active" onclick="alert('Un membre de l\'équipe s\'occupe déjà de ce ticket.'); return false;">Résolution en cours (<?php echo $tick->tech; ?>)</button>
								<?php else: ?>
									<button class="btn-warning btn" onclick="if(confirm('Êtes-vous sur d\'avoir le temps de vous occuper de ce ticket ? Une fois assigner, un ticket ne peut changer de technicien.')){document.location.href=_webroot_+'admin/tickets/inprogress/<?php echo $tick->id; ?>';}">Résolution en cours</button>
								<?php endif ?>
								<button class="btn-danger btn" onclick="if(confirm('Assurez-vous d\'avoir ajouter ce bug au Producteev avant de confirmer, car vous perdrez toute trace de ce ticket.')){document.location.href=_webroot_+'admin/tickets/bug/<?php echo $tick->id; ?>';}">Ceci est un bug</button>
							</div>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		
	</div>
</div>