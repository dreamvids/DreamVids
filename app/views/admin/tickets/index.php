<div class="row">
	<h1>Traitement des tickets <small><?= $all ? "Tout les tickets" : "Tickets qui vous sont assignés" ?></small></h1>
	<?php include VIEW.'layouts/messages_bootstrap.php'; ?>
	<div class="col-lg-12">
		<?php if(!$all){ ?>
			<p>Les tickets <b>ne</b> vous concernant <b>pas</b> <b>ne</b> sont <b>pas</b> affichés ici. Cependant, vous pouvez <a href="<?= WEBROOT ?>admin/tickets/all">afficher la liste de tout les tickets</a>.</p>
		<?php } ?>
		<table class="table table-bordered table-hover table-striped table-to-sort">
			<thead>
				<tr>
					<th>#</th>
					<th>Ticket</th>
					<th>Date</th>
					<th>Utilisateur</th>
					<th>IP</th>
					<th>Niveau</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($tickets as $tick):
					
					if (User::exists(array('id' => $tick->user_id))):
						$user_id = User::find($tick->user_id)->username;
					else:
						if ($tick->user_id !== '0'):
							$user_id = $tick->user_id;
						else:
							$user_id = '[Anonyme]';
						endif;
					endif;

					if ((time() - $tick->timestamp) < (24 * 3600)):
						$style = '';
					elseif ((time() - $tick->timestamp) < (48 * 3600)):
						$style = 'background-color:#ffBB55';
					else:
						$style = 'background-color:#ff6666;color:white;';
					endif;
				 ?>
					<tr style="<?php echo $style; ?>">
						<td><?php echo $tick->id; ?></td>
						<td><?php echo $tick->description; ?></td>
						<td><?php echo date('d/m/Y H:i', $tick->timestamp); ?></td>
						<td><?php echo $user_id; ?></td>
						<td><?php echo $tick->ip; ?></td>
						<td><?php echo $tick->getLabel(); ?> <a class="btn-primary btn btn-xs" href="<?= WEBROOT; ?>admin/tickets/edit_level/<?php echo $tick->id; ?>">Changer</button></td>
						<td>
							<?php if(in_array($tick->ticket_levels_id, Session::get()->getAssignedLevelsIds())): ?>
							<button class="btn-success btn" onclick="if(confirm('Êtes-vous sur que le problème est résolu ? Un E-Mail sera envoyé à l\'utilisateur pour lui confirmer la résolution de son problème et ce ticket sera définitivement supprimé.')){document.location.href=_webroot_+'admin/tickets/solved/<?php echo $tick->id; ?>';}">Problème résolu</button>
							<?php if ($tick->tech == ''): ?>
								<button class="btn-warning btn" onclick="if(confirm('Êtes-vous sur d\'avoir le temps de vous occuper de ce ticket ? Une fois assigner, une conversation MP est créée entre vous et l\'utilisateur (s\'il existe). De plus, un ticket ne peut pas changer de technicien.')){document.location.href=_webroot_+'admin/tickets/inprogress/<?php echo $tick->id; ?>';}">Résolution en cours</button>
							<?php
							else:
								if ($tick->tech == Session::get()->username && is_numeric($tick->user_id) && $tick->user_id > 0):
							?>
								<button class="btn-info btn" onclick="document.location.href=_webroot_+'account/messages/<?php echo $tick->conv_id; ?>';">Conversation</button>
							<?php else: ?>
								<button class="btn-warning btn active" onclick="alert('Un membre de l\'équipe s\'occupe déjà de ce ticket.'); return false;">Résolution en cours (<?php echo $tick->tech; ?>)</button>
							<?php 
								endif;
							endif;
							?>
							<button class="btn-danger btn" onclick="if(confirm('Assurez-vous d\'avoir ajouter ce bug au Producteev avant de confirmer, car vous perdrez toute trace de ce ticket.')){document.location.href=_webroot_+'admin/tickets/bug/<?php echo $tick->id; ?>';}">Ceci est un bug</button>
							<?php endif; ?>							
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		
	</div>
</div>