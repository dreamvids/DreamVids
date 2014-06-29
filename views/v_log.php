<div class="container">

	<div class="container">
		<h1 class="title"><?php echo $lang['login']; ?></h1>
	</div>

	<div class="container" style="width: 40%; float: left;">
		<?php echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : ''; ?>
		<form role="form" method='post' action=''>
			<div class="form-group">
				<label for="username"><?php echo $lang['username']; ?></label>
				<input type="text" name="username" required="" placeholder="<?php echo $lang['username']; ?>" value="<?php echo @secure($_POST['username']); ?>" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="pass"><?php echo $lang['password']; ?></label>
				<input type="password" name="pass" required="" placeholder="<?php echo $lang['password']; ?>" vaue="<?php echo @secure($_POST['pass']); ?>" class="form-control"/>
			</div>
			<input type="submit" name="submit" value="<?php echo $lang['login']; ?>" class="btn btn-primary" />
		</form>
	</diV>
</div>
