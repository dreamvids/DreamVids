<?php
<<<<<<< HEAD
require_once('classes/User.php');

session_start();

=======
require_once('classes/LoggedUser.php');
>>>>>>> 2b20bce7553ff04d207a70723451241d430cb2bd
echo '<h1 style="text-align:center">Welcome to DreamVids.Fr !</h1>';

$user = new User('testname');
?>