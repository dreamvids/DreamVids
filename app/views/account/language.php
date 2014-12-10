<div class="content">

	<section class="profile">
		<h1 class="title">Espace membre</h1>

		<?php
			include VIEW.'layouts/account_menu.php';
		?>

		<form class="form" method="post" action="<?php echo WEBROOT.'account/language'; ?>">
			<input type="hidden" name="_method" value="put" />
			<select name="language" id="language">
<?php foreach ($avaiable_languages as $value => $name) { 
	$selected = Translator::getCurrentLanguageName() == $value ? "selected" : "";
	?>
				<option <?php echo $selected; ?> value="<?php echo $value; ?>"><?php echo $name; ?></option>
<?php }?>	
			</select>		
			<input type="submit" name="languageSubmit" value="<?php echo Translator::get("common.button.save"); ?>">
		</form>
	</section>

</div>