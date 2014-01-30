<?php
echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : '';
echo (!isset($err) && isset($_POST['submit']) ) ? '<div class="alert alert-success">'.$lang['profile_ok'].'</div>' : '';
?>

<div class='container'>

	<div class='container'>
		<div class='border-top'></div>
		<h1><?php echo secure($session->getName() ); ?><small> <?php echo $lang['member_space']; ?></small></h1>
		<div class='border-bottom'></div>
	</div>

	<br><br>

	<div class='container'>
		<ul class="nav nav-pills">
		  <li class="active"><a href="index.php?page=member"><?php echo $lang['my_account']; ?></a></li>
		  <li><a href="index.php?page=manager"><?php echo $lang['my_vids']; ?></a></li>
		  <li><a href="index.php?page=mail"><?php echo $lang['msg']; ?></a></li>
		</ul>
	</div>

	<br><br>

	<div class='container'>
		<form action="" method="post" role="form">
			<div class="form-group">
				<label for="email"><?php echo $lang['email_address']; ?></label>
				<input type="email" required="" placeholder="<?php echo $lang['email_address']; ?>" name="email" value="<?php echo (isset($_POST['email']) ) ? secure($_POST['email']) : secure($session->getEmailAddress() ); ?>" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="username"><?php echo $lang['username']; ?></label>
				<input type="text" required="" placeholder="<?php echo $lang['username']; ?>" name="username" value="<?php echo (isset($_POST['username']) ) ? secure($_POST['username']) : secure($session->getName() ); ?>" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="avatar"><?php echo $lang['avatar']; ?></label>

				<?php if($session->getAvatarPath() != '') { ?>
					<img src="<?php echo $session->getAvatarPath(); ?>" style="width: 128px; height: 128px;">
				<?php } ?>

				<input type="file" id="avatar" name="avatar">
			</div>
			<input type="submit" name="submit" value="<?php echo $lang['profile_update']; ?>" class='btn btn-primary' />
		</form>
	</div>

</duv>