<?php
session_start();

$content = 'pages/vidslist.php';
$model = 'models/m_vidslist.php';
$view = 'views/v_vidslist.php';

if(!empty($_GET['page'])) {
    $page = htmlentities($_GET['page']);
    $pages = scandir('./pages');

    if(!empty($page) && in_array($page.'.php', $pages)) {
            $content = 'pages/'.$page.'.php';
            $model = 'models/m_'.$page.'.php';
            $view = 'views/v_'.$page.'.php';
    }
}

include 'includes/bdd.class.php';
include 'includes/functions.php';
include 'classes/LoggedUser.php';
include 'classes/Video.php';
include 'classes/Comment.php';
include 'classes/Message.php';
include 'includes/tasks.php';

if (isset($session) || @$_GET['page'] == 'log')
{
	include $model;
	include $content;
	
	if (@$_GET['page'] != 'ajax')
	{
		include 'views/_top.php';
		include $view;
		include 'views/_btm.php';
	}
	else
	{
		include $view;
	}
}
?>