<div id="homeLargeModal">
	<section>
		<div id="boxPages" class="home">
			<div id="pageHome">
				<img src="<?php echo IMG.'icon_logo.png' ?>" alt="Logo DreamVids" class="logo"/>

				<h3>Bienvenue sur DreamVids</h3>
				<p class="inner-text">
					Let us dream ! - Nouvelle plateforme ouverte, gratuite et conviviale de partage de contenu vidéo.
				</p>

				<button onclick="document.getElementById('boxPages').className = 'register';">S'inscrire</button>
				<a onclick="document.getElementById('boxPages').className = 'login';">Se connecter</a>
			</div>
	
			<div id="pageRegister">
				<h3>S'inscrire</h3>

				<form method="post" action="">
					<label for="email">Adresse email :</label>
					<input type="email" name="email" id="email" placeholder="Adresse email"/><br />
					<label for="username">Pseudo :</label>
					<input type="text" name="username" id="username" placeholder="Pseudo"/><br />
					
					<label for="pass">Mot de passe :</label>
					<input type="password" name="pass" id="pass" placeholder="Mot de passe"/><br />
					<label for="passConfirm">Confirmez le mot de passe :</label>
					<input type="password" name="passConfirm" id="passConfirm" placeholder="Confirmation du mot de passe"/><br />
					
					<input type="checkbox" id="CGU" name="CGU"/><label for="CGU">J'accepte les conditions d'utilisations</label><br />
					
					<input type="submit" name="submit" value="S'inscrire"/>
				</form>

				<a onclick="document.getElementById('boxPages').className = 'login';">Se connecter</a>
			</div>

			<div id="pageLogin">
				<h3>Se connecter</h3>

				<form method="post" action="">
					<label for="username">Pseudo :</label>
					<input type="text" name="username" id="username" placeholder="Pseudo"/><br />
					
					<label for="pass">Mot de passe :</label>
					<input type="password" name="pass" id="pass" placeholder="Mot de passe"/><br />
					
					<input type="submit" name="submit" value="Se connecter"/>
				</form>

				<a onclick="document.getElementById('boxPages').className = 'register';">S'inscrire</a>
			</div>
		</div>

		<div id="boxBest">
			<h3>Meilleures vidéos :</h3>
			<ul id="sliderList" class="slide1">
				<li onclick="slideTo(1);"></li>
				<li onclick="slideTo(2);"></li>
				<li onclick="slideTo(3);"></li>
			</ul>

			<section id="slider" class="slide1">

				<div id="slide">
					<div class="video">
						<div class="video-thumbnail" style="background-image: url(http://lorempicsum.com/rio/350/200/1)">
							<a href="video"><div class="video-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
						</div>
						<div class="video-description"><a href="video"><h4>Lorem Ipsum dolorem</h4></a></div>
					</div>

					<div class="video">
						<div class="video-thumbnail" style="background-image: url(http://lorempicsum.com/rio/627/300/4)">
							<a href="video"><div class="video-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
						</div>
						<div class="video-description"><a href="video"><h4>Rio !</h4></a></div>
					</div>
				</div>

				<div id="slide">
					<div class="video">
						<div class="video-thumbnail" style="background-image: url(http://lorempicsum.com/futurama/350/200/1)">
							<a href="video"><div class="video-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
						</div>
						<div class="video-description"><a href="video"><h4>Lorem Ipsum dolorem</h4></a></div>
					</div>

					<div class="video">
						<div class="video-thumbnail" style="background-image: url(http://lorempicsum.com/futurama/627/300/4)">
							<a href="video"><div class="video-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
						</div>
						<div class="video-description"><a href="video"><h4>Futurama !</h4></a></div>
					</div>
				</div>

				<div id="slide">
					<div class="video">
						<div class="video-thumbnail" style="background-image: url(http://lorempicsum.com/simpsons/350/200/1)">
							<a href="video"><div class="video-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
						</div>
						<div class="video-description"><a href="video"><h4>Lorem Ipsum dolorem</h4></a></div>
					</div>

					<div class="video">
						<div class="video-thumbnail" style="background-image: url(http://lorempicsum.com/simpsons/627/300/4)">
							<a href="video"><div class="video-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
						</div>
						<div class="video-description"><a href="video"><h4>The Simpsons !</h4></a></div>
					</div>
				</div>

			</section>
		</div>
	</section>
</div>

