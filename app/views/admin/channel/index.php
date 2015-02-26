<div class="row">
	<h1>Gestion des chaînes </h1>

	<div class="col-lg-12">
		<table class="table table-bordered table-hover table-striped table-to-sort">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Créateur</th>
					<th>Administrateurs</th>
					<th>Vues</th>
					<th>Abonnés</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($channels as $chan): ?>
					<tr>
						<td><a href="<?php echo WEBROOT.'channel/'.$chan->id; ?>"><?php echo $chan->name; ?></a></td>
						<td><?php echo User::find($chan->owner_id)->username; ?></td>
						<td><?php echo $chan->getAdminsNames(); ?>
							<?php if(User::find($chan->owner_id)->getMainChannel()->id == $chan->id){ echo '<span class="label label-danger">Chaîne principale</span>'; }?>
							<?php if($chan->verified){ echo '<span class="label label-success">Chaîne vérifiée</span>'; }?>
						</td>
						<td><?php echo $chan->views; ?></td>
						<td><?php echo $chan->subscribers; ?></td>
						<td><button class="btn-primary btn" onclick="alert('Pas encore implémenté')">Envoyer un message</button>
							<a href="<?php echo WEBROOT.'admin/channel/edit/'.$chan->id; ?>" class="btn-warning btn">Editer</button>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		
	</div>
</div>