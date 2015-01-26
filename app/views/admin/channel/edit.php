<div class="row">
		<h1 class="title">Modifier la chaîne<small> <?php echo $channel->name; ?></small></h1>
		<?php include VIEW.'layouts/messages_bootstrap.php'; ?>

		<?php if(isset($channel)){ ?>
	<div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8">

			<a href="<?php echo WEBROOT.'admin/user/edit/' . $channel_admin->id ?>">Editer l'administrateur de la chaîne</a>

		<form method="post" action="<?php echo WEBROOT."admin/channel/$channel->id"; ?>" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="put" />

			<label for="username">Nom :</label>
			<input class="form-control" value="<?php echo $channel->name; ?>" type="text" name="_name" disabled placeholder="Nom"><br />

			<label for="description">Description :</label>
			<textarea class="form-control" value="" type="text" name="description" placeholder="Description"><?php echo $channel->description; ?></textarea><br />
			<label>Chaîne en status vérifiée ? :
			<div class="btn-group" data-toggle="buttons">
			  <label class="btn btn-success">
			    <input type="radio" name="verified" value="1" id="option1" autocomplete="off" <?php echo $channel->verified ? 'checked' : ''; ?> > Oui
			  </label>
			  <label class="btn btn-danger active">
			    <input type="radio" name="verified" value="0" id="option2" autocomplete="off" <?php echo !$channel->verified ? 'checked' : ''; ?> > Non
			  </label>
			</div>
			</label>
			<br>

			<input class="btn btn-success" type="submit" name="userSubmit" value="<?php echo Translator::get("common.button.save"); ?>">
		</form>
	</div>
	<?php } ?>
</div>