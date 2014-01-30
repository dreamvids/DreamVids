<div class="container">
	<div class="container" style="width: 80%;">
		<div class='border-top'></div>
			<h1><?php echo $session->getName(); ?><small> Mises en ligne</small></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class='container' style='width: 80%;'>
		<ul class="nav nav-pills">
		  <li><a href="index.php?page=profile"><?php echo $lang['my_account']; ?></a></li>
		  <li class="active"><a href="index.php?page=manager"><?php echo $lang['my_vids']; ?></a></li>
		  <li><a href="#"><?php echo $lang['msg']; ?></a></li>
		</ul>

		<br><br>
	</div>

	<div class="container">
		<?php
		echo (isset($err) ) ? '<div class="container"><div class="container" style="width: 80%;"><div class="alert alert-danger">'.$lang['error'].': '.$err.'</div></div></div>' : '';
		
		foreach ($vids as $vid)
		{
		?>
			<div class="row">
				<div class="container" style="width: 80%;">
					<div class="col-md-4">
						<a href="#" class="thumbnail" style="width: 171px; height:100px;">
						 <div style="height:90px;width:100%;overflow:hidden">
					      <img data-src="holder.js/171x97" width="161" src="<?php echo ($vid->getTumbnail() != '') ? secure($vid->getTumbnail() ) : secure($vid->getPath() ).'.jpg'; ?>" />
					     </div>
					    </a>
					</div>

					<div class="col-md-4">
					    <p>Titre: <?php echo secure($vid->getTitle() ); ?></p>
					    <p>Vues: <?php echo secure($vid->getViews() ); ?></p>
					    <p>+: <?php echo secure($vid->getLikes() ); ?></p>
					    <p>-: <?php echo secure($vid->getDislikes() ); ?></p>
					</div>

					<br><br>
				    <button class='btn btn-info' onclick="document.location.href='?page=watch&vid=<?php echo $vid->getId(); ?>'">Regarder</button>
				    <button class='btn btn-success' onclick="document.location.href='?page=videoproperties&vidId=<?php echo $vid->getId(); ?>'">Paramètres</button>
				    <button class='btn btn-danger'>Supprimer</button>
					
				</div>

				<div class="container separator" style="width: 80%;"></div>
		<?php
		}
		?>
		</div>
	</div>
</div>