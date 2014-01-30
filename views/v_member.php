<?php

?>
<link href="css/perso.php?uid=<?php echo secure($member->getId()); ?>" rel="stylesheet" />
<div class="container" id="user">
<div class='container' id='content'>
<div class='container' id="abonement">		
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
</div>
	<div class="container" id="head">
		<div id="img">
			<img src="<?php echo $avatar; ?>" class="picture" height="70" width="70"/> 
		</div>
		<div id="pseudo">
			<div class='border-top'></div>
				<h1><?php echo secure($pseudo); ?></h1>	
			<div class='border-bottom'></div>
		</div>
	</div>

	<div class='container' style=''>
		<h2><a href="index.php?page=member&name=<?php echo secure($pseudo); ?>&all=1">Videos</a></h2><br />	
		<div class="row">
			
		<?php

		foreach ($videos as $vid) {
			?>
				<div class="col-md-2">
				   <a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>" class="thumbnail" style="width: 171px; height:100px;">
				     <div style="height:90px;width:100%;overflow:hidden">
				      <img data-src="holder.js/171x97" width="161" src="<?php echo ($vid->getTumbnail() != '') ? secure($vid->getTumbnail() ) : secure($vid->getPath() ).'.jpg'; ?>">
				     </div>
				    </a>
				    <a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>">
						<?php 
						$nbc_title = strlen(secure($vid->getTitle()));
						echo '<b>'.substr(secure($vid->getTitle() ), 0, 26).''; 
						if($nbc_title > 26){ echo '...'; }
						echo '</b>';
						?>
					</a>
					<br />
				    <?php echo $lang['by'].' <a href="index.php?page=member&name='.User::getNameById(secure($vid->getUserId() ) ).'">'.User::getNameById(secure($vid->getUserId() ) ).'</a>'; ?><br />
				    <?php echo relative_time($vid->getTimestamp()).' - <small>'.$vid->getViews().' '.$lang['views'].'</small>'; ?>
				    
				</div>
			<?php
			if (count($videos) > 5) {
				echo "<br />";
			}
		}
		?>
		</div>
	</div>
</div>
</div>