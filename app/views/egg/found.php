<div class="middle">
	<h1 class="title">Chasse aux oeufs</h1>
	
		<p>
			Félicitations ! Vous avez trouvé un oeuf <?php echo $egg->points == 3 ? ' en or' : '' ?>!<br>
			<?php if(Session::isActive()){ ?>
			Vous avez maintenant <b><?php echo $pts; ?></b> point<?php echo $pts > 1 ? 's' : '' ?> 
			<?php }else{ ?>
			
			<?php } ?>
		</p>	
		<p class="center">
			<img src="<?php echo $egg->points == 3 ? 'http://placehold.it/350/f39c12/fff' : 'http://placehold.it/350'; ?>">		
		</p>	
	
</div>