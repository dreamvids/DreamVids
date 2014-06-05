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
<div class="container" style="">
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
			<li class="list-group-item"><a href="./@<?php echo secure($sub->getName() ); ?>"><img width="24" src="<?php echo secure($sub->getAvatarPath() ); ?>" alt="" /></a>&nbsp;&nbsp;<a href="./@<?php echo secure($sub->getName() ); ?>"><?php echo secure($sub->getName() ); ?></a></li>
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
		echo '<div class="col-md-6">';
	}
	else
	{
		echo '<div class="col-md-4">';
	}
	
	$titleVid = (strlen($vid->getTitle() ) > 32) ? secure(substr($vid->getTitle(), 0, 29) ).'...' : secure($vid->getTitle() );
	$descVid = (strlen($vid->getDescription() ) > 60) ? secure(substr($vid->getDescription(), 0, 57) ).'...' : secure($vid->getDescription() );
	$userVid = (strlen(User::getNameById(secure($vid->getUserId())) ) > 23) ? secure(substr(User::getNameById(secure($vid->getUserId())), 0, 20) ).'...' : secure(User::getNameById(secure($vid->getUserId()) ));
	if($vid->getViews()>1){
		$views = $lang['views'] . ( $vid->getViews()>1 ? 's' : '' );
	}
	else{
		$views = $lang['views'];
	}
?>

            <div class="thumbnail featuredbox">
	          <div class="col-md-5">
	            <a href="&<?php echo secure($vid->getId() ); ?>">
	            	<div class="max-size">
	            		<span class="image" style="background-image:url(<?php echo ($vid->getTumbnail() != '') ? secure($vid->getTumbnail() ) : secure($vid->getPath() ).'.jpg'; ?>)" title="<?php echo $vid->getTitle(); ?>"></span>
	            	</div>
	            </a>
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
