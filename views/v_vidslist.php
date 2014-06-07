<div class="container">

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

	<?php } ?>

		<?php 

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