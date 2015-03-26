<div class="middle">
	<h1 class="title">Chasse aux oeufs<a href="<?php echo WEBROOT . 'egg';?>">Plus d'infos</a></h1>
	
		<p>
			Mince ! Cet oeuf a déjà été volé. <a class="link" href="<?php echo WEBROOT . 'egg'; ?>">Cherchez encore !</a><br>
			<?php if(Session::isActive()){ ?>
				Vous avez pour l'instant <b><?php echo $pts; ?></b> point<?php echo $pts > 1 ? 's' : '' ?> 
			<?php } ?>
		</p>	
		<p class="center">
			<img src="<?php echo IMG . 'eggs/egg_cracked_normal.png'; ?>">		
		</p>	
	
</div>