<div class="row">
	<h1>Ajout d'oeuf pour le site : <?php echo $readable_site; ?> - <small><a href="<?php echo WEBROOT . 'admin/egg' ?>">Retour</a></small></h1>
	
	<div class="col-md-offset-2 col-md-8">
		<form method="post" action="<?php echo WEBROOT . 'admin/egg'; ?>">
		<input type="hidden" name="site" value="<?php echo $site; ?>">
		<div class="form-group">
		
		<label>Jour :
			<select name="day" class="form-control">
				<?php foreach (range(1, 31) as $d): echo "<option value=\"$d\">$d</option>"; endforeach; ?>
			</select>
		</label>
		
		<label>Mois :
			<select name="month" class="form-control">
				<?php foreach (range(1, 12) as $m): 
				$months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
				echo "<option value=\"$m\">{$months[$m-1]}</option>"; endforeach; ?>
			</select>
		</label>

		<label>Année :
			<select name="year" class="form-control">
			 	<?php foreach (range(2015, 2115) as $y): echo "<option value=\"$y\">$y</option>"; endforeach; ?>
			</select>
		</label>	
		à
		<label>Heure :
			<input name="hour" min="0" max="24" value="0" class="form-control" type="number"> 
		</label>
		:
		<label>Minute :
			<input name="minute" min="0" max="59" value="0" class="form-control" type="number">
		</label>	
		</div>		

		<div class="form-group">
		<label>Type d'oeufs :
			<select name="points" class="form-control">
				<option value="1" selected="selected">Normal (1 pts)</option>
				<option value="3" >Doré (3 pts)</option>
			</select>
		</label>
		</div>
		
		<div class="form-group">
		<label>Emplacement : (l'emplacement est la partie de l'url apres dreamvids.fr/ , il NE faut donc PAS mettre de / au début)<br>
			Laisser vide pour la cavicon
			<input name="emplacement" class="form-control">
		</label>
		
		</div>
			<button class="btn btn-primary" type="submit">Valider</button>
		
		</form>
	</div>
	
</div>
