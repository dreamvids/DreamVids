<div class="row">
	<h1>Modération des commentaires</h1>

	<div class="col-lg-12">
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>Auteur</th>
					<th>Contenu</th>
					<th>Video</th>
					<th>+</th>
					<th>-</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($comments as $com): ?>
					<?php 
						$author = $com->getAuthor() ? $com->getAuthor() : '[inconnu]';
						$video = $com->getVideo() ? $com->getVideo() : '[inconnu]';
					?>
					<tr>
						<td><a href="<?php echo WEBROOT.'channel/'.$author->id; ?>"><?php echo $author->name; ?></a></td>
						<td><?php echo $com->comment; ?></td>
						<td><a href="<?php echo WEBROOT.'watch/'.$video->id; ?>"><?php echo $video->title; ?></a></td>
						<td><?php echo $com->likes; ?></td>
						<td><?php echo $com->dislikes; ?></td>
						<td>
							<button class="btn-success btn" onclick="unflagComment('<?php echo $com->id; ?>')">Annuler le flag</button>
							<button class="btn-danger btn" onclick="eraseComment('<?php echo $com->id; ?>')">Supprimer</button>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		
	</div>
</div>