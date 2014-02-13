<div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item" href="/profile"><?php echo $lang['my_account']; ?></a>
          <a class="blog-nav-item active" href="/pass"><?php echo $lang['password']; ?></a>
          <a class="blog-nav-item" href="/manager"><?php echo $lang['my_vids']; ?></a>
          <a class="blog-nav-item" href="/mail"><?php echo $lang['msg']; ?></a>

        </nav>
      </div>
    </div>

<?php
echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : '';
echo (!isset($err) && isset($_POST['submit']) ) ? '<div class="alert alert-success">'.$lang['profile_ok'].'</div>' : '';
?>

<div class="container">
	<div class="container">
		<div class='border-top'></div>
			<h1><?php echo $session->getName(); ?><small> Mot de passe</small></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class="container">
		 <div class="panel panel-primary" > <div class="panel-heading">
              <h3 class="panel-title"><?php echo $lang['edit_pass']; ?></h3>
            </div>
            

	<br><br>

	<div class="container" style="width: 80%;">
		<form action="" method="post" role="form">
			<div class="form-group">
				<label for="actualPass">Mot de passe actuel</label>
				<input type="password" required name="actualPass" id="actualPass" class="form-control" />
			</div>
			
			<div class="form-group">
				<label for="pass1">Nouveau mot de passe</label>
				<input type="password" required name="pass1" id="pass2" class="form-control" />
			</div>
			
			<div class="form-group">
				<label for="pass2">Confirmer le nouveau mot de passe</label>
				<input type="password" required name="pass2" id="pass2" class="form-control" />
			</div>
			
			<input type="submit" class="btn btn-primary" name="submit" style="margin-bottom:20px" />
		</form>
			</div></div>
	</div>
</div>