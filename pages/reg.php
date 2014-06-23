<?php
if (isset($session) )
{
	header('location: ./');
	exit();
}

if (isset($_POST['submit']) )
{
	if ($_POST['email'] != '' && $_POST['username'] != '' && $_POST['pass1'] != '' && $_POST['pass2'] != '')
	{
		if (preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,10}$#", $_POST['email']) )
		{
			if (!Reg::emailExist($_POST['email']) )
			{
				if (preg_match("#^[a-zA-Z0-9\-_]{1,40}$#", $_POST['username']) )
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
		$err = $lang['error_reg_empty'];
	}
}
?>