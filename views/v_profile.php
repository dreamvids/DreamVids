 <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="/profile"><?php echo $lang['my_account']; ?></a>
          <a class="blog-nav-item" href="/pass"><?php echo $lang['password']; ?></a>
          <a class="blog-nav-item" href="/manager"><?php echo $lang['my_vids']; ?></a>
          <a class="blog-nav-item" href="/mail"><?php echo $lang['msg']; ?></a>

        </nav>
      </div>
    </div>

<?php
echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : '';
echo (!isset($err) && isset($_POST['submit']) ) ? '<div class="alert alert-success">'.$lang['profile_ok'].'</div>' : '';
?>

<div class='container'>

	<div class='container'>
		<div class='border-top'></div>
		<h1><?php echo $lang['member_space']; ?><small> <?php echo secure($session->getName() ); ?></small></h1>
		<div class='border-bottom'></div>
	</div>

	<br><br>

	<div class='container'>

	 <div class="panel panel-primary" > <div class="panel-heading">
              <h3 class="panel-title"><?php echo $lang['edit_user']; ?></h3>
            </div>
            

	<br><br>

	<div class="container" style="width: 80%;">
		<form action="" method="post" role="form" enctype="multipart/form-data">
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
					<img src="<?php echo $session->getAvatarPath(); ?>" style="width: 100px;">
				<?php } ?>

				<input type="file" id="avatar" name="avatar" />
			</div>
			<br /><br />
			<div class="form-group">
				<label for="background"><?php echo $lang['background']; ?></label>
				<?php if($session->getBackgroundPath() != '') { ?>
					<img src="<?php echo $session->getBackgroundPath(); ?>" style="width: 150px;">
				<?php } ?>
				
				<input type="file" id="background" name="background" />
			</div>
			<br /><br />
			<input type="submit" name="submit" value="<?php echo $lang['profile_update']; ?>" class='btn btn-primary' />
			<br /><br />
		</form>
		</div></div>
	</div>
</div>
