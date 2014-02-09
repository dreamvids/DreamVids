 <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item" href="/profile"><?php echo $lang['my_account']; ?></a>
          <a class="blog-nav-item" href="/pass"><?php echo $lang['password']; ?></a>
          <a class="blog-nav-item" href="/manager"><?php echo $lang['my_vids']; ?></a>
          <a class="blog-nav-item active" href="/mail"><?php echo $lang['msg']; ?></a>

        </nav>
      </div>
    </div>

<div class="container">
	<div class="container">
		<div class='border-top'></div>
			<h1><?php echo $session->getName(); ?><small> <?php echo $lang['msg']; ?></small></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-primary" width="25px" height="600px">
					<div class="panel-heading">
						<span style="font-size:16px;">Derniers Messages</span>
					</div>
					<div class="panel-body" width="25px" height="600px">

						<?php
						$lastMessages = Mail::getLastReceivedMessages($session->getId(), 2);

						if(count($lastMessages) < 1) {
							echo '
							<div class="well" weight="95%" height="95%">
								'.$lang['no_new_messages'].'
							</div>
							';
						}

						foreach ($lastMessages as $msg) {
							echo '
							<div class="well" weight="95%" height="95%">
								<a href="./?page=mail&recipient='.$msg->getSender().'" style="text-decoration:none;">'.$msg->getSendersName().'</a>
								<br>
								<span style="font-size:12px;color:#66757f;">'.$msg->getContent().'</span>
							</div>
							';
						}
						?>
					</div>
				</div>

				<div class="panel panel-primary" weight="25px" height="600px">
					<div class="panel-heading" weight="25px" height="600px">
						<h3 class="panel-title">Envoyer un message à:</h3>
						<br>

						<div class="list-group" style="height: 200px; overflow-y:scroll;">
							<?php
							$users = Mail::getAllUsers();

							foreach ($users as $user) {
								echo "
								<a href='./?page=mail&recipient=".$user->getId()."' class='list-group-item'>".$user->getName()."</a>
								";
							}
							?>
						</div>
					</div>
				</div>
			</div>

			<?php
			if(isset($recipient) && $recipient != '') { 
				$lastReceivedMessage = Mail::getLastMessageFromTo($recipient->getId(), $session->getId());
				$lastSentMessage = Mail::getLastMessageFromTo($session->getId(), $recipient->getId());
			?>
			<div class="col-md-6 text-center">
				<div class="well">
					<div class="page-header" style="margin-top:0px;padding-top:0px;">
						<h1><?php echo $recipient->getName(); ?><br><small style="font-size:17px;"> <?php echo User::getRankNameByRankId($recipient->getRank()); ?></small></h1>
					</div>

					<?php if(isset($lastReceivedMessage)) { ?>
					<div class="well" wight="55%" height="30px" style="background-color:#f8f8f8;align:left;width:55%;border:1px solid green;border-radius:55px" align="bottom">
						<span style="font-size:15px;"><?php echo $lastReceivedMessage->getContent(); ?></span>
					</div>
					<?php } ?>

					<?php if(isset($lastSentMessage)) { ?>
					<div class="well" wight="55%" height="30px" style="border:1px solid #3091db;align:right;width:55%;margin-left:45%;background-color:#f8f8f8;border-radius:55px" align="bottom">
						<span style="font-size:15px;align:right;left-padding:75%;"><?php echo $lastSentMessage->getContent(); ?></span>
					</div>
					<?php } ?>

					<br>

					<form role="form" action="" method="post">
						<div class="input-group">
							<textarea type="text" name="sendMessage" class="form-control" rows="4" style="resize:none;"></textarea>
							<span class="input-group-btn">
								<input type="submit" name="sendSubmit" class="btn btn-default" style="height:94px;">
							</span>
						</div>
					</form>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>