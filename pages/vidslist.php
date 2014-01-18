<?php
switch (@$_GET['mode'])
{
	case 'discover':
		$vids = Vidslist::getDiscoverVideos(12);
		$title = $lang['discover'];
	break;
	
	case 'subscriptions':
		$vids = Vidslist::getSubscriptionsVideos(12);
		$title = $lang['subscriptions'];
	break;
	
	default:
		$vids = Vidslist::getNewVideos(12);
		$title = $lang['news'];
	break;
}
?>