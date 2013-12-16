<?php
echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : '';
echo (!isset($err) && isset($_POST['submit']) ) ? '<div class="alert alert-success">'.$lang['profile_ok'].'</div>' : '';
?>
<form action="" method="post">
	<input type="text" name="username" required="" value="<?php echo (isset($_POST['username']) ) ? $_POST['username'] : $session->getName(); ?>" placeholder="<?php echo $lang['username']; ?>" />
	<br /><br />
	<input type="email" name="email" required="" value="<?php echo (isset($_POST['email']) ) ? $_POST['email'] : $session->getEmailAddress(); ?>" placeholder="<?php echo $lang['email_address']; ?>" />
	<br /><br />
	<input type="url" name="avatar" value="<?php echo (isset($_POST['avatar']) ) ? $_POST['avatar'] : $session->getAvatarPath(); ?>" placeholder="<?php echo $lang['avatar']; ?>" />
	<br /><br />
	<input type="submit" name="submit" value="<?php echo $lang['profile_update']; ?>" />
</form>