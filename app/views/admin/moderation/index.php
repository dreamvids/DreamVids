<div class="row">
	<h1>Modération</h1>
	<div class="col-xs-12">
		<h2>Centre de contrôle des conneries</h2>
	</div>
</div>	
<div class="row">
	<?php foreach ($stats as $k => $value): ?>
		<div class="col-lg-4">
		<div class="panel panel-<?php echo $view_colors[$k]; ?>">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
<!-- 					<span class="fa-stack fa-5x"> -->
						<i class="fa <?php echo $view_icons[$k][0]; ?> fa-5x"></i>
						<i class="fa <?php echo $view_icons[$k][1]; ?> fa-1x"></i>
<!-- 					</span> -->
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?php echo $value[1]?></div>
						<div><?php echo $value[0]; ?></div>
					</div>
				</div>
			</div>

			<div class="panel-footer">
				<a href="<?php echo WEBROOT . 'admin/moderation/'.$value[2];?>">Jeter un coup d'oeil</a>
				<div class="clearfix"></div>
			</div>
			</a>
		</div>


	</div>
		
	<?php endforeach; ?>
</div>
