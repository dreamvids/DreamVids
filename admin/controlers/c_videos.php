<?php
switch (@$_GET['action'])
{
	case 'edit':
		$vid = Video::get($_GET['id']);
		$title = 'Editer';
		$subtitle = $vid->getTitle();
		if (isset($_POST['submit']) )
		{
			$vid->setTitle($_POST['title']);
			$vid->setDescription($_POST['description']);
			$vid->setTags($_POST['tags']);
			if (isset($_POST['reinit_thumb']) )
				$vid->setTumbnail('http://dreamvids.fr/img/maquette_thumbnail.png');
			$vid->setVisibility($_POST['visibility']);
			$vid->saveDataToDatabase();
		}
		break;
	
	case 'suspend':
		$bool = ($_GET['bool'] == 3) ? 2 : 3;
		$vid = Video::get($_GET['id']);
		$vid->setVisibility($bool);
		$vid->saveDataToDatabase();
		header('location:?page=videos');
		exit();
		break;

	default:
		$title = 'Vidéos';
		$page = (isset($_GET['p']) && $_GET['p'] > 1) ? $_GET['p'] : 1;
		$subtitle = 'Page '.$page;
		$nb_vids_page = 50;
		$nb_pages = ceil(AdminVideos::videosCount() / $nb_vids_page);
		$vids = AdminVideos::fetchAll($page, $nb_vids_page);
		$visibility = array(0 => 'Privée', 1 => 'Non listée', 2 => 'Publique');
		$colors = array(0 => '#ff9900', 1 => 'blue', 2 => 'black', 3 => 'red');
		break;
}
?>