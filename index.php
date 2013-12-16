<?php

session_start();

$content = 'pages/home.php';

if(!empty($_GET['page'])) {
	$page = htmlentities($_GET['page']);
	$pages = scandir('./pages');

	if(!empty($page) && in_array($page.'.php', $pages)) {
		$content = 'pages/'.$page.'.php';
	}
}

include('views/_top.php');
include($content);
include('views/_btm.php');

?>