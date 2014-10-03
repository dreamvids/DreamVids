<?php
$serv = StorageServer::setFreestServer();
file_put_contents(CACHE.'server.json', json_encode(array('in_use' => 0, 'id' => $serv)));