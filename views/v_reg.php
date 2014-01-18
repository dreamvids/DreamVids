<!--<form action="" method="post">
	<input type="email" required="" placeholder="<?php echo $lang['email_address']; ?>" name="email" value="<?php echo @$_POST['email']; ?>" />
	<br /><br />
	<input type="text" required="" placeholder="<?php echo $lang['username']; ?>" name="username" value="<?php echo @$_POST['username']; ?>" />
	<br /><br />
	<input type="password" required="" placeholder="<?php echo $lang['password']; ?>" name="pass1" value="<?php echo @$_POST['pass1']; ?>" />
	<br /><br />
	<input type="password" required="" placeholder="<?php echo $lang['password_confirm']; ?>" name="pass2" value="<?php echo @$_POST['pass2']; ?>" />
	<br /><br />
	<input type="submit" name="submit" value="<?php echo $lang['register']; ?>" />
</form>-->

<div class="container">
	<div class="container">
		<div class='border-top'></div>
			<h1><?php echo $lang['reg']; ?></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class="container" style="width: 40%; float: left;">
		<?php
		echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : '';
		echo (!isset($err) && isset($_POST['submit']) ) ? '<div class="alert alert-success">'.$lang['reg_ok'].'</div>' : '';
		?>
		
		<form role="form" action="" method="post">
			<div class="form-group">
				<label for="email"><?php echo $lang['email_address']; ?></label>
				<input type="email" required="" placeholder="<?php echo $lang['email_address']; ?>" name="email" value="<?php echo @$_POST['email']; ?>" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="username"><?php echo $lang['username']; ?></label>
				<input type="text" required="" placeholder="<?php echo $lang['username']; ?>" name="username" value="<?php echo @$_POST['username']; ?>" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="pass1"><?php echo $lang['password']; ?></label>
				<input type="password" required="" placeholder="<?php echo $lang['password']; ?>" name="pass1" value="<?php echo @$_POST['pass1']; ?>" class="form-control" />
			</div>
			<div class="form-group">
				<label for="pass2"><?php echo $lang['password_confirm']; ?></label>
				<input type="password" required="" placeholder="<?php echo $lang['password_confirm']; ?>" name="pass2" value="<?php echo @$_POST['pass2']; ?>" class="form-control" />
			</div>
			<input type="submit" name="submit" value="<?php echo $lang['register']; ?>" class="btn btn-primary" />
		</form>
	</diV>
</div>
