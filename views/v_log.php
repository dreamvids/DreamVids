<!--<form action="" method="post">
	<input type="text" name="username" required="" placeholder="<?php echo $lang['username']; ?>" value="<?php echo @$_POST['username']; ?>" />
	<br /><br />
	<input type="password" name="pass" required="" placeholder="<?php echo $lang['password']; ?>" vaue="<?php echo @$_POST['pass']; ?>" />
	<br /><br />
	<input type="checkbox" value="remember" id="remember" name="remember" /> <label for="remember"><?php echo $lang['remember']; ?></label>
	<br /><br />
	<input type="submit" name="submit" value="<?php echo $lang['login']; ?>" />
</form>-->

<div class="container">

	<div class="container">
		<div class='border-top'></div>
			<h1><?php echo $lang['login']; ?></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class="container" style="width: 40%; float: left;">
		<?php echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : ''; ?>
		<form role="form" method='post' action=''>
			<div class="form-group">
				<label for="username"><?php echo $lang['username']; ?></label>
				<input type="text" name="username" required="" placeholder="<?php echo $lang['username']; ?>" value="<?php echo @$_POST['username']; ?>" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="pass"><?php echo $lang['password']; ?></label>
				<input type="password" name="pass" required="" placeholder="<?php echo $lang['password']; ?>" vaue="<?php echo @$_POST['pass']; ?>" class="form-control"/>
			</div>
			<div class="checkbox">
				<label>
				<input type="checkbox" value="remember" id="remember" name="remember" /> <label for="remember"><?php echo $lang['remember']; ?></label>
				</label>
			</div>
			<input type="submit" name="submit" value="<?php echo $lang['login']; ?>" class="btn btn-primary" />
		</form>
	</diV>
</div>
