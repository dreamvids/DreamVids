<?php
if (isset($session) )
{
	header('location:./');
	exit();
}

if (isset($_GET['jam']) )
{
	require_once('includes/libjam.php');
	$jam = new JAM($_GET['token']);
	$infos = $jam->getUser();
	if (!Reg::EmailExist($infos['email_address']) )
	{
		$usernameTaken = true;
		$usernames = explode(';', $infos['username']);
		foreach ($usernames as $user)
		{
			if (!Reg::UsernameExist($user) )
			{
				$usernameTaken = false;
				$username = $user;
				break;
			}
		}
		
		if (!$usernameTaken)
		{
			Reg::register($infos['email_address'], $username, sha1($infos['password']) );
			$jam->sendResponse(1, $username);
		}
		else
		{
			$jam->sendResponse(0, $lang['error_reg_username_jam']);
		}
	}
	else
	{
		$jam->sendResponse(0, $lang['error_reg_email']);
	}
	
	exit();
}
elseif (isset($_POST['submit']) )
{
	if ($_POST['email'] != '' && $_POST['username'] != '' && $_POST['pass1'] != '' && $_POST['pass2'] != '')
	{
		if (preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,10}$#", $_POST['email']) )
		{
			if (!Reg::emailExist($_POST['email']) )
			{
				if (strlen($_POST['username']) <= 40)
				{
					if (!Reg::UsernameExist($_POST['username']) )
					{
						if ($_POST['pass1'] === $_POST['pass2'])
						{
							Reg::register($_POST['email'], $_POST['username'], $_POST['pass1']);
						}
						else
						{
							$err = $lang['error_reg_equality_pass'];
							unset($_POST['pass1']);
							unset($_POST['pass2']);
						}
					}
					else
					{
						$err = $lang['error_reg_username'];
						unset($_POST['username']);
					}
				}
				else
				{
					$err = $lang['error_reg_userlen'];
					unset($_POST['username']);
				}
			}
			else
			{
				$err = $lang['error_reg_email'];
				unset($_POST['email']);
			}
		}
		else
		{
			$err = $lang['error_reg_email_false'];
			unset($_POST['email']);
		}
	}
	else
	{
		$err = $lang['error_reg_empty'];
	}
}
?>