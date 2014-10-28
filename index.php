<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set("session.gc_maxlifetime", '86400');
session_start();
date_default_timezone_set('Europe/Paris');

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

$lang_path = '.';
include 'includes/bdd.class.php';
include 'includes/functions.php';
include 'classes/LoggedUser.php';
include 'classes/Video.php';
include 'classes/Comment.php';
include 'classes/Message.php';
include 'classes/Citrouille.php';
include 'includes/tasks.php';

if ($config['maintenance'] == '0' || @($session->getRank() == $config['rank_adm']) )
{
	include $model;
	include $content;
	if (@$_GET['page'] != 'ajax' && @$_GET['page'] != 'bouuh' && @$_GET['page'] != 'rss_channel')
	{
		include 'views/_top.php';
		include $view;
		$partnerships = getPartnerships();
		include 'views/_btm.php';
	}
	else
	{
		include $view;
	}
}
else
{
	echo '<!doctype>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Maintenance - DreamVids</title>
		<link rel="icon" type="image/png" href="img/favicon.png" />
		<style type="text/css">
			body
			{
				background-color: #0986f9;
				background-image: url("img/maintenance.png");
				background-position: center;
				background-attachment:fixed;
				background-repeat: no-repeat;
			}
		</style>	
	</head>
	
	<body>
		    <script>
      (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');
     
      ga(\'create\', \'UA-34423249-4\', \'dreamvids.fr\');
      ga(\'send\', \'pageview\');
     
    		</script>
	</body>
</html>';
}
?>