<?php
require '_top.php';

echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : '';
?>
<form action="" method="post">
	<input type="text" name="username" placeholder="<?php echo $lang['username']; ?>" value="<?php echo @$_POST['username']; ?>" />
	<br /><br />
	<input type="password" name="pass" placeholder="<?php echo $lang['password']; ?>" vaue="<?php echo @$_POST['pass']; ?>" />
	<br /><br />
	<input type="submit" name="submit" value="<?php echo $lang['login']; ?>" />
</form>
<?php
require '_btm.php';
?>