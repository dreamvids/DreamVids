<div class="content">
	<h1 class="title">Panel <?php echo $rankStr; ?> - Videos reportés/suspendues</h1>

	<div class="reports">
		<table class="pure-table">
			<thead>
				<tr>
					<th>Titre</th>
					<th>Auteur</th>
					<th>Vues</th>
					<th>+</th>
					<th>-</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($reportedVids as $vid): ?>
					<tr>
						<td><a href="<?php echo WEBROOT.'watch/'.$vid->id; ?>"><?php echo $vid->title; ?></a></td>
						<td><?php echo UserChannel::find($vid->poster_id)->name; ?></td>
						<td><?php echo $vid->views; ?></td>
						<td><?php echo $vid->likes; ?></td>
						<td><?php echo $vid->dislikes; ?></td>
						<td>
							<?php if($vid->isSuspended()) { ?>
								<button class="button-success pure-button" onclick="unSuspendVideo('<?php echo $vid->id ?>')">Annuler la suspension</button>	
							<?php } else { ?>
								<button class="button-success pure-button" onclick="unFlagVideo('<?php echo $vid->id ?>')">Annuler le flag</button>
								<button class="button-warning pure-button" onclick="suspendVideo('<?php echo $vid->id ?>')">Suspendre</button>
							<?php } ?>
						
							<?php if($isAdmin): ?>
								<button class="button-error pure-button" onclick="eraseVideo('<?php echo $vid->id ?>')">Supprimer</button>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		
	</div>
</div>