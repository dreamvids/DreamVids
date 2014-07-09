<?php
if (!isset($session) )
{
	header('location: /login');
	exit();
}

if (isset($_POST['submit']) )
{
	if ($_POST['username'] != '' && $_POST['email'] != '')
	{
		if (!Profile::usernameExist($_POST['username'])  || $_POST['username'] == $session->getName() )
		{
			if (preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,10}$#", $_POST['email']) )
			{
				if (!Profile::emailExist($_POST['email']) || $_POST['email'] == $session->getEmailAddress() )
				{
					if (preg_match("#^[a-zA-Z0-9\-_]{1,40}$#", $_POST['username']) )
					{
						$session->setUsername($_POST['username']);
						$session->setEmailAddress($_POST['email']);
						$session->saveDataToDatabase();
					}
					else
					{
						$err = "Le nom d'utilisateur ne doit pas excéder 40 caractères et peut être constitué uniquement de lettres, de chiffres, de tirets (- et _) et de pont (.)";
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
			$err = $lang['error_reg_username'];
			unset($_POST['username']);
		}
	}
	else
	{
		$err = $lang['error_reg_empty'];
	}
}
else
{
	$_SESSION['serv'] = getFreestServer();
	if ($_SESSION['serv'] !== false) {
		$hash = hash_hmac('sha256', $_SESSION['serv']['addr'], $_SESSION['serv']['priv_key']);
		file_get_contents($_SESSION['serv']['addr'].'incomings/?fid=avatar&uid='.$session->getId().'&tid=avatar&hash='.$hash);
		file_get_contents($_SESSION['serv']['addr'].'incomings/?fid=background&uid='.$session->getId().'&tid=background&hash='.$hash);
	}
}

function startswith($hay, $needle) {
  return substr($hay, 0, strlen($needle)) === $needle;
}
?>