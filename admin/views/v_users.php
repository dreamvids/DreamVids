<?php	
	switch (@$_GET['action'])
	{
		case 'edit':
?> 
<form role="form" action="" method="post">
	<div class="form-group">
		<label for="username">Nom d'utilisateur</label>
		<input class="form-control" required="required" type="text" name="username" id="username" value="<?php echo $user->getName(); ?>" />
	</div>
	<div class="form-group">
		<label for="email">Adresse E-Mail</label>
		<input class="form-control" required="required" type="email" name="email" id="email" value="<?php echo $user->getEmailAddress(); ?>" />
	</div>
	<div class="form-group">
		<label for="pass">Mot de passe (facultatif)</label>
		<input class="form-control" type="password" name="pass" id="pass" />
	</div>
	<div class="form-group">
		<label for="avatar">Avatar</label>
		<input class="form-control" type="text" name="avatar" id="avatar" value="<?php echo $user->getAvatarPath(); ?>" />
	</div>
	<div class="form-group">
		<label for="background">Background</label>
		<input class="form-control" type="text" name="background" id="background" value="<?php echo $user->getBackgroundPath(); ?>" />
	</div>
<?php if ($session->getRank() == $config['rank_adm']) { ?>
	<div class="form-group">
		<label for="rank">Rang</label>
		<select class="form-control" name="rank" id="rank">
			<option <?php echo ($user->getRank() == $config['rank_mbr']) ? 'selected="selected"' : ''; ?> value="<?php echo $config['rank_mbr']; ?>">Utilisateur</option>
			<option <?php echo ($user->getRank() == $config['rank_modo']) ? 'selected="selected"' : ''; ?> value="<?php echo $config['rank_modo']; ?>">Modérateur</option>
			<option <?php echo ($user->getRank() == $config['rank_adm']) ? 'selected="selected"' : ''; ?> value="<?php echo $config['rank_adm']; ?>">Administrateur</option>
		</select>
	</div>
<?php } ?>
	<input name="submit" type="submit" class="btn btn-primary" value="Modifier" />
</form>
<?php
			break;
		
		default:
			echo (isset($_GET['deleted']) ) ? '<div class="alert alert-success">L\'utilisateur a été supprimé avec succès. RIP.</div>' : '';
?>
<div class="table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Nom d'utilisateur</th>
				<th>Adresse E-Mail</th>
				<th>Abonnés</th>
				<th>Rang</th>
				<th>Modifier</th>
				<th>Supprimer</th>
			</tr>
		</thead>
		<tbody>
<?php
			foreach ($users as $user)
			{
?>
			<tr>
				<td><a href="../@<?php echo $user->getName(); ?>" alt="" style="font-weight:bold;color:<?php echo @$colors[$user->getRank()]; ?>;"><?php echo $user->getName(); ?></a></td>
				<td><?php echo $user->getEmailAddress(); ?></td>
				<td><?php echo $user->getSubscribers(); ?></td>
				<td><?php echo @$ranks[$user->getRank()]; ?></td>
				<td><button class="btn btn-success" onclick="document.location.href='?page=users&action=edit&id=<?php echo $user->getId(); ?>'">Modifier</button></td>
				<td><button class="btn btn-danger" onclick="if(confirm('Êtes-vous sur de vouloir supprimer cet utilisateur ? Cette action est irréversible !')){document.location.href='?page=users&action=delete&id=<?php echo $user->getId(); ?>';}">Supprimer</button></td>
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
				echo '<li '.$active.'><a href="index.php?page=users&p='.$i.'">'.$i.'</a></li>';
			}
?>
	</ul>
</center>
<?php
			break;
	}
?>