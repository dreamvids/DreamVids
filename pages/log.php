<?php
if (isset($session) )
{
	if (isset($_GET['out']) )
		Log::logout($session->getId() );
	header('location:./');
	exit();
}

if (isset($_POST['submit']) )
{
	if (Log::userExist($_POST['username']) )
	{
		$pass = Log::getPassFromUsername($_POST['username']);
		if (sha1($_POST['pass']) == $pass)
		{
			Log::connect($_POST['username'], $_POST['remember']);
			header('location:./');
			exit();
		}
		else
		{
			$err = $lang['error_log_pass'];
			unset($_POST['pass']);
		}
	}
	else
	{
		$err = $lang['error_log_username'];
		unset($_POST['username']);
	}
}
?>