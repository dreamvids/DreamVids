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
			<div class="col-md-3">
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
				<div class="col-sm-6 col-md-3">
				    <a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>" class="thumbnail" style="width: 171px; height:113px;">
				      <img data-src="holder.js/171x110" src="img/videos/video.png">
				    </a>
				    <a href="index.php?page=watch&vid=<?php echo secure($vid->getId() ); ?>">
						<p style="margin-left: 3%;"><?php echo '<b>'.secure($vid->getTitle() ).'</b>'; ?></p>
					</a>
				    <img src="img/videos/user.png" style="width: 32px; height: 32px;">
				    <p style="display: inline-block; margin-left: 3%;"><?php echo User::getNameById(secure($vid->getUserId() ) ); ?></p>
				    <p style="display: ;"><?php echo (strlen($vid->getDescription() ) > 30) ? substr(secure($vid->getDescription() ), 0, 30).'...' : secure($vid->getDescription() ); ?></p>
				    <p style="display: inline-block; margin-top: -3%;"><?php echo secure($vid->getLikes() ).' '.$lang['likes'].' - '.secure($vid->getDislikes() ).' '.$lang['dislikes']; ?></p>
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