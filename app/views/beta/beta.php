<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DreamVids V2 Bêta</title>

    <link href="<?php echo WEBROOT.'app/views/beta/btm.css'; ?>" rel="stylesheet">

    <link href="<?php echo WEBROOT.'app/views/beta/style.css'; ?>" rel="stylesheet">
    
    <link rel="icon" href="<?php echo WEBROOT.'app/views/beta/favicon.png'; ?>" />

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container" style="margin-top:50px;">
	<center><img src="<?php echo WEBROOT.'app/views/beta/logo.png'; ?>" width="400" class="img-responsive"></center><br><br>
      
      <form method="post" class="form-signin" role="form" action="">
 		<b style="color:red"><?php echo (isset($msg)) ? $msg.'<br /><br />' : ''; ?></b>

        <input id="alone" name="key" class="form-control" placeholder="Clé bêta" required autofocus>
        <input id="header" name="username" class="form-control" placeholder="Nom d'utilisateur" required>
		<input type="password" name="pass" id="center" class="form-control" placeholder="Mot de passe" required>
		<input type="password" name="pass-confirm" id="center" class="form-control" placeholder="Mot de passe (Confirmation)" required>
		<input type="email" name="mail" id="footer" class="form-control" placeholder="Adresse e-mail" required>

 <br>
        <button class="btn btn-lg btn-default btn-block" name="submitRegister" type="submit">Enfin la V2 !</button>
		<br />
		<a href="login" style="color:white">Vous avez déjà un compte ? Connectez-vous !</a>
      </form>

    </div> <!-- /container -->

  </body>
</html>