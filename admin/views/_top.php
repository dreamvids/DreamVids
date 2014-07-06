<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="icon" type="image/png" href="img/favicon.png" />
    <title>Administration - DreamVids</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  </head>

  <body>

    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./"><img src="img/logo.png" alt="Admin" height="50px" /></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li <?php echo ($_GET['page'] == 'home') ? 'class="active"' : ''; ?>><a href="?page=home"><i class="fa fa-dashboard"></i> Accueil</a></li>
            <li <?php echo ($_GET['page'] == 'users') ? 'class="active"' : ''; ?>><a href="?page=users"><i class="fa fa-user"></i> Utilisateurs</a></li>
            <li <?php echo ($_GET['page'] == 'videos') ? 'class="active"' : ''; ?>><a href="?page=videos"><i class="fa fa-video-camera"></i> Vidéos</a></li>
            <li <?php echo ($_GET['page'] == 'comments') ? 'class="active"' : ''; ?>><a href="?page=comments"><i class="fa fa-comments"></i> Commentaires</a></li>
<?php
if ($session->getRank() == $config['rank_adm'])
{
?>
            <li <?php echo ($_GET['page'] == 'partners') ? 'class="active"' : ''; ?>><a href="?page=partners"><i class="fa fa-star"></i> Partenaires</a></li>
            <li <?php echo ($_GET['page'] == 'contributors') ? 'class="active"' : ''; ?>><a href="?page=contributors"><i class="fa fa-users"></i> Contributeurs</a></li>
            <li <?php echo ($_GET['page'] == 'config') ? 'class="active"' : ''; ?>><a href="?page=config"><i class="fa fa-tasks"></i> Variables de configuration</a></li>
<?php
}
?>
            <li><a href="http://dreamvids.fr"><i class="fa fa-external-link"></i> Site</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> Liens externes <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a target="_blank" href="http://github.com/Vetiore/DreamVids">GitHub</a></li>
                <li><a target="_blank" href="http://twitter.com/DreamVids_">Twitter</a></li>
                <li><a target="_blank" href="http://facebook.com/DreamVids">Facebook</a></li>
              </ul>
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li <?php echo ($_GET['page'] == 'flagged') ? 'class="active"' : ''; ?>><a href="?page=moderation"><i class="fa fa-exclamation-triangle"></i> Signalements <span class="badge"><?php echo $nb_flags; ?></span></a></li>
<?php if ($session->getRank() == $config['rank_adm']) { ?><li <?php echo ($_GET['page'] == 'bugs') ? 'class="active"' : ''; ?>><a href="../?page=bugs"><i class="fa fa-bug"></i> Bugs <span class="badge"><?php echo $nb_bugs; ?></span></a></li><?php } ?>
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $session->getName(); ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="../@<?php echo $session->getName(); ?>"><i class="fa fa-desktop"></i> Ma chaine</a></li>
                <li><a href="../mail"><i class="fa fa-envelope"></i> Messages <span class="badge">7</span></a></li>
                <li><a href="../manager"><i class="fa fa-gear"></i> Manager</a></li>
                <li class="divider"></li>
                <li><a href="../logout"><i class="fa fa-power-off"></i> Déconnexion</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>

      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1><?php echo @$title; ?> <small><?php echo @$subtitle; ?></small></h1>
          </div>
        </div><!-- /.row -->

		<div class="row">
          <div class="col-lg-12">
