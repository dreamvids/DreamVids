<div class="content">

	<section class="">
		<h1 class="title">Chaînes</h1>
		
		<?php
			include VIEW.'layouts/accountMenu.php';
			include VIEW.'layouts/messages.php';
		?>

    	<div class="moderating-commands">
    		<a href="<?php echo WEBROOT.'channels/add'; ?>">
    			<button class="blue big" name="create-channel">Ajouter une chaîne</button>
    		</a>		
    	</div>
    	
    	<aside class="long-cards-list">
    		<?php
    			foreach ($channels as $chan) {
					?>


					<div class="card channel long">
						<a href="<?php echo WEBROOT.'channels/edit/'.$chan->id ?>">
							<div class="avatar bgLoader" data-background="http://lorempicsum.com/futurama/255/200/2"></div>
						</a>

						<div class="description">
							<a href="<?php echo WEBROOT.'channel/'.$chan->id; ?>"><b><?php echo $chan->name; ?></b></a>
							<a href="<?php echo WEBROOT.'channels/edit/'.$chan->id ?>"><button>Paramètres</button></a>
							<b class="principal">(Chaîne principale)</b>
							<span class="subscriber"><b><?php echo $chan->subscribers; ?></b> Abonné(s)</span>
						</div>
					</div>
	
					<?php
    			}
    		?>
    	</aside>
	</section>

</div>