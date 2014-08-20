<section class="middle">
	<h1 class="title">Mot de passe oublié</a></h1>

	<?php @include $messages; ?>

	<form method="post" action="<?php echo WEBROOT.'password'; ?>" class="form middle">
		<label for="email">Votre adresse E-Mail :</label>
		<input type="email" name="email" id="email" placeholder="Adresse E-Mail" value="<?php echo @$username; ?>"/><br />
		OU<br /><br />
		<label for="pseudo">Votre pseudo :</label>
		<input type="text" name="pseudo" id="pseudo" placeholder="Pseudonyme" vaue=""/><br />
		<input type="submit" name="submitLogin" value="Générer un mot de passe" />
	</form>
</section>