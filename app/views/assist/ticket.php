<section class="middle">
	<h1 class="title">Assistance</a></h1>

	<?php @include $messages; ?>

	<form method="post" action="<?php echo WEBROOT.'assistance'; ?>" class="form middle">
		<input type="hidden" name="url" value="<?php echo @$_SERVER['REFERER']; ?>" />
		<textarea name="bug" id="bug" placeholder="Donnez une description précise de votre problème"></textarea>
		<input type="submit" name="submitLogin" value="Envoyer" />
	</form>
</section>