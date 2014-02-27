<?php
$lang_path = '..';
include '../classes/Comment.php';
include '../classes/LoggedUser.php';
include '../classes/Video.php';
include '../includes/bdd.class.php';
include '../includes/functions.php';
include '../includes/tasks.php';

if (isset($session) && in_array($session->getRank(), array($config['rank_adm'], $config['rank_modo']) ) )
{
	$content = 'controlers/c_home.php';
   	$model = 'models/m_home.php';
   	$view = 'views/v_home.php';
   	
	if(!empty($_GET['page']) )
	{
	    $page = htmlentities($_GET['page']);
	    $pages = scandir('./controlers');
	
	    if(!empty($page) && in_array('c_'.$page.'.php', $pages) )
	    {
            $content = 'controlers/c_'.$page.'.php';
            $model = 'models/m_'.$page.'.php';
            $view = 'views/v_'.$page.'.php';
	    }
	}
	else
	{
		header('location:?page=home');
		exit();
	}
	
	include $model;
	include $content;
	include 'views/_top.php';
	include $view;
	include 'views/_btm.php';
	exit();
}
else
{
	echo '<!doctype html>
<html>
	<head>
		<title>Administration - DreamVids</title>
		<meta charset="utf-8" />
	</head>
	
	<body>
		<h1 style="text-align:center">Administration</h1>
		<h3>Bienvenue dans l\'administration de DreamVids</h3>
		<p>Page temporaire, pour pouvoir administrer le site, il faut se rendre dans la base de données, <a href="http://dreamvids.fr/&Uoz2Vb">accessible ici</a></p>
	</body>
</html>';
	exit();
}
?>