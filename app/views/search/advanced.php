<div class="content">
	<aside class="aside-cards-list">
		<h3 class="title">Recherche avancé</h3>
		<form class="form" method="post" action="<?php echo WEBROOT ?>search/advanced" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="put" />
						
			<label for="channel">Nom de la chaine contenant : </label>
			<input value="" type="text" name="channel" placeholder="Nom de la chaine"><br />

			<label for="video">Nom de la vidéo contenant :</label>
			<input value="<?php echo @$_SESSION['last_search']; ?>" type="text" name="video" placeholder="Vidéo"><br />
			
			<label for="tags">Tags : </label>
			<select name="tags_select_type">
				<option value="and">Vidéo possédant touts les tags suivants :</option>
				<option selected="selected" value="or">Vidéo possédant au moins un des tags suivants :</option>
			</select>
			
			<input value="" type="text" name="tags" placeholder="Tags"><br />
			
			<input type="submit" name="advancedSearchSubmit" value="Rechercher">
		</form>
		
	</aside>
</div>