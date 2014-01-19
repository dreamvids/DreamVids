<?php
$ajax = new Ajax();
switch (@$_GET['action'])
{
	case 'like':
		
	break;
	
	case 'dislike':
		
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
}
?>