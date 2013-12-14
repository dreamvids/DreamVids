<?php
include 'includes/bdd.class.php';
include 'includes/functions.php';
include 'includes/tasks.php';
require 'models/m_reg.php';

if (isset($_GET['out']) )
{
	Log::Logout($session->user_id);
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
			Log::connect($user);
			header('location:./');
			exit();
		}
		else
		{
			$err = $lang['error_log_pass'];
		}
	}
	else
	{
		$err = $lang['error_log_username'];
	}
}

require 'views/v_log.php';
?>