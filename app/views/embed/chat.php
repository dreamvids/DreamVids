<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo CSS.'style.css'; ?>">
		<meta name="viewport" content="width = device-width, initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<link rel="icon" href="<?php echo IMG.'favicon.png'; ?>" />
		<title>DreamVids - chat du live</title>
		<script>
		var _currentpage_ = "live";
		var _logged_ = <?php echo Session::isActive() ? 'true' : 'false'; ?>;
		var _webroot_ = "<?php echo WEBROOT ?>";
		</script>
		<style>
						html,
						body {
			
							width: 100%;
							height: 100%;
			
							padding: 0;
							margin: 0;
			
						}
						
						.video-infos .live{
							margin:0;
						}
						.live-chat__form{
							bottom:0px;
						}
						.live-chat, .live-chat__messages{
							height:100%;
							box-sizing:border-box;
							padding-bottom:65px;
						}			
		</style>
	</head>

	<body class="embeded">
	<section class="video-infos live"  style="margin:0; width:100%; height:100% !important;">

		<div class="views" id="viewers"><?php echo $viewers; ?> viewers</div>

		<hr>

		<div class="live-chat">
		<?php if(!Session::isActive()){ ?>
		<a target="_blank" href="<?php echo WEBROOT . 'login'?>">Se connecter ou s'inscrire</a>
		<?php } ?>
			<div class="live-chat__messages" id="messages-panel"></div>
		</div>
			<form class="live-chat__form" method="post" onsubmit="return false;" onclick="document.getElementById('live-chat-input').focus();">

				<input class="live-chat__form__input" id="live-chat-input" type="text" placeholder="Message">

			</form>

	</section>
	</body>
	<script>
		var channelId = '<?php echo $channel->id; ?>';
		var chatLiveOptions = {
			ip: '<?php echo Config::getValue_('livechat-address'); ?>',
			port: <?php echo Config::getValue_('livechat-port'); ?>,
			channel: '<?php echo $channel->name; ?>',
			username: '<?php if(Session::isActive()){ echo Session::get()->username; } ?>',
			sessionId: '<?php if(Session::isActive()){ echo Session::getId(); } ?>'
		};
	
	</script>
	<script src="<?php echo JS.'script.js'; ?>"></script>
	<script type="text/javascript">
	checkLogged= function (){
		marmottajax.get({url : _webroot_ + 'login/logged'}).then(function(result){
			data = JSON.parse(result);
			if(data.logged && _logged_ === false){
				location.reload();
			}
		});
		
	}
	if(!_logged_){
		setInterval(checkLogged, 1000);
	}
	</script>
</html>