<div id="bottom">
	<section id="best-channels">
		<div id="best-channels-title">
			<h3>Meilleures chaînes</h3>
		</div>

		<ul>
			<a href="#" class="channels">
				<span style="background-image: url(http://lorempicsum.com/simpsons/255/200/2)" class="channels-avatar"></span>
				<p href="#" class="channels-name">Dreameur</p>
				<p class="channels-subscribers"><b>12 835</b> Abonnés</p>
			</a>
			<a href="#" class="channels">
				<span style="background-image: url(http://lorempicsum.com/rio/255/200/2)" class="channels-avatar"></span>
				<p href="#" class="channels-name">YoloVids</p>
				<p class="channels-subscribers"><b>11 208</b> Abonnés</p>
			</a>
			<a href="#" class="channels">
				<span style="background-image: url(http://lorempicsum.com/nemo/255/200/2)" class="channels-avatar"></span>
				<p href="#" class="channels-name">Kikoo 2000</p>
				<p class="channels-subscribers"><b>9 725</b> Abonnés</p>
			</a>
			<a href="#" class="channels">
				<span style="background-image: url(http://lorempicsum.com/futurama/350/200/6)" class="channels-avatar"></span>
				<p href="#" class="channels-name">Futurameur</p>
				<p class="channels-subscribers"><b>5 214</b> Abonnés</p>
			</a>
			<a href="#" class="channels">
				<span style="background-image: url(http://lorempicsum.com/up/255/200/2)" class="channels-avatar"></span>
				<p href="#" class="channels-name">UpUpUp</p>
				<p class="channels-subscribers"><b>2 804</b> Abonnés</p>
			</a>
			<a href="#" class="channels">
				<span style="background-image: url(http://lorempicsum.com/simpsons/255/200/5)" class="channels-avatar"></span>
				<p href="#" class="channels-name">Homer Simpson</p>
				<p class="channels-subscribers"><b>1 127</b> Abonnés</p>
			</a>
			<a href="#" class="channels">
				<span style="background-image: url(http://lorempicsum.com/nemo/350/200/1)" class="channels-avatar"></span>
				<p href="#" class="channels-name">Dori</p>
				<p class="channels-subscribers"><b>546</b> Abonnés</p>
			</a>
			<a href="#" class="channels">
				<span style="background-image: url(http://static-2.nexusmods.com/15/mods/110/images/50622-1-1391287636.jpeg)" class="channels-avatar"></span>
				<p href="#" class="channels-name" style="font-family: 'Comic Sans MS'; font-size: 12px">Wow ! Much doge</p>
				<p class="channels-subscribers" style="font-family: 'Comic Sans MS'; font-size: 12px"><b>248</b> Abonnés</p>
			</a>
		</ul>
	</section>

	<aside id="home-discover">
		<div id="home-discover-title">
			<h3>Vidéos à découvrir</h3>
		</div>
		
		<div class="video">
			<div class="video-thumbnail" style="background-image: url(http://lorempicsum.com/up/350/200/1)">
				<div class="video-time"><p>12:05</p></div>
				<a href="video"><div class="video-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
			</div>
			<div class="video-description">
				<a href="video"><h4>Up !</h4></a>
				<div class="video-bottom-description">
					<span class="video-view"><img src="img/view_icon_recomandation.png" alt="View of the video">12 530</span>
					<span class="video-channel"><a href="#">Papy</a></span>
				</div>
			</div>
		</div>
		<div class="video">
			<div class="video-thumbnail" style="background-image: url(http://lorempicsum.com/nemo/350/200/1)">
				<div class="video-time"><p>16:17</p></div>
				<a href="video"><div class="video-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
			</div>
			<div class="video-description">
				<a href="video"><h4>Nemo</h4></a>
				<div class="video-bottom-description">
					<span class="video-view"><img src="img/view_icon_recomandation.png" alt="View of the video">10 576</span>
					<span class="video-channel"><a href="#">Dori</a></span>
				</div>
			</div>
		</div>
		<div class="video">
			<div class="video-thumbnail" style="background-image: url(http://lorempicsum.com/simpsons/627/200/3)">
				<div class="video-time"><p>1:27:24</p></div>
				<a href="video"><div class="video-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
			</div>
			<div class="video-description">
				<a href="video"><h4>Les Simpson, le film</h4></a>
				<div class="video-bottom-description">
					<span class="video-view"><img src="img/view_icon_recomandation.png" alt="View of the video">401</span>
					<span class="video-channel"><a href="#">Home Simpson</a></span>
				</div>
			</div>
		</div>
		<div class="video">
			<div class="video-thumbnail" style="background-image: url(http://lorempicsum.com/nemo/627/300/4)">
				<div class="video-time"><p>3:27</p></div>
				<a href="video"><div class="video-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
			</div>
			<div class="video-description">
				<a href="video"><h4>Nemo [Bande Annonce]</h4></a>
				<div class="video-bottom-description">
					<span class="video-view"><img src="img/view_icon_recomandation.png" alt="View of the video">32 546</span>
					<span class="video-channel"><a href="#">Nemo</a></span>
				</div>
			</div>
		</div>
		<div class="video">
			<div class="video-thumbnail" style="background-image: url(http://lorempicsum.com/rio/350/200/1)">
				<div class="video-time"><p>2:34:53</p></div>
				<a href="video"><div class="video-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
			</div>
			<div class="video-description">
				<a href="video"><h4>Rio</h4></a>
				<div class="video-bottom-description">
					<span class="video-view"><img src="img/view_icon_recomandation.png" alt="View of the video">1 752</span>
					<span class="video-channel"><a href="#">Hungry Bird</a></span>
				</div>
			</div>
		</div>
		<div class="video">
			<div class="video-thumbnail" style="background-image: url(http://lorempicsum.com/up/627/300/4)">
				<div class="video-time"><p>2:43</p></div>
				<a href="video"><div class="video-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
			</div>
			<div class="video-description">
				<a href="video"><h4>La Haut ! Bande Annonce</h4></a>
				<div class="video-bottom-description">
					<span class="video-view"><img src="img/view_icon_recomandation.png" alt="View of the video">513</span>
					<span class="video-channel"><a href="#">Pixar</a></span>
				</div>
			</div>
		</div>

	</aside>
</div>

<script src="<?php echo JS.'slider.js'; ?>"></script>