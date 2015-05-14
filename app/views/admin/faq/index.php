<div class="row">
	<h1>Faq <a class="btn btn-primary" href="<?php echo  WEBROOT . "admin/faq/add"?>">Ajouter une question/réponse</a></h1>
	<?php include VIEW.'layouts/messages_bootstrap.php'; ?>
	<div class="col-lg-12">
		<table class="table table-bordered table-hover table-striped table-to-sort">
			<thead>
				<tr>
					<th>Questions</th>
					<th>Réponses</th>
					<th>Affichée</th>
					<th>Date de création</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($faqs as $faq): $showed = $faq->showed; ?>
					<tr>
						<td><?php echo $faq->ask; ?></td>
						<td><?php echo $faq->answer; ?></td>
						<td><?php echo ($showed ? "<span class=\"label label-success\">Affichée" : "<span class=\"label label-danger\">En cours d'édition") . '</span>'; ?></td>
						<td><?php echo date('d/m/Y à H:i', $faq->timestamp); ?></td>
						<td>
							<?php 
								$js_publish = "if(confirm('".($showed ? 'Cacher' : 'Publier')." cette question réponse ?')){ $.ajax({type:'put', data:{showed:". (!$showed ? '1':'0') ."}, url:_webroot_ + 'admin/faq/$faq->id'}).then(function(r){location.reload();});}";
								$color = !$showed ? 'success' : 'danger';
								$text = !$showed ? 'Rendre public' : 'Rendre privé';
								echo "<a onclick=\"$js_publish\" class=\"btn btn-$color\" href=\"#\">$text</a>"; 
								
								$js_delete = "if(confirm('Supprimer ?')){ $.ajax({type:'delete', url:_webroot_ + 'admin/faq/$faq->id'}).then(function(r){location.reload();});}";
								?>
							<a class="btn btn-warning" href="<?php echo WEBROOT . 'admin/faq/edit/' . $faq->id; ?>"> <i class="fa fa-pencil-square-o"></i> </a>
							<a class="btn btn-danger" onclick="<?php echo $js_delete; ?>" href="#"> <i class="fa fa-trash-o"></i> </a>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

		
	</div>
</div>