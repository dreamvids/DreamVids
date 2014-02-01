<?php
if (!isset($session) )
{
	header('location:signin');
	exit();
}

if (isset($_POST['submit']) )
{
	if ($_POST['username'] != '' && $_POST['email'] != '')
	{
		if (strlen($_POST['username']) <= 40)
		{
			if (!Profile::usernameExist($_POST['username'])  || $_POST['username'] == $session->getName() )
			{
				if (preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,10}$#", $_POST['email']) )
				{
					if (!Profile::emailExist($_POST['email']) || $_POST['email'] == $session->getEmailAddress() )
					{
						$session->setUsername($_POST['username']);
						$session->setEmailAddress($_POST['email']);
						if ($_FILES['avatar']['name'] != '')
						{
							if ($_FILES['avatar']['size'] <= 100000)
							{
								$name = $_FILES['avatar']['name'];
								$explode = explode(".", $name);
								$ext = $explode[count($explode)-1];
								$acceptedExts = array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'svg');
								if (in_array($ext, $acceptedExts) )
								{
									$avatarPath = Profile::uploadAvatar($session->getUsername() );
									$session->setAvatarPath($avatarPath);
								}
							}
							else
							{
								$err = $lang['size_avatar'];		
							}
						}
						
						if ($_FILES['background']['name'] != '')
						{
							if ($_FILES['background']['size'] <= 2000000)
							{
								$name = $_FILES['background']['name'];
								$explode = explode(".", $name);
								$ext = $explode[count($explode)-1];
								$acceptedExts = array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'svg');
								if (in_array($ext, $acceptedExts) )
								{
									$backgroundPath = Profile::uploadBackground($session->getUsername() );
									$session->setBackgroundPath($backgroundPath);
								}
							}
							else
							{
								$err = $lang['size_background'];		
							}
						}
						$session->saveDataToDatabase();
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
			$err = $lang['error_reg_userlen'];
			unset($_POST['username']);
		}
	}
	else
	{
		$err = $lang['error_reg_empty'];
	}
}
function startswith($hay, $needle) {
  return substr($hay, 0, strlen($needle)) === $needle;
}
?>