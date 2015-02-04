<div class="content">

	<section class="profile">
		<h1 class="title">Espace membre</h1>

		<?php
			include VIEW.'layouts/account_menu.php';
			include VIEW.'layouts/messages.php';
		?>

		<form class="form" method="post" action="<?php echo WEBROOT.'account/infos'; ?>" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="put" />
						
			<!-- <h1 style="font-size:20px">Informations de compte :</h1>
			<br /> -->
			<label for="email">Adresse email :</label>
			<input value="<?php echo $email; ?>" type="text" name="email" placeholder="Adresse email"><br />

			<label for="username">Pseudo :</label>
			<span id="avaiabilityNameMessage"></span>
			<input value="<?php echo $username; ?>" onchange="checkNameAvailable(this, '<?php echo $username; ?>')" type="text" name="username" placeholder="Pseudo"><br />
			
			<!-- <label for="language">Langue :</label>
			<select name="language">
				<option value="fr">Français</option>
				<option value="en">Anglais</option>
			</select> -->
			
			<!-- <h1 style="font-size:20px">Préférences :</h1>
			<br />
			<label for="set_likes">Être notifier lorsque qu'une de mes vidéos reçoit un "+" ou un "-" :</label>
			<input type="radio" value="1" name="set_likes" checked="checked" /> Oui
			<input type="radio" value="0" name="set_likes" /> Non -->
			
			<input type="submit" name="profileSubmit" value="<?php echo Translator::get("common.button.save"); ?>">
		</form>
	</section>

</div>