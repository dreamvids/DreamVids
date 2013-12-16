<?php
echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : '';
echo (!isset($err) && isset($_POST['submit']) ) ? '<div class="alert alert-success">'.$lang['reg_ok'].'</div>' : '';
?>
<form action="" method="post">
	<input type="email" required="" placeholder="<?php echo $lang['email_address']; ?>" name="email" value="<?php echo @$_POST['email']; ?>" />
	<br /><br />
	<input type="text" required="" placeholder="<?php echo $lang['username']; ?>" name="username" value="<?php echo @$_POST['username']; ?>" />
	<br /><br />
	<input type="password" required="" placeholder="<?php echo $lang['password']; ?>" name="pass1" value="<?php echo @$_POST['pass1']; ?>" />
	<br /><br />
	<input type="password" required="" placeholder="<?php echo $lang['password_confirm']; ?>" name="pass2" value="<?php echo @$_POST['pass2']; ?>" />
	<br /><br />
	<input type="submit" name="submit" value="<?php echo $lang['register']; ?>" />
</form>