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
	<div class='row' style='margin:0;'>			
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
			<div class="col-md-6" style=''>
			<div class="thumbnail featuredbox">
	          <div class="col-md-5">
	            <a href="&<?php echo secure($vid->getId() ); ?>" ><img src="<?php echo ($vid->getTumbnail() != '') ? secure($vid->getTumbnail() ) : secure($vid->getPath() ).'.jpg'; ?>" alt="<?php echo $vid->getTitle(); ?>" title="<?php echo $vid->getTitle(); ?>"></a>
	          </div>
	          <div class="col-md-7">
	              <div class="hotfeaturedtext">
	                <strong><?php echo '<b>'.$titleVid.'</b>'; ?></strong>
	                <p><?php echo $descVid; ?></p>
	              </div> <!--/featuredtext-->
	              <div class="hotfeaturedbutton"> 
	                <hr>
	               <span><?php echo $lang['by'].' <a href="@'.User::getNameById(secure($vid->getUserId())).'">'.$userVid.'</a>'; ?><br>
					    <?php echo relative_time($vid->getTimestamp()).' - <small>'.$vid->getViews().' '.$views.'</small>'; ?></span>
	              </div>
              </div>			  
            </div>	
            </div>	

			<?php
		}
		?>
</div>
</div></div></div>


