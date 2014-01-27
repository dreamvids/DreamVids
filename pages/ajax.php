<?php
$ajax = new Ajax();
switch (@$_GET['action'])
{
	case 'like':
		$ajax->like($_GET['vid']);
	break;
	
	case 'dislike':
		$ajax->dislike($_GET['vid']);
	break;
	
	case 'like_comment':
		
	break;
	
	case 'dislike_comment':
		
	break;
	
	case 'subscribe':
		$ajax->subscribe($_GET['dr_id']);
	break;
	
	case 'unsubscribe':
		$ajax->unsubscribe($_GET['dr_id']);
	break;
	
	case 'comment':
		$ajax->comment($_GET['vid']);
	break;
}
?>