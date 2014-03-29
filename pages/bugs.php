<?php
if (!isset($session) )
{
	header('location:./');
	exit();
}

//Résolution: 0: aucun;  1: bug connu;  2: en cours de résolution;  si le bug est corrigé on le supprime (3)
$res = array('En attente', 'Pris en considération', 'En cours de correction');
$rclass = array('danger', 'warning', 'success');

if (isset($_POST['submit']) )
{
	if (@$_POST['bug'] != '')
	{
		if (@$_POST['url'] == '' || filter_var($_POST['url'], FILTER_VALIDATE_URL) )
		{
			Bugs::report($_POST['bug'], @$_POST['url'], $session->getId() );
		}
		else
		{
			$err = $lang['url_valid'];
		}
	}
	else
	{
		$err = $lang['bug_empty'];
	}
}
elseif (isset($_GET['resolution']) && ($session->getRank() == $config['rank_adm'] || $session->getRank() == $config['rank_dev']) )
{
	if (in_array($_GET['resolution'], array(0, 1, 2) ) )
	{
		Bugs::setResolution($_GET['id'], $_GET['resolution'], $_GET['p']);
	}
	elseif ($_GET['resolution'] == 3)
	{
		Bugs::delete($_GET['id']);
	}
}

$page = (isset($_GET['p']) && $_GET['p'] >= 1) ? floor($_GET['p']) : 1;
$bugs = Bugs::getFromPageNumber($page);
?>
