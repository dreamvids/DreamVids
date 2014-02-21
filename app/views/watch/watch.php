<section id="video">
	<div id="video-top-infos">
		<div id="video-top-title">
			<div id="video-top-channel">
				<img src="<?php echo IMG.'avatar_top_nav.png'; ?>" alt="Image de la chaîne">
				<span id="hover_subscribe" data-vid="0"><i>S'abonner</i></span>
				<div id="video-top-channel-infos">
					<p id="video-top-pseudo"><?php echo $author; ?></p>
					<hr>
					<p id="video-top-abonnes"><span class="strong"><?php echo $subscribers; ?></span> abonnés</p>
				</div>
			</div>
			<h1><?php echo $title; ?></h1>
		</div>
		
	</div>
	<div id="player">
		<video x-webkit-airplay="allow" autobuffer preload="auto" poster="http://puu.sh/6Tf6f.png"></video>
		<div id="annotationsElement"></div>
		<span id="repeat">
			<span class="icon"></span>
		</span>
		<span id="qualitySelection" class="show"></span>
		<span id="waitForPlay" style="display: none;"></span>
		<span id="bigPlay"></span>
		<span id="bigPause"></span>
		<div id="controls">
			<span id="progress">
				<span id="buffered"></span>
				<span id="viewed"></span>
				<span id="current"></span>
			</span>
			<span id="play-pause" class="play"></span>
			<span id="time"></span>
			<span id="annotationsButton" style="display: none"></span>
			<span id="qualityButton">SD</span>
			<span id="volume">
				<span id="barre"></span>
				<span id="icon"></span>
			</span>
			<span id="separation"></span>
			<span id="widescreen" class="widescreen"></span>
			<span id="fullscreen" class="fullscreen"></span>
		</div>
	</div>
	<section id="videoInfos">
		<div id="videoVues"><?php echo $views; ?> vues</div>
		<hr />
		<div id="votes">
			<p <?php if($likedByUser) echo "class='active'"; ?> id="votePlus" onclick="plus('<?php echo $video->id; ?>');"><?php echo $likes; ?></p>
			<m <?php if($dislikedByUser) echo "class='active'"; ?> id="voteMoins" onclick="moins('<?php echo $video->id; ?>');"><?php echo $dislikes; ?></m>
		</div>
		<hr/>
		<div id="description">
			<div id="innerDescription">
				Ceci est une description que j'ai écrite à la main très très très longtemps pour avoir quelque chose de plus réaliste et inutile et pour pouvoir commiter quelquechose vu que je n'avais aucune idée de quoi faire.
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, laudantium, labore assumenda corporis ea dolor saepe nostrum quae molestias nobis illum accusamus magnam rerum! Velit, fuga, laborum qui ducimus nesciunt sequi necessitatibus dolores illo itaque tenetur ea cupiditate temporibus vero amet dolorem veniam possimus perferendis explicabo sed debitis delectus aliquam.
			</div>
		</div>
		<hr/>
		<div id="buttons">
			<img class="share" src="img/share.png"/>
			<img class="star" src="img/star.png"/>
			<img class="flag" src="img/flag.png"/>
		</div>
	</section>
</section>


