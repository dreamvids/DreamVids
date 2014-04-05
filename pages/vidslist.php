<?php
$vidslist = new Vidslist();
switch (@$_GET['mode'])
{
	case 'discover':
		$vids = $vidslist->getDiscoverVideos(100);
		$title = $lang['discover'];
	break;
	
	case 'subscriptions':
		if(!isset($session)) {
			header('Location: login');
			exit();
		}

		$vids = $vidslist->getSubscriptionsVideos(100);
		$subs = $vidslist->getSubscriptions();
		$title = $lang['subscriptions'];
	break;
	
	case 'search':
		$q = urldecode($_GET['q']);
		if ($_GET['q'] != '' && !preg_match('#^\s*$#', $q) )
		{
			$vids = $vidslist->getSearchVideos($q);
			$title = $lang['search'].' - '.secure($q);
		}
	break;
	
	default:
		$vids = $vidslist->getNewVideos(100);
		$title = $lang['news'];
	break;
}
?>