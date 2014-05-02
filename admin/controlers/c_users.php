<?php
switch (@$_GET['action'])
{
	case 'edit':
		$user = new User($_GET['id']);
		$title = 'Editer';
		$subtitle = $user->getName();
		if ($user->getRank() < $session->getRank() || $session->getRank() == $config['rank_adm'])
		{
			if (isset($_POST['submit']) )
			{
				$user->setUsername($_POST['username']);
				$user->setEmailAddress($_POST['email']);
				if ($_POST['pass'] != '')
					$user->setPass($_POST['pass']);
				$user->setAvatarPath($_POST['avatar']);
				$user->setBackgroundPath($_POST['background']);
				if ($session->getRank() == $config['rank_adm'])
					$user->setRank($_POST['rank']);
				$user->saveDataToDatabase();
			}
		}
		else
		{
			header('location: ?page=users');
			exit();
		}
		break;
	
	case 'delete':
		$user = new User($_GET['id']);
		if ($user->getRank() == $config['rank_mbr'])
			AdminUsers::delete($_GET['id'], $session->getName() );
		header('location:?page=users');
		exit();
		break;
	
	default:
		$title = 'Utilisateurs';
		$page = (isset($_GET['p']) && $_GET['p'] > 1) ? $_GET['p'] : 1;
		$subtitle = 'Page '.$page;
		$nb_users_page = 50;
		$nb_pages = ceil(AdminUsers::usersCount() / $nb_users_page);
		$users = AdminUsers::fetchAll($page, $nb_users_page);
		$ranks = array(1 => 'Utilisateur', 5 => 'Modérateur', 9 => 'Administrateur');
		$colors = array(1 => 'black', 5 => '#FF9900', 9 => 'red');
		break;
}
?>