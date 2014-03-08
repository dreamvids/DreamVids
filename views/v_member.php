<?php

?>
<link href="css/perso.php?uid=<?php echo secure($member->getId()); ?>&time=<?php echo time(); ?>" rel="stylesheet" />


<div class="container">
<div class='container'>
<div class='container'>		
	
</div>
 <div class="panel panel-primary" > <div class="panel-heading">
              <h3 class="panel-title">Informations</h3>
            </div><br>
	<div class="container" >
		<div id="img">
			<img src="<?php echo $avatar; ?>" class="picture" height="70" width="70"/> 
		</div>
		<div id="pseudo">
			<div class='border-top'></div>
				<h1><?php echo secure($pseudo); ?> <small><?php echo User::getDisplayableRank($id); ?> <span class="badge"><a style="text-decoration: none; color: #fff;" href="./?page=subscribers&uid=<?php echo $member->getId(); ?>"><?php echo secure($member->getSubscribers() ); ?> Abonnés</a></span></small></h1>	
			<div class='border-bottom'></div>
		</div>
		<?php
		if (isset($session) && $session->getId() != $member->getId() )
		{
			if (in_array($member->getId(), $session->getSubscriptions() ) )
			{
		?>
		<button id="subscribe-<?php echo secure($member->getId() ); ?>" class="btn btn-danger" data-subscribe="<?php echo $lang['follow']; ?>" data-unsubscribe="<?php echo $lang['followed']; ?>" data-onmouseover="<?php echo $lang['unfollow']; ?>" data-subscribers="<?php echo secure($member->getSubscribers() ); ?>" onclick="unsubscribe(<?php echo secure($member->getId() ); ?>)" onmouseover="this.innerHTML=this.getAttribute('data-onmouseover')" onmouseout="this.innerHTML=this.getAttribute('data-unsubscribe')"><?php echo $lang['followed']; ?></button>
		<?php 
			}
			else
			{
		?>
		<button id="subscribe-<?php echo secure($member->getId() ); ?>" class="btn btn-success" data-subscribe="<?php echo $lang['follow']; ?>" data-unsubscribe="<?php echo $lang['followed']; ?>" data-onmouseover="<?php echo $lang['unfollow']; ?>"data-subscribers="<?php echo secure($member->getSubscribers() ); ?>" onclick="subscribe(<?php echo secure($member->getId() ); ?>)"><?php echo $lang['follow']; ?> (<?php echo secure($member->getSubscribers() ); ?>)</button>
		<?php 
			}
		}
		?>
	</div><br>
</div>
 <div class="panel panel-primary" > <div class="panel-heading">
              <h3 class="panel-title"><a href="/@<?php echo secure($pseudo); ?>&all=1">Videos</a></h3>
            </div><br>
	<div class='container' style=''>
		
			
		<?php

		foreach ($videos as $vid) {
			$titleVid = (strlen($vid->getTitle() ) > 18) ? secure(substr($vid->getTitle(), 0, 15) ).'...' : secure($vid->getTitle() );
			$descVid = (strlen($vid->getDescription() ) > 35) ? secure(substr($vid->getDescription(), 0, 32) ).'...' : secure($vid->getDescription() );
			?>
				<div class="col-md-2">
 			<div class="thumbnail featuredbox">
              <a href="/&<?php echo secure($vid->getId() ); ?>" ><img style="width: 171px; height:90px;" src="<?php echo ($vid->getTumbnail() != '') ? secure($vid->getTumbnail() ) : secure($vid->getPath() ).'.jpg'; ?>" alt="<?php echo $vid->getTitle(); ?>" title="<?php echo $vid->getTitle(); ?>"></a>
              <div class="hotfeaturedtext">
                <strong><?php echo '<b>'.$titleVid.'</b>'; ?></strong>
                <p><?php echo $descVid; ?></p>
              </div> <!--/featuredtext-->
              <div class="hotfeaturedbutton"> 
                <hr>
               <span><?php echo $lang['by'].' <a href="/@'.User::getNameById(secure($vid->getUserId() ) ).'">'.User::getNameById(secure($vid->getUserId() ) ).'</a>'; ?><br>
				    <?php echo relative_time($vid->getTimestamp()).' - <small>'.$vid->getViews().' '.$lang['views'].'</small>'; ?></span>
              </div>
            </div>	
				</div>

			<?php
			
		}
		?>
		

</div>
</div></div></div>


