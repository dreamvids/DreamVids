<div class="row">
		<h1 class="title">Ajouter une question/réponse</h1>
		<?php include VIEW.'layouts/messages_bootstrap.php'; ?>
	<div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8">
		<form method="post" action="<?php echo WEBROOT."admin/faq/$faq->id"; ?>" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="put" />

			<label for="ask">Question :</label>
			<input class="form-control" value="<?php echo $faq->ask; ?>" type="text" name="ask"><br />

			<label for="answer">Réponse :</label>
			<input class="form-control" value="<?php echo $faq->answer; ?>" type="text" name="answer"><br />
			
			<label for="showed">Publier : </label>
			<input type="checkbox" name="showed" value="<?php echo $faq->showed ? 0 : 1 ?>" <?php echo $faq->showed ? 'checked' : ''?>>
			<br>
			<input class="btn btn-success" type="submit" value="<?php echo Translator::get("common.button.save"); ?>">
		</form>
	</div>
</div>