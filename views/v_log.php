<?php
require '_top.php';

echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : '';

require '_btm.php';
?>