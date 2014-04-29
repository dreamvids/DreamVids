<div class="content">

	<section class="">
		<h1 class="title">Chaînes</h1>
		
		<?php
			include VIEW.'layouts/accountMenu.php';
			include VIEW.'layouts/messages.php';
		?>

		<span class="buttons">
		    <a href="<?php echo WEBROOT.'channels/add'; ?>">
			    <button>
			        Ajouter une chaîne
			    </button>
			</a>
    	</span>
    	
    	<table>
    		<thead>
    			<tr><th>Nom</th><th>Abonnés</th><th>Vues</th><th>Modifier</th><th>Supprimer</th></tr>
    	<?php
    		foreach ($channels as $chan) {
    			echo '<tr><td><a href="'.WEBROOT.'channel/'.$chan->id.'">'.$chan->name.'</a></td><td>'.$chan->subscribers.'</td><td>'.$chan->views.'</td><td><input type="button" value="Modifier" /></td><td><input type="button" value="Supprimer" /></td></tr>';
    		}
    	?>
    	</table>
	</section>

</div>