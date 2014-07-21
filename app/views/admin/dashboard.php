<div class="content wide">
	<h1 class="title">Panel <?php echo $rankStr; ?> - Tableau de bord</h1>

	<div class="reports">
		<h3 class="title">Videos reportés</h3>

		<table>
			<thead>
				<tr>
					<th>Titre</th>
					<th>Auteur</th>
					<th>Vues</th>
					<th>+</th>
					<th>-</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($reportedVids as $vid): ?>
					<tr>
						<td><?php echo $vid->title; ?></td>
						<td><?php echo UserChannel::find($vid->poster_id)->name; ?></td>
						<td><?php echo $vid->views; ?></td>
						<td><?php echo $vid->likes; ?></td>
						<td><?php echo $vid->dislikes; ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>