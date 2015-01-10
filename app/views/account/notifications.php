<?php 

?>
<div class="content">

	<section class="profile">
		<h1 class="title">Espace membre</h1>

		<?php
			include VIEW.'layouts/account_menu.php';
			include VIEW.'layouts/messages.php';
		?>

		<form class="form" method="post" action="<?php echo WEBROOT.'account/notifications'; ?>" enctype="multipart/form-data">
			<input type="hidden" name="_method" value="put" />
			
			
			
			<label for="likes">Être notifier lorsque qu'une de mes vidéos reçoit un "+" : <input type="checkbox" value="1" name="like" <?php echo $like ? "checked" : "unchecked"; ?> /></label>
			<br>
			<label for="comments">Être notifier lorsque qu'une de mes vidéos est commentée : <input type="checkbox" value="1" name="comment" <?php echo $comment ? "checked" : "unchecked"; ?> /></label>
			<br>
			<label for="subscription">Être notifier lorsque que quelqu'un s'abonne à une de mes chaines : <input type="checkbox" value="1" name="subscription" <?php echo $subscription ? "checked" : "unchecked"; ?> /></label>
			<br>
			<label for="upload">Être notifier lorsque qu'une chaine dont je suis abonné upload une nouvelle vidéo : <input type="checkbox" value="1" name="upload" <?php echo $upload ? "checked" : "unchecked"; ?> /></label>
			<br>
			<label for="pm">Être notifier lorsque je recois un message privé : <input type="checkbox" value="1" name="pm" <?php echo $pm ? "checked" : "unchecked"; ?> /></label>
			<br>
			<input type="submit" name="notificationsSubmit" value="<?php echo Translator::get("common.button.save"); ?>">
		</form>
	</section>

</div>