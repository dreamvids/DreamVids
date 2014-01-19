<?php
$vidslist = new Vidslist();
switch (@$_GET['mode'])
{
	case 'discover':
		$vids = $vidslist->getDiscoverVideos(12);
		$title = $lang['discover'];
	break;
	
	case 'subscriptions':
		$vids = $vidslist->getSubscriptionsVideos(100);
		$subs = $vidslist->getSubscriptions();
		$title = $lang['subscriptions'];
	break;
	
	default:
		$vids = $vidslist->getNewVideos(12);
		$title = $lang['news'];
	break;
}
?>