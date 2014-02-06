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
			header('Location: ./?page=log');
			exit();
		}

		$vids = $vidslist->getSubscriptionsVideos(100);
		$subs = $vidslist->getSubscriptions();
		$title = $lang['subscriptions'];
	break;
	
	case 'search':
		$vids = $vidslist->getSearchVideos($_POST['search']);
		$title = $lang['search'].' - '.secure($_POST['search']);
	break;
	
	default:
		$vids = $vidslist->getNewVideos(100);
		$title = $lang['news'];
	break;
}
?>