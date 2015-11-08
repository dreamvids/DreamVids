<div class="row">
	<h1>Statistiques</h1>
	<div class="col-md-6">
		<div class="well">
			<h3>Nombre d'utilisateurs : <?php echo $counts['users']; ?></h3>
			<h3>Nombre de chaînes : <?php echo $counts['channels']; ?></h3>
			<h3>Nombre de vidéos : <?php echo $counts['videos']; ?></h3>
			<h3>Chaînes ayant posté des vidéos : <?php echo $counts['channels_having_videos']; ?><small> (<?php echo $counts['part_of_channels_having_videos']; ?> % )</small></h3>
			<h3>Nombre total de vues : <?= $counts['total_views'] ?></h3>
			<h3>Durée cummulée de vidéo : <?= floor($counts['total_sec']/3600); ?> heures</h3>
		</div>
	</div>
	<div class="col-md-6">
		<div class="well">
			<h3>Ratio chaines/utlisateurs : <?php echo $counts['channel_user_ratio']; ?></h3>
			<h3>Part des vidéos commentées : <?php echo $counts['part_of_commented_videos']; ?> %</h3>
		</div>
	</div>
</div>
<div class="row">	
	<div class="col-md-6">
		<div class="well">
			<h3>Utilistateurs possédant 1 chaîne : <?php echo $counts['user_1_channel']; ?><small> (<?php echo $counts['user_1_channel_part']; ?> % )</small></h3>
			<h3>Utilistateurs possédant 2 chaînes : <?php echo $counts['user_2_channel']; ?><small> (<?php echo $counts['user_2_channel_part']; ?> % )</small></h3>
			<h3>Utilistateurs possédant 3 chaînes : <?php echo $counts['user_3_channel']; ?><small> (<?php echo $counts['user_3_channel_part']; ?> % )</small></h3>
			<h3>Utilistateurs possédant plus de 3 chaînes : <?php echo $counts['user_more3_channel']; ?><small> (<?php echo $counts['user_more3_channel_part']; ?> % )</small></h3>
		</div>
	</div>	
</div>