<div class="row">
		<h1 class="title">Ajouter une question/réponse</h1>
		<?php include VIEW.'layouts/messages_bootstrap.php'; ?>
	<div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8">
		<form method="post" action="<?php echo WEBROOT."admin/faq"; ?>" enctype="multipart/form-data" autocomplete="off">
			<input type="hidden" name="_method" value="post" />

			<label for="ask">Question :</label>
			<input class="form-control" type="text" name="ask" autocomplete = "off"><br />

			<label for="answer">Réponse :</label>
			<input class="form-control" type="text" name="answer" autocomplete = "off"><br />
			
			<label for="showed">Publier : </label>
			<input type="checkbox" name="showed" value="1">
			<br>
			<input class="btn btn-success" type="submit" value="<?php echo Translator::get("common.button.save"); ?>">
		</form>
	</div>
</div>