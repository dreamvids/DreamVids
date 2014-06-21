<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
    <channel>
   
        <title>DreamVids</title>
        <link><a href="http://dreamvids.fr/">http://dreamvids.fr/</a></link>
        <description>DreamVids: Let us dream ! - New, Free, Open Source and French Videos sharing platform</description><br/>
        
<?php
		foreach ($videos as $vid) {
			$titleVid = (strlen($vid->getTitle() ) > 42) ? secure(substr($vid->getTitle(), 0, 39) ).'...' : secure($vid->getTitle() );
			$descVid = (strlen($vid->getDescription() ) > 86) ? secure(substr($vid->getDescription(), 0, 83) ).'...' : secure($vid->getDescription() );
			$userVid = (strlen(User::getNameById(secure($vid->getUserId())) ) > 23) ? secure(substr(User::getNameById(secure($vid->getUserId())), 0, 20) ).'...' : secure(User::getNameById(secure($vid->getUserId()) ));
			if($vid->getViews()>1){
				$views = $lang['views'] . ( $vid->getViews()>1 ? 's' : '' );
			}
			else{
				$views = $lang['views'];
			}
			?>
        <item>
            <title><?php echo '<b>'.$titleVid.'</b>'; ?></title><br/>
            <link><a href="http://dreamvids.fr/&amp;<?php echo secure($vid->getId() ); ?>">http://dreamvids.fr/&amp;<?php echo secure($vid->getId() ); ?></a></link><br/>
            <description><?php echo $descVid; ?></description><br/>
            <pubDate>Publié le: <?php echo date('d/m/Y', $vid->getTimestamp()); ?></pubDate><br/>
        </item>
<?php
}
?>
 </channel>
</rss>

