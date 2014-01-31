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
	
	$titleVid = (strlen($vid->getTitle() ) > 29) ? secure(substr($vid->getTitle(), 0, 26) ).'...' : secure($vid->getTitle() );
	$descVid = (strlen($vid->getDescription() ) > 35) ? secure(substr($vid->getDescription(), 0, 32) ).'...' : secure($vid->getDescription() );
?>

            <div class="thumbnail featuredbox">
              <a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>"  style="width: 171px; height:100px;"><img data-src="holder.js/171x97" width="161" src="<?php echo ($vid->getTumbnail() != '') ? secure($vid->getTumbnail() ) : secure($vid->getPath() ).'.jpg'; ?>"></a>
              <div class="hotfeaturedtext">
                <strong><?php echo '<b>'.$titleVid.'</b>'; ?></strong>
                <p><?php echo $descVid; ?></p>
              </div> <!--/featuredtext-->
              <div class="hotfeaturedbutton"> 
                <hr>
               <span><?php echo $lang['by'].' <a href="index.php?page=member&name='.User::getNameById(secure($vid->getUserId() ) ).'">'.User::getNameById(secure($vid->getUserId() ) ).'</a>'; ?><br>
				    <?php echo relative_time($vid->getTimestamp()).' - <small>'.$vid->getViews().' '.$lang['views'].'</small>'; ?></span>
              </div>
            </div>			  

				   
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