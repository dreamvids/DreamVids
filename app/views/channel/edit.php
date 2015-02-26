<div class="content">

	<section class="">
		<h1 class="title">Modifier une chaîne</h1>

		<?php
			include VIEW.'layouts/account_menu.php';
			include VIEW.'layouts/messages.php';
		?>

		<form onsubmit="document.getElementById('_admins').value=JSON.stringify(admins);" class="form" method="post" action="<?php echo WEBROOT.'channel/'.$name; ?>" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="put" />
			<input type="hidden" id="_admins" name="_admins" value="" />
			
			<label for="name">Nom :</label>
			<span id="avaiabilityNameMessage"></span>
			<input value="<?php echo @$name; ?>" onchange="checkNameAvailable(this, '<?php echo @$name; ?>')" type="text" name="name" required="required" id="name" placeholder="Nom de votre chaîne" <?php echo @$mainChannel ? 'readonly' : ''; ?>/>

			<?php if (@$mainChannel) { ?>
				<p>Pour changer le nom de cette chaîne, vous devez changer de pseudo, le changement sera immédiatement répercuté sur votre chaîne.</p><br />
			<?php 
			}
			else {}
			?>
			<br />
			
			<label for="description">Description :</label>
			<textarea rows="8" cols="50" required="required" name="description" id="description"><?php echo @$description; ?></textarea><br />
			
			<label for="avatar">
				<img class="preview none filePreview" data-input="avatar" id="preview-avatar" src="<?php echo @$avatar; ?>">
				<i>Avatar :</i>
				<input type="file" data-text="Choisir un avatar" data-preview="preview-avatar" name="avatar" id="avatar" /><br />
			</label>
			
			<label for="background">
				<img class="preview none filePreview" data-input="background" id="preview-background" src="<?php echo @$background; ?>">
				<i>Arrière-plan :</i>
				<input type="file" data-text="Choisir un arrière-plan" data-preview="preview-background" name="background" id="background" /><br />
			</label>
			
			<?php if (@!$mainChannel) { ?>
			<label>Administrateurs :</label>
				<div id="adm">
<?php

foreach ($admins as $key => $adm) {
	$is_creator = ($adm->owner_id == $owner_id);
	$creator = ($is_creator) ? ' (Créateur)' : '';
	$delete = (!$is_creator) ? '<img class="delete-admin" src="'.IMG.'message_error_icon.png" onclick="remove_adm('.$adm->owner_id.')" />' : '';
	echo '<div id="adm_'.$adm->owner_id.'" class="channel-admin"><img class="admin-avatar" src="'.$adm->avatar.'" />'.$adm->name.$creator.$delete.'</div>';
}
?>
				</div>

			<input style="margin-bottom:0" type="text" id="add_admin" onkeyup="autocompletion(this)" placeholder="Ajouter un administrateur..." autocomplete="off" />
			<div id="autocomplete"></div>
			<?php } ?>
			
			<input type="submit" name="editChannelSubmit" value="Modifier la chaîne" />
		</form>
	</section>
</div>