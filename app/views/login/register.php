<section class="middle">
	<h1 class="title">Inscription <a href="login">Connexion</a></h1>

	<?php @include $messages; ?>

	<form method="post" action="" class="middle form">
		<label for="username">Nom d'utilisateur (Sera également le nom de votre chaîne) :</label>
		<span id="avaiabilityNameMessage"></span>
		<input required="required" type="text" name="username" id="username" onchange="checkNameAvailable(this, null);" placeholder="Pseudo" value="<?php echo @$username; ?>"/><br />
		<label required="required" for="pass">Mot de passe :</label>
		<input type="password" name="pass" id="pass" placeholder="Mot de passe" vaue=""/><br />
		<label required="required" for="pass-confirm">Confirmation :</label>
		<input type="password" name="pass-confirm" id="pass-confirm" placeholder="Mot de passe" vaue=""/><br />
		<label required="required" for="mail">Adresse e-mail: </label>
		<input type="email" name="mail" id="mail" placeholder="Adresse de contact" value="<?php echo @$mail; ?>"/><br />
		<input required="required" id="CGU" name="CGU" value="CGU" type="checkbox"><label for="CGU">J'accepte les <a target="_blank" href="<?php echo WEBROOT.'pages/tos'; ?>">Conditions Générales d'Utilisations</a></label><br>
		<div class="g-recaptcha" data-sitekey="<?php echo Config::getValue_("recaptcha_public");?>"></div>
		<input type="submit" name="submitRegister" value="Valider" />
	</form>
</section>