<div class="content">

	<section class="">
		<h1 class="title">Chaînes</h1>
		
		<?php
			include VIEW.'layouts/accountMenu.php';
			include VIEW.'layouts/messages.php';
		?>

		<span class="buttons">
		    <a href="<?php echo WEBROOT.'channels/add'; ?>">
			    <button class="btn btn-primary">
			        Ajouter une chaîne
			    </button>
			</a>
    	</span>
    	
    	<table>
    		<thead>
    			<tr><th>Nom</th><th>Abonnés</th><th>Vues</th><th>Modifier</th><th>Supprimer</th></tr>
    	<?php
    		foreach ($channels as $chan) {
				?>
				
				<tr>
					<td>
						<a href="<?php echo WEBROOT.'channel/'.$chan->id; ?>"><?php echo $chan->name; ?></a>
					</td>
					<td><?php echo $chan->subscribers; ?></td>
					<td><?php echo $chan->views; ?></td>
					<td>
						<a href="<?php echo WEBROOT.'channels/edit/'.$chan->id ?>"><button>Modifier</button></a>
					</td>
					<td>
						<input type="button" value="Supprimer" />
					</td>
				</tr>

				<?php
    		}
    	?>
    	</table>
	</section>

</div>