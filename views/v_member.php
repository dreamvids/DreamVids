<?php

?>

<div class='container'>
	<div class="container" style=''>
		<div class='border-top'></div>
			<h1><?php echo secure($pseudo); ?></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class='container' style=''>
		<h2><a href="index.php?page=member&name=<?php echo secure($pseudo); ?>&all=1">Videos</a></h2>
		<div class="row">

		<?php
		if (isset($session) && $session->getId() != $member->getId() )
		{
			if (in_array($member->getId(), $session->getSubscriptions() ) )
			{
		?>
		<button id="subscribe-<?php echo secure($member->getId() ); ?>" class="btn btn-danger" data-subscribe="S'abonner" data-unsubscribe="Abonné" data-onmouseover="Se désabonner" data-subscribers="<?php echo secure($member->getSubscribers() ); ?>" onclick="unsubscribe(<?php echo secure($member->getId() ); ?>)" onmouseover="this.innerHTML=this.getAttribute('data-onmouseover')" onmouseout="this.innerHTML=this.getAttribute('data-unsubscribe')">Abonné</button>
		<?php 
			}
			else
			{
		?>
		<button id="subscribe-<?php echo secure($member->getId() ); ?>" class="btn btn-success" data-subscribe="S'abonner" data-unsubscribe="Abonné" data-onmouseover="Se désabonner"data-subscribers="<?php echo secure($member->getSubscribers() ); ?>" onclick="subscribe(<?php echo secure($member->getId() ); ?>)">S'abonner (<?php echo secure($member->getSubscribers() ); ?>)</button>
		<?php 
			}
		}

		foreach ($videos as $vid) {
			?>
				<div class="col-md-2">
					<a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>" class="thumbnail" style="width: 171px; height:100px;">
						<div style="height:90px;width:100%;overflow:hidden">
							<img data-src="holder.js/171x97" width="161" src="<?php echo ($vid->getTumbnail() != '') ? secure($vid->getTumbnail() ) : secure($vid->getPath() ).'.jpg'; ?>">
						</div>
					</a>
					<a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>">
						<?php echo '<b>'.secure($vid->getTitle() ).'</b>'; ?>
					</a>
					<br />
					<?php echo $lang['by'].' <a href="index.php?page=member&name='.User::getNameById(secure($vid->getUserId() ) ).'">'.User::getNameById(secure($vid->getUserId() ) ).'</a>'; ?><br />
					<?php echo relative_time($vid->getTimestamp()).' - <small>'.$vid->getViews().' '.$lang['views'].'</small>'; ?>
					<br />	
				</div>
			<?php
		}
		?>
		</div>
	</div>
</div>
