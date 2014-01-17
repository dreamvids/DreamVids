<?php
echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : '';
echo (!isset($err) && isset($_POST['submit']) ) ? '<div class="alert alert-success">'.$lang['profile_ok'].'</div>' : '';
?>
<!--<form action="" method="post">
	<input type="text" name="username" required="" value="<?php echo (isset($_POST['username']) ) ? $_POST['username'] : $session->getName(); ?>" placeholder="<?php echo $lang['username']; ?>" />
	<br /><br />
	<input type="email" name="email" required="" value="<?php echo (isset($_POST['email']) ) ? $_POST['email'] : $session->getEmailAddress(); ?>" placeholder="<?php echo $lang['email_address']; ?>" />
	<br /><br />
	<input type="url" name="avatar" value="<?php echo (isset($_POST['avatar']) ) ? $_POST['avatar'] : $session->getAvatarPath(); ?>" placeholder="<?php echo $lang['avatar']; ?>" />
	<br /><br />
	<input type="submit" name="submit" value="<?php echo $lang['profile_update']; ?>" />
</form>-->


<div class='container'>

	<div class='container' style='width: 80%;'>
		<div class='border-top'></div>
		<h1><?php echo $session->getName(); ?><small> <?php echo $lang['member_space']; ?></small></h1>
		<div class='border-bottom'></div>
	</div>

	<br><br>

	<div class='container' style='width: 80%;'>
		<img src='img/banner-default.png'>

		<ul class="nav nav-pills">
		  <li class="active"><a href="index.php?page=member"><?php echo $lang['my_account']; ?></a></li>
		  <li><a href="index.php?page=manager"><?php echo $lang['my_vids']; ?></a></li>
		  <li><a href="#"><?php echo $lang['msg']; ?></a></li>
		</ul>
	</div>

	<br><br>

	<div class='container' style="width: 80%;">
		<form action="" method="post" role="form">
			<div class="form-group">
				<label for="email"><?php echo $lang['email_address']; ?></label>
				<input type="email" required="" placeholder="<?php echo $lang['email_address']; ?>" name="email" value="<?php echo (isset($_POST['email']) ) ? $_POST['email'] : $session->getEmailAddress(); ?>" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="username"><?php echo $lang['username']; ?></label>
				<input type="text" required="" placeholder="<?php echo $lang['username']; ?>" name="username" value="<?php echo (isset($_POST['username']) ) ? $_POST['username'] : $session->getName(); ?>" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="avatar"><?php echo $lang['avatar']; ?></label>
				<input type="url" placeholder="<?php echo $lang['avatar']; ?>" name="avatar" value="<?php echo (isset($_POST['avatar']) ) ? $_POST['avatar'] : $session->getAvatarPath(); ?>" class="form-control"/>
			</div>
			<input type="submit" name="submit" value="<?php echo $lang['profile_update']; ?>" class='btn btn-primary' />
		</form>
	</div>

</duv>