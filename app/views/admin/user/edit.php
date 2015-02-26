<div class="row">
		<h1 class="title">Modifier l'utilisateur<small> <?php echo isset($user) ? $user->username . ' <a class="btn btn-primary" href="'.WEBROOT . 'admin/settings/users/'.$user->id.'">Changer le rang</a>' : '';?></small></h1>
		<?php include VIEW.'layouts/messages_bootstrap.php'; ?>

		<?php if(isset($user)){ ?>
	<div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8">


		<form method="post" action="<?php echo WEBROOT."admin/user/$user->id"; ?>" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="put" />

			<label for="username">Pseudo :</label>
			<input class="form-control" value="<?php echo $user->username; ?>" type="text" name="username" placeholder="Pseudo"><br />

			<label for="email">Adresse email :</label>
			<input class="form-control" value="<?php echo $user->email; ?>" type="text" name="email" placeholder="Adresse email"><br />
			
			<label for="pass">Nouveau mot de passe :</label>
			<input class="form-control" type="password" name="pass"><br />
			
			
			
			<input class="btn btn-success" type="submit" name="userSubmit" value="<?php echo Translator::get("common.button.save"); ?>">
		</form>
	</div>
	<?php } ?>
</div>