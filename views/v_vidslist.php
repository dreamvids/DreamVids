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
	if (@$_GET['mode'] == 'subscriptions')
	{		 				
		echo '<div class="col-md-3">';
	}
	else
	{
		echo '<div class="col-md-2">';
	}
	
	$titleVid = (strlen($vid->getTitle() ) > 23) ? secure(substr($vid->getTitle(), 0, 20) ).'...' : secure($vid->getTitle() );
?>
				    <a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>" class="thumbnail" style="width: 171px; height:100px;">
				     <div style="height:90px;width:100%;overflow:hidden">
				      <img data-src="holder.js/171x97" width="161" src="<?php echo ($vid->getTumbnail() != '') ? secure($vid->getTumbnail() ) : secure($vid->getPath() ).'.jpg'; ?>">
				     </div>
				    </a>
				    <a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>">
						<?php echo '<b>'.$titleVid.'</b>'; ?>
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