<div class="container">

	<?php

		$staff_selection = ($config['staff_select'] != 0) ? true : true;

		if ($staff_selection && !@$_GET["mode"]) { 
			$vid = Video::get($config['staff_select']);	
	?>

		<div class="staff-selection">

			<h2 class="title">Séléction du Staff</h2>

			<div id="staff-selection-zone">
				
				<div class="staff-selection-thumbnails" id="staff-selection-zone--thumbnails" style="background-image:url(<?php echo $vid->getTumbnail(); ?>)">

					<span class="overlay"></span>

				</div>

				<div style="display: none;" class="staff-selection-embed" id="staff-selection-zone--embed"></div>

			</div>

			<a href="&<?php echo $vid->getId(); ?>"><h4><?php echo $vid->getTitle(); ?></h4></a>

			<div class="additionnal">

				<span class="view"><?php echo $vid->getViews(); ?></span>
				<a class="channel" href="@<?php echo User::getNameById($vid->getUserId() ); ?>"><?php echo User::getNameById($vid->getUserId() ); ?></a>

			</div>

			<p class="desc"><?php echo bbcode(nl2br(secure($vid->getDescription() ) ) ); ?></p>

			<div class="clear-both"></div>

			<script>

				var SELECTIONSTAFF_VIDEO_ID = "<?php echo $vid->getId(); ?>";

				var staffselection_zone = document.getElementById("staff-selection-zone"),
					staffselection_zone_thumbnails = document.getElementById("staff-selection-zone--thumbnails"),
					staffselection_zone_embed = document.getElementById("staff-selection-zone--embed");

				staffselection_zone_thumbnails.addEventListener("click", function() {

					staffselection_zone_thumbnails.style.display = "none";
					staffselection_zone_embed.style.display = "block";

					staffselection_zone_embed.innerHTML = '<iframe style="width: 100%; height: 100%;" frameborder="0" src="http://stornitz.fr/DreamVids/' + SELECTIONSTAFF_VIDEO_ID + '" allowfullscreen></iframe>';
					
				}, false);

			</script>

		</div>

	<?php } ?>

	<div class="container">
		<h1 class="title"><?php echo $title; ?></h1>
	</div>

	<!-- SUBSCRIPTION LIST -->

	<?php if (@$_GET["mode"] == "subscriptions") { ?>
		
		<aside class="aside-channels">

			<?php 

			if (count($subs) >= 1) { ?>

				<h3 class="title">Mes abonnements</h3>

				<ul>

					<?php foreach ($subs as $sub) {

						$subscribers = $sub->getSubscribers() . " Abonné" . ($sub->getSubscribers() > 1 ? "s" : "");

						if (secure($sub->getName()) != "") { ?>

						<a href="./@<?php echo secure($sub->getName()); ?>" class="channels">
							<span style="background-image: url(<?php echo secure($sub->getAvatarPath() ); ?>)" class="avatar"></span>
							<span class="name"><?php echo secure($sub->getName() ); ?></span>
							<p class="subscribers"><b><?php echo secure($sub->getSubscribers() ); ?></b> Abonnés</p>
						</a>

						<?php }

					} ?>

				</ul>

			<?php }

			else { ?>

				<h3 class="title">Aucun abonnement</h3>

			<?php } ?>

		</aside>

	<?php } ?>

	<!-- VIDEOS LIST -->

	<?php if (@$_GET["mode"] == "subscriptions") { ?>

		<aside class="aside-cards-list">

	<?php } else { ?>

		<aside class="full-cards-list">

	<?php } 


		if (!in_array(@$_GET['mode'], array('subscriptions', 'search', 'discover') ) )
		{
			//TODO: Afficher un espace dédié à la "vidéo du moment" (front end uniquement)
		}

		foreach ($vids as $vid) {
			
			$titleVid = (strlen($vid->getTitle() ) > 32) ? secure(substr($vid->getTitle(), 0, 29) ).'...' : secure($vid->getTitle() );
			$descVid = (strlen($vid->getDescription() ) > 60) ? secure(substr($vid->getDescription(), 0, 57) ).'...' : secure($vid->getDescription() );
			$userVid = (strlen(User::getNameById(secure($vid->getUserId())) ) > 23) ? secure(substr(User::getNameById(secure($vid->getUserId())), 0, 20) ).'...' : secure(User::getNameById(secure($vid->getUserId()) ));
			
			if($vid->getViews() > 1) {
				$views = $lang['views'] . ( $vid->getViews()>1 ? 's' : '' );
			}

			else {
				$views = $lang['views'];
			}

			?>

		    <div class="card video">
		    	<div class="thumbnail" style="background-image:url(<?php echo secure($vid->getTumbnail() ); ?>)">
		    		<a href="&<?php echo secure($vid->getId() ); ?>" class="overlay"></a>
		    	</div>
		    	<div class="description">
		    		<a href="&<?php echo secure($vid->getId() ); ?>"><h4><?php echo $titleVid; ?></h4></a>
		    		<div>
		    			<span class="view"><?php echo $vid->getViews(); ?></span>
		    			<a class="channel" href="@<?php echo User::getNameById(secure($vid->getUserId())); ?>"><?php echo $userVid; ?></a>
		    		</div>
		    	</div>
		    </div>

		<?php } ?>

	</aside>
</div>