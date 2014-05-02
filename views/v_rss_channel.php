<?xml version="1.0" encoding="ISO-8859-1"?>
<rss version="2.0">
    <channel>
   
        <title>DreamVids</title>
        <link>http://dreamvids.fr/</link>
        <description>DreamVids: Let us dream ! - New, Free, Open Source and French Videos sharing platform</description>
        
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
            <title><?php echo '<b>'.$titleVid.'</b>'; ?></title>
            <link>http://dreamvids.fr/&<?php echo secure($vid->getId() ); ?></link>
            <guid isPermaLink="true">http://dreamvids.fr/&<?php echo secure($vid->getId() ); ?></guid>
            <description><?php echo $descVid; ?></description>
            <pubDate><?php echo date('d/m/Y', $vid->getTimestamp()); ?></pubDate>
        </item>
<?php
}
?>
 </channel>
</rss>

