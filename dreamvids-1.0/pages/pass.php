<?php
if (!isset($session) )
{
	header('location:./');
	exit();
}

$user = new User($session->getId() );
if (isset($_POST['submit']) )
{
	$actualPass = Pass::getPassFromId($session->getId() );
	if ($actualPass == sha1($_POST['actualPass']) )
	{
		if ($_POST['pass1'] == $_POST['pass2'])
		{
			$user->setPass($_POST['pass1']);
		}
		else
		{
			unset($_POST['pass1']);
			unset($_POST['pass2']);
			$err = $lang['error_reg_equality_pass'];
		}
	}
	else
	{
		unset($actualPass);
		$err = $lang['error_log_pass'];
	}
}
?>