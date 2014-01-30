<div class="container">
	<div class="container">
		<div class='border-top'></div>
		<h1><?php echo $title; ?></h1>
		<div class='border-bottom'></div>
	</div>
</div>
<?php
if (@$_GET['mode'] == 'subscriptions')
{
?>
<div class="container" style="margin:0">
<?php
}
else
{
?>
<div class="container">
<?php
}
?>
	<br><br>

	<div class="container">
		<div class="row">
<?php
if (@$_GET['mode'] == 'subscriptions')
{
?>
			<div class="col-md-3 visible-md visible-lg">
				<ul class="list-group">
<?php
	if (count($subs) >= 1)
	{
		foreach ($subs as $sub)
		{
?>
				  <li class="list-group-item"><a href="index.php?page=member&name=<?php echo secure($sub->getName() ); ?>"><img width="24" src="<?php echo secure($sub->getAvatarPath() ); ?>" alt="" />&nbsp;&nbsp;<?php echo secure($sub->getName() ); ?></a></li>
<?php
		}
	}
	else
	{
		echo '<li class="list-group-item"><b>Aucun abonnement !</b></li>';
	}
?>
				</ul>
			</div>
			
			<div class="col-md-9">
<?php
}

foreach ($vids as $vid)
{
?>
<!-- 				<div class="col-sm-6 col-md-3">
				    <a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>" class="thumbnail" style="width: 171px; height:113px;">
				      <img data-src="holder.js/171x110" width="171" src="<?php echo ($vid->getTumbnail() != '') ? secure($vid->getTumbnail() ) : secure($vid->getPath() ).'.jpg'; ?>">
				    </a>
				    <a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>">
						<p style="margin-left: 3%;"><?php echo '<b>'.secure($vid->getTitle() ).'</b>'; ?></p>
					</a>
				    <img src="img/videos/user.png" style="width: 32px; height: 32px;">
				    <p style="display: inline-block; margin-left: 3%;"><?php echo User::getNameById(secure($vid->getUserId() ) ); ?></p>
				    <p style="display: ;"><?php echo (strlen($vid->getDescription() ) > 30) ? substr(secure($vid->getDescription() ), 0, 30).'...' : secure($vid->getDescription() ); ?></p>
				    <p style="display: inline-block; margin-top: -3%;"><?php echo secure($vid->getLikes() ).' '.$lang['likes'].' - '.secure($vid->getDislikes() ).' '.$lang['dislikes']; ?></p>
			 	</div>	 -->
			 	
<?php
	if (@$_GET['mode'] == 'subscriptions')
	{		 				
		echo '<div class="col-md-3">';
	}
	else
	{
		echo '<div class="col-md-2">';
	}
?>
				    <a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>" class="thumbnail" style="width: 171px; height:100px;">
				     <div style="height:90px;width:100%;overflow:hidden">
				      <img data-src="holder.js/171x97" width="161" src="<?php echo ($vid->getTumbnail() != '') ? secure($vid->getTumbnail() ) : secure($vid->getPath() ).'.jpg'; ?>">
				     </div>
				    </a>
				    <a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>">
						<?php echo '<b>'.substr(secure($vid->getTitle() ), 0, 26).'</b>'; ?>
					</a>
					<br />
				    <?php echo $lang['by'].' <a href="index.php?page=member&name='.User::getNameById(secure($vid->getUserId() ) ).'">'.User::getNameById(secure($vid->getUserId() ) ).'</a>'; ?><br />
				    <?php echo relative_time($vid->getTimestamp()).' - <small>'.$vid->getViews().' '.$lang['views'].'</small>'; ?>
				    <br /><br /><br /><br />
			 	</div>
<?php
}

if (@$_GET['mode'] == 'subscriptions')
{
?>
			</div>
<?php
}
?>
		</div>
	</div>
</div>