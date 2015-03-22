<div class="middle">
	<h1 class="title">Chasse aux oeufs</h1>
	
		<p>
			Félicitations ! Vous avez trouvé un oeuf <?php echo $egg->points == 3 ? ' en or' : '' ?>!<br>
			<?php if(Session::isActive()){ ?>
			Vous avez maintenant <b><?php echo $pts; ?></b> point<?php echo $pts > 1 ? 's' : '' ?> 
			<?php }else{ ?>
			<a href="<?php echo Utils::generateLoginURL(); ?>">Connectez vous</a> ou <a href="<?php echo WEBROOT . 'register'; ?>">Inscrivez-vous</a> pour gagner <?php echo $egg->points ?> point<?php echo $egg->points > 1 ? 's' : '' ?>
			<?php } ?>
		</p>	
		<p class="center">
			<img src="<?php echo $egg->points == 3 ? IMG . 'eggs/egg_gold.png' : IMG . 'eggs/egg_normal.png'; ?>">		
		</p>	
	
</div>