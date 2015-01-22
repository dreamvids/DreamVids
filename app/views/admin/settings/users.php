<div class="row">
	<h1>Gestion des admins et modérateurs</h1>
	<?php	
	foreach ($staff as $rank => $group) { ?>
	<div class="col-lg-4">
		<div class="panel panel-<?php echo $rank_color[$rank] ?>">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-comments fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?php echo isset($group[0]) &&  $group[0] ? count($group) : 0; ?></div>
						<div><?php echo $rank_name[$rank]; ?></div>
					</div>
				</div>
			</div>

			<div class="panel-footer">
				<ul class="pull-left">
                                
<?php 		

	if(!(isset($group[0]) &&  $group[0])){ echo '<li>Pas de ' . $rank_name[$rank] . '</li>'; }
	else{
	foreach ($group as $k => $user) { 
				echo '<li><a href="'.WEBROOT.'admin/settings/users/'.$user->id.'">' . $user->username . '</a></li>'; 		
		} 
	}?>
                                
                                </ul>
				<div class="clearfix"></div>
			</div>
			</a>
		</div>


	</div>
		
	<?php
	
}
	
	?>
</div>