<div class="content">

	<section class="profile">
		<h1 class="title">Chaînes</h1>
		
		<?php
			include VIEW.'layouts/account_menu.php';
			include VIEW.'layouts/messages.php';
		?>

		<div class="moderating-commands">
			<a href="<?php echo WEBROOT.'channels/add'; ?>">
				<button class="blue big" name="create-channel">Créer une nouvelle chaîne</button>
			</a>
		</div>

		<aside class="long-cards-list">

			<?php foreach ($channels as $chan): ?>
				<div class="card channel long">
					<a href="<?php echo WEBROOT.'channel/'.$chan->id ?>">
						<div class="avatar bgLoader" data-background="http://lorempicsum.com/futurama/255/200/2"></div>
					</a>

					<div class="description">
						<a href="<?php echo WEBROOT.'channel/'.$chan->id; ?>"><b><?php echo $chan->name; ?></b></a>
						<a href="<?php echo WEBROOT.'channel/'.$chan->id.'/edit'; ?>"><button>Paramètres</button></a>

						<?php if ($chan->isUsersMainChannel(Session::get()->id)): ?>
							<b class="principal">Chaîne principale</b>
						<?php endif ?>

						<span class="subscriber"><b><?php echo $chan->subscribers; ?></b> Abonnés</span>
					</div>
				</div>
			<?php endforeach ?>
			
		</aside>

</div>