<div id="bottom">
	<section id="comments">
		<section id="createComment">
		</section>
		<div id="comments-title">
			<h3>Commentaires Populaires</h3>
			<hr/>
		</div>

		<div id="comments-best">
			<div class="comment">
				<div class="comment-head">
					<div class="user">
						<img src="img/avatar_user.png" alt="Avatar de Pseudo">
						<p>Pseudo</p>
					</div>
					<div class="date">
						<p>12 / 06 à 8h09</p>
					</div>
				</div>
				<div class="comment-text">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet, ad, voluptate, molestias, necessitatibus ex a rerum laudantium aperiam sit recusandae perferendis quod deleniti minima consequatur dicta vitae praesentium inventore earum mollitia cumque iste totam nostrum fugit porro sed quibusdam velit! Officiis, temporibus doloribus consequuntur debitis assumenda quidem obcaecati adipisci quaerat.</p>
				</div>
				<div class="comment-notation">
					<ul>
						<li class="plus"><a href="#">+</a>141</li>
						<li class="moins"><a href="#">-</a>3</li>
					</ul>
				</div>
			</div>

			<div class="comment">
				<div class="comment-head">
					<div class="user">
						<img src="img/avatar_user.png" alt="Avatar de Pseudo">
						<p>Lorem</p>
					</div>
					<div class="date">
						<p>18 / 06 à 15h09</p>
					</div>
				</div>
				<div class="comment-text">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				</div>
				<div class="comment-notation">
					<ul>
						<li class="plus"><a href="#">+</a>25</li>
						<li class="moins"><a href="#">-</a>0</li>
					</ul>
				</div>
			</div>

			<div class="comment">
				<div class="comment-head">
					<div class="user">
						<img src="img/avatar_user.png" alt="Avatar de Pseudo">
						<p>Pseudo</p>
					</div>
					<div class="date">
						<p>12 / 06 à 8h09</p>
					</div>
				</div>
				<div class="comment-text">
					<p>Laudantium aperiam sit recusandae perferendis quod deleniti minima consequatur dicta vitae praesentium inventore earum mollitia cumque iste totam nostrum fugit porro sed quibusdam velit! Officiis, temporibus doloribus consequuntur debitis assumenda quidem obcaecati adipisci quaerat.</p>
				</div>
				<div class="comment-notation">
					<ul>
						<li class="plus"><a href="#">+</a>854</li>
						<li class="moins"><a href="#">-</a>24</li>
					</ul>
				</div>
			</div>

		</div>

	</section>


	<aside id="recomandations">
		<div id="recomandations-title">
			<h3>Recommandations</h3>
			<hr/>
		</div>
		
		<div class="recomandation">
			<div class="recomandation-thumbnail">
				<a href="#"><img src="<?php echo IMG.'recomandation_sample.png'; ?>" alt="Video title here"></a>
				<div class="recomandation-time"><p>12:05</p></div>
				<a href="#"><div class="recomandation-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
			</div>
			<div class="recomandation-description">
				<a href="#"><h4>[Découverte] GTA V : Franklin le garagiste !</h4></a>
				<div class="recomandation-bottom-description">
					<span class="recomandation-view"><img src="<?php echo IMG.'view_icon_recomandation.png'; ?>" alt="View of the video">12 530</span>
					<span class="recomandation-channel"><a href="#">Nom de la chaine</a></span>
				</div>
			</div>
		</div>
		<div class="recomandation">
			<div class="recomandation-thumbnail">
				<a href="#"><img src="<?php echo IMG.'recomandation_sample_2.png'; ?>" alt="Video title here"></a>
				<div class="recomandation-time"><p>24:34</p></div>
				<a href="#"><div class="recomandation-overlay"><img src="<?php echo IMG.'play_icon_recomandations.png'; ?>" alt="Regardez la vidéo 'Titre de la vidéo'"></div></a>
			</div>
			<div class="recomandation-description">
				<a href="#"><h4>LOL - Trevor et ses pulsions !</h4></a>
				<div class="recomandation-bottom-description">
					<span class="recomandation-view"><img src="<?php echo IMG.'view_icon_recomandation.png'; ?>" alt="View of the video">12 530</span>
					<span class="recomandation-channel"><a href="#">Nom de la chaine</a></span>
				</div>
			</div>
		</div>

	</aside>

	<div class="comment-post">
	<form method="post" action="">
		<textarea name="comment-content" rows="6" cols="50"></textarea>
		<input type="submit" name="commentSubmit" value="Poster">
	</form>
	</div>
</div>

<footer>
	<div id="inner-footer">
		footer
	</div>
</footer>