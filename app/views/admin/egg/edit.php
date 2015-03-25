<div class="row">
	<h1>Edition de l'oeuf : <?php echo $egg->id; ?> - <small><a href="<?php echo WEBROOT . 'admin/egg' ?>">Retour</a></small></h1>
	<?php include VIEW.'layouts/messages_bootstrap.php'; ?>
	
	<div class="col-md-offset-2 col-md-8">
		<form method="post" action="<?php echo WEBROOT . 'admin/egg/' . $egg->id; ?>">
		
		<input type="hidden" name="_method" value="put">
		
		<div class="form-group">
		
		<label>Jour :
			<input min="1" max="31" name="day" class="form-control" type="number" value="<?php echo date("d", $egg->show_timestamp); ?>">
		</label>
		/
		<label>Mois :
			<input min="1" max="12" name="month" class="form-control" type="number" value="<?php echo date("m", $egg->show_timestamp); ?>">
		</label>
		/
		<label>Année :
			<input min="2015" max="2115" name="year" class="form-control" type="number" value="<?php echo date("Y", $egg->show_timestamp); ?>">
		</label>	
		à
		<label>Heure :
			<input name="hour" min="0" max="24" class="form-control" type="number" value="<?php echo date("H", $egg->show_timestamp); ?>"> 
		</label>
		:
		<label>Minute :
			<input name="minute" min="0" max="59" class="form-control" type="number" value="<?php echo date("i", $egg->show_timestamp); ?>">
		</label>	
		</div>		

		<div class="form-group">
		<label>Type d'oeufs :
			<select name="points" class="form-control">
				<option value="1" <?php echo $egg->points == 1 ? 'selected="selected"':''; ?>>Normal (1 pts)</option>
				<option value="3" <?php echo $egg->points == 3 ? 'selected="selected"':''; ?>>Doré (3 pts)</option>
			</select>
		</label>
		</div>
		
		<div class="form-group">
		<label>Emplacement : (l'emplacement est la partie de l'url apres dreamvids.fr/ , il NE faut donc PAS mettre de / au début)<br>
			Laisser vide pour la cavicon
			<input name="emplacement" class="form-control" value="<?php echo $egg->emplacement; ?>">
		</label>
		
		</div>
			<button class="btn btn-primary" type="submit">Valider</button>
		
		</form>
	</div>
	
</div>
