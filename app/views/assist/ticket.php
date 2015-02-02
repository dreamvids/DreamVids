<section class="middle">
	<h1 class="title">Assistance: Un problème ? Nous sommes là !</a></h1>

	<?php @include $messages; ?>

	<form method="post" action="<?php echo WEBROOT.'assistance'; ?>" class="form middle">
		<?php echo (!Session::isActive()) ? '<input type="email" name="email" id="email" placeholder="Votre E-Mail (optionnel) pour être avertit du déroulement de votre problème" /><br />' : ''; ?>
		<textarea name="bug" id="bug" placeholder="Donnez une description précise de votre problème"></textarea>
		<input type="submit" name="submitLogin" value="Envoyer" />
	</form>
</section>