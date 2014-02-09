<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $lang['dreamvids']; ?></title>
		<meta charset="utf-8" />		
		<meta http-equiv="Content-Type" content="text/html; charset = utf-8">
		<meta name="viewport" content="width = device-width, initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<link rel="icon" type="image/png" href="img/favicon.png" />
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />

		<script src="js/jquery-2.0.3.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/ajax.js"></script>

		<!-- video player header-->
			<link rel="stylesheet" type="text/css" href="dreamplayer/css/player.css"/>
		<!-- End -->
	</head>
	
	<body>

	<div id="header">
<?php
if (isset($session) )
{
?>
		<div style="float:right;margin:20px"><center><a href="index.php?page=member&name=<?php echo secure($session->getName() ); ?>"><img src="<?php echo secure($session->getAvatarPath() ); ?>" alt="" width="50" /><br /><b style="color:white"><?php echo secure($session->getName() ); ?></b></a></center></div>
<?php
}
?>
		<div id="logo" class=""><a href="index.php"><img src="img/logo_white_beta.png" class="img-responsive" alt="logo" style="height: 100px;"/></a></div>
		<br><br>
	</div>

	<div class="navbar navbar-default navbar-static-top" id="navbar" <?php if(@$_GET['page'] == 'profile' || @$_GET['page'] == 'manager' || @$_GET['page'] == 'mail' || @$_GET['page'] == 'pass') echo 'style="margin-bottom:0px;"'; ?>>
		<div class="container">
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
				<span class='icon-bar'></span>
			</button>

			<div class="collapse navbar-collapse navHeaderCollapse">
				<ul class="nav navbar-nav navbar-left">
					<li><a href="index.php?page=vidslist&mode=discover"><?php echo $lang['discover']; ?></a></li>
					<li><a href="index.php?page=vidslist"><?php echo $lang['news']; ?></a></li>
					<li><a href="index.php?page=vidslist&mode=subscriptions"><?php echo $lang['subscriptions']; ?></a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php?page=upload"><?php echo $lang['up_vid']; ?></a></li>
					<?php if(isset($session)) { ?>
					<li><a href="index.php?page=profile"><?php echo $lang['member_space']; ?></a></li>
					<li><a href="index.php?page=log&out=1"><?php echo $lang['logout']; ?></a></li>
					<?php } else { ?>
					<li><a href="index.php?page=log"><?php echo $lang['login']; ?></a></li>
					<li><a href="index.php?page=reg"><?php echo $lang['register']; ?></a></li>
					<?php } ?>
				</ul>
		<ul class="nav navbar-nav"><li><form class="navbar-form " role="search" method="post" action="?page=vidslist&mode=search">
        <div class="form-group center-block">
          <input type="search" name="search" size="35" class="form-control" placeholder="<?php echo $lang['search'].'...'; ?>">
        </div>
        <button type="submit" style="border-radius:25px" class="btn btn-default"><img src="img/search.png" width="14"></button>
      </form></li></ul>
			</div>
		</div>
	</div>
