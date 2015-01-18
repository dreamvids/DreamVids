<div class="row">
	<h1>Gestion des chaînes </h1>

	<div class="col-lg-12">
		<table class="table table-bordered table-hover table-striped table-to-sort">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<td><a href="<?php echo WEBROOT.'channel/'.$user->getMainChannel()->id; ?>"><?php echo $user->username; ?></a></td>
						<td><button class="btn-warning btn" onclick="alert('Pas encore implémenté')">Editer</button></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		
	</div>
</div>