<?php	
	switch (@$_GET['action'])
	{
		case 'edit':
?> 
<form role="form" action="" method="post">
	<div class="form-group">
		<label for="title">Titre</label>
		<input type="text" name="title" id="title" required="required" class="form-control" value="<?php echo $vid->getTitle(); ?>" />
	</div>
	
	<div class="form-group">
		<label for="description">Description</label>
		<textarea rows="8" name="description" id="description" required="required" class="form-control"><?php echo $vid->getDescription(); ?></textarea>
	</div>
	
	<div class="form-group">
		<label for=tags>Tags</label>
		<input type="text" name="tags" id="tags" required="required" class="form-control" value="<?php echo implode(',', $vid->getTags() ); ?>" />
	</div>
	
	<div class="form-group">
		<input type="checkbox" name="reinit_thumb" id="reinit_thumb" /> <label for="reinit_thumb">Supprimer la miniature (irréversible)</label>
	</div>
	
	<label for='visibility'>Visibilité de la video: </label>	
	<div class="btn-group" data-toggle="buttons">
		<label class="btn btn-success <?php echo ($vid->getVisibility() == 2) ? 'active' : ''; ?>">
			<input type="radio" name="visibility" id="public" value="2" <?php echo ($vid->getVisibility() == 2) ? 'checked="checked"' : ''; ?>> <?php echo $lang['public'] ?>
		</label>
		<label class="btn btn-primary <?php echo ($vid->getVisibility() == 1) ? 'active' : ''; ?>">
			<input type="radio" name="visibility" id="non-listed" value="1" <?php echo ($vid->getVisibility() == 1) ? 'checked="checked"' : ''; ?>> <?php echo $lang['non_listed'] ?>
		</label>
		<label class="btn btn-danger <?php echo ($vid->getVisibility() == 0) ? 'active' : ''; ?>">
			<input type="radio" name="visibility" id="private" value="0" <?php echo ($vid->getVisibility() == 0) ? 'checked="checked"' : ''; ?>> <?php echo $lang['private'] ?>
		</label>
	</div>
	<br /><br />
	<div class="form-group">
		<input name="submit" type="submit" class="btn btn-primary" value="Modifier" />
	</div>
</form>
<?php
			break;
		
		default:
?>
<div class="table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Titre</th>
				<th>Auteur</th>
				<th>Likes / Dislikes</th>
				<th>Visibilité</th>
				<th>Modifier</th>
				<th>Suspension</th>
			</tr>
		</thead>
		<tbody>
<?php
			foreach ($vids as $vid)
			{
?>
			<tr>
				<td><a href="../&<?php echo $vid->getId(); ?>" alt="" style="font-weight:bold;color:<?php echo @$colors[$vid->getVisibility()]; ?>;"><?php echo $vid->getTitle(); ?></a></td>
				<td><?php echo User::getNameById($vid->getUserId() ); ?></td>
				<td><?php echo $vid->getLikes().' / '.$vid->getDislikes(); ?></td>
				<td><?php echo @$visibility[$vid->getVisibility()]; ?></td>
				<td><button class="btn btn-success" onclick="document.location.href='?page=videos&action=edit&id=<?php echo $vid->getId(); ?>'">Modifier</button></td>
				<td><button class="btn btn-<?php echo ($vid->getVisibility() == 3) ? 'info' : 'danger'; ?>" onclick="document.location.href='?page=videos&action=suspend&bool=<?php echo $vid->getVisibility(); ?>&id=<?php echo $vid->getId(); ?>';"><?php echo ($vid->getVisibility() == 3) ? 'Ré-activer' : 'Suspendre'; ?></button></td>
			</tr>
<?php
			}
?>
		</tbody>
	</table>
</div>
<center>
	<ul class="pagination">
<?php
			for ($i = 1; $i <= $nb_pages; $i++)
			{
				$active = ($page == $i) ? 'class="active"' : '';
				echo '<li '.$active.'><a href="index.php?page=videos&p='.$i.'">'.$i.'</a></li>';
			}
?>
	</ul>
</center>
<?php
			break;
	}
?>