<?php
$hello = (isset($session) ) ? ', '.$session->getName() : '';
echo '<h1 style="text-align:center">Welcome to DreamVids.Fr'.$hello.' !</h1>';
?>