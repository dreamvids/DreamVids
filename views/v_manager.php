<div class="container">
	<div class="container">
		<div class='lol'></div>
			<h1>Gestionnaire de vidéos</h1>
		<div class='yolo'></div>

		<br><br>
	</div>

	<div class="container">
<?php
foreach ($vids as $vid)
{
?>
		<div class="row">
			<div class="container">
				<div class="col-md-4">
					<a href="#" class="thumbnail" style="width: 171px; height:113px;">
				      <img data-src="holder.js/171x110" src="img/videos/video.png">
				    </a>
				</div>

				<div class="col-md-4">
				    <p>Titre: <?php echo $vid->getTitle(); ?></p>
				    <p>Vues: <?php echo $vid->getViews(); ?></p>
				    <p>+: <?php echo $vid->getLikes(); ?></p>
				    <p>-: <?php echo $vid->getDislikes(); ?></p>
				</div>

				<div class="col-md-4" style="margin-top: 3%;">
				    <button class='btn btn-info' onclick="document.location.href='?page=watch&vid=<?php echo $vid->getId(); ?>'">Regarder</button>
				    <button class='btn btn-success'>Paramètres</button>
				    <button class='btn btn-danger'>Supprimer</button>
				</div>
			</div>

			<div class="separator"></div>
<?php
}
?>
		</div>
	</div>
</div>