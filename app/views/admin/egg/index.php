<div class="row">
	<h1>Gestion de l'event "Chasse aux oeufs"</h1>
	<?php include VIEW.'layouts/messages_bootstrap.php'; ?>
	<h2>Liste des oeufs : </h2>
<?php foreach(['Dreamvids' => $dv_eggs, 'CAVIcon' => $cavi_eggs] as $key => $eggs): ?>		
	<div class="col-lg-12">
		<h3><?php echo $key; ?> <a class="btn btn-xs btn-primary" href="<?php echo WEBROOT . 'admin/egg/add/' . strtolower($key); ?>">Ajouter un oeuf</a></h3>
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>id</th>
					<?php if($key == 'Dreamvids'){?><th>Page d'apparition</th><?php }?>
					<th>Points</th>
					<th>Moment d'apparition</th>
					<th>Etat</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($eggs as $k => $egg): 
					$color_class = $egg->show_timestamp > Utils::tps() ? 'warning' : ($egg->found ? 'success' : 'info');
					$state = $egg->show_timestamp > Utils::tps() ? 'Pas encore apparu' : ($egg->found ? 'Trouvé' : 'Caché');
				?>
					
				
					<tr class="<?php echo $color_class; ?>">
						<td><?php echo $egg->id; ?></td>
						<?php if($key == 'Dreamvids'){?><td><?php echo '/'.$egg->emplacement; ?></td><?php }?>
						<td><?php echo $egg->points ?></td>
						<td><?php echo date('d/m/Y à H:i:s', $egg->show_timestamp); ?></td>
						<td><span class="label label-<?php echo $color_class?>"><?php echo $state ?></span></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		
	</div>
<?php endforeach; ?>
</div>