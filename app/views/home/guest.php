<div id="home-large-modal">
	<div id="backgroundLoader" class="bg-loader" data-background="<?php echo Config::getValue_('default-background'); ?>"></div>
	<section>
			<div id="boxPages" class="home">
				<div id="pageHome">
					<img src="<?php echo IMG.'icon_logo.svg'; ?>" height="30" alt="Logo DreamVids" class="logo">

					<h3>Bienvenue sur DreamVids</h3>
					<p class="inner-text">
						Let us dream ! - Nouvelle plateforme ouverte, gratuite et conviviale de partage de contenu vidéo.
					</p>

					<button onclick="document.location.href='<?php echo WEBROOT.'register'; ?>'">S'inscrire</button>
					<a onclick="document.getElementById('boxPages').className = 'login';">Se connecter</a>
				</div>
			
				<div id="pageRegister">
					<h3>S'inscrire</h3>

					<form method="post" action="<?php echo WEBROOT.'register'; ?>">
						<label for="email">Adresse email :</label>
						<input name="mail" id="email" placeholder="Adresse email" type="email"><br>
						<label for="username">Pseudo :</label>
						<input name="username" id="username" placeholder="Pseudo" type="text"><br>
						
						<label for="pass">Mot de passe :</label>
						<input name="pass" id="pass" placeholder="Mot de passe" type="password"><br>
						<label for="passConfirm">Confirmez le mot de passe :</label>
						<input name="pass-confirm" id="passConfirm" placeholder="Confirmation du mot de passe" type="password"><br>
						
						<input id="CGU" name="CGU" type="checkbox"><label for="CGU">J'accepte les <a href="<?php echo WEBROOT.'pages/tos'; ?>">conditions d'utilisations</a></label><br>
						
						<input name="submitRegister" value="S'inscrire" type="submit">
					</form>

					<a onclick="document.getElementById('boxPages').className = 'login';">Se connecter</a>
				</div>

				<div id="pageLogin">
					<h3>Se connecter</h3>

					<form method="post" action="<?php echo WEBROOT.'login'; ?>">
						<label for="username">Pseudo :</label>
						<input name="username" id="username" placeholder="Pseudo" type="text"><br>
						
						<label for="pass">Mot de passe :</label>
						<input name="pass" id="pass" placeholder="Mot de passe" type="password"><br>
						
						<input name="submitLogin" value="Se connecter" type="submit">
					</form>

					<a onclick="document.location.href='<?php echo WEBROOT.'register'; ?>'">S'inscrire</a>
				</div>
			</div>
		
		<div id="boxBest">
			<h3>Vidéos à découvrir :</h3>			
			<?php for($i = 0; $i < count($discoverVids); $i++) { ?>
				<div class="card video">
					<div class="thumbnail bg-loader" style="height: 75%;" data-background="<?php echo $discoverVids[$i]->getThumbnail(); ?>"><a href="<?php echo WEBROOT.'watch/'.$discoverVids[$i]->id; ?>" class="overlay"></a></div>
					<div class="description">
						<a href="<?php echo WEBROOT.'watch/'.$discoverVids[$i]->id; ?>"><h4><?php echo $discoverVids[$i]->title; ?></h4></a>
					</div>
				</div>
			<?php } ?>
		</div>
	</section>
</div>

<div class="content">
	<aside class="aside-channels">
		<h3 class="title">Meilleures chaînes</h3>
		<ul class="medal">
			<?php foreach ($best_chans as $chan): ?>
				<a href="<?php echo WEBROOT.'channel/'.$chan->name; ?>" class="channels">
					<span style="background-image: url(<?php echo $chan->avatar; ?>)" class="avatar"></span>
					<span class="name" href="#"><?php echo $chan->name; ?></span>
					<p class="subscribers"><b><?php echo $chan->subscribers; ?></b> Abonnés</p>
				</a>
			<?php endforeach ?>
		</ul>
	</aside>
		
	<aside class="aside-cards-list">
		<h3 class="title">Nouveautés</h3>
		
		<?php foreach ($news_vids as $vid) {
			echo Utils::getVideoCardHTML($vid);
		} ?>
	</aside>
</div>