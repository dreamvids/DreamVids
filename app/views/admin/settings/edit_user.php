<div class="row">
		<h1 class="title">Modifier le rang <small> <?php echo isset($user) ? $user->username : '';?></small></h1>
		<?php include VIEW.'layouts/messages_bootstrap.php'; ?>

		<?php if(isset($user)){ ?>
	<div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8">


		<form method="post" action="<?php echo WEBROOT."admin/settings/$user->id"; ?>">
			<input type="hidden" name="_method" value="put" />

			<label for="username">Pseudo :</label>
			<input class="form-control" value="<?php echo $user->username; ?>" disabled="disabled" type="text" placeholder="Pseudo"><br />

			<div class="btn-group" data-toggle="buttons">
			
<?php foreach ($ranks as $r_index => $name) { ?>
			<label class="btn btn-<?php echo $name[1]; ?><?php echo $user->rank == $r_index ? ' active' : ''?>">
			    <input type="radio" name="rank" value="<?php echo $r_index; ?>" id="option1" autocomplete="off" <?php echo $user->rank == $r_index ? ' checked' : ''?>> <?php echo $name[0]; ?>
			  </label>
<?php }?>
			</div>
			<br>
			
			<input class="btn btn-success" type="submit" name="userRankSubmit" value="<?php echo Translator::get("common.button.save"); ?>">
		</form>
	</div>
	<?php } ?>
</div>