<section class="content">
	<div id="video-top-infos">
		<div id="video-top-title">
			<div id="video-top-channel">
				<img src="http://dreamvids.fr/uploads/Simpleworld/avatar.png" alt="Image de la chaîne">
				<span id="hover_subscribe" data-vid="0"><i>S'abonner</i></span>
				<div id="video-top-channel-infos">
					<a id="video-top-pseudo" href="channel" class="validate"><?php echo $author; ?></a>
					<hr>
					<p id="video-top-abonnes"><span class="strong"><?php echo $subscribers; ?></span> abonnés</p>
				</div>
			</div>
			<h1 title="<?php echo $title; ?>"><?php echo $title; ?></h1>
		</div>
	</div>
	
	<div id="player">
		<video x-webkit-airplay="allow" autobuffer preload="auto" poster="<?php echo $thumbnail != 'no_thumb' ? $thumbnail : 'http://dreamvids.fr/uploads/Simpleworld/cI1e5r.png'; ?>">
			<source id="srcMp4" type="video/mp4"/>
			<source id="srcWebm" type="video/webm"/>
		</video>
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
			<img class="share" src="img/share.png">
			<img class="flag" src="img/flag.png">
			<a href="http://yolo.com" target="_blank"><img class="download" src="img/download.png"></a>
			<img class="embed-icon" src="img/embed.png">
			<input class="embed" type="checkbox" onclick="document.getElementById('embed-input').select();">
			<input id="embed-input" value="Mega code d'embed de la mort qui tue !" onclick="this.select();" type="text" spellcheck="false">
		</div>
	</section>

	<form method="post" action="" role="form" class="moderating-commands">
		<button class="blue" name="unflag_vid">Annuler le flag</button>			
		<a href="messages?to=Simpleworld"><button type="button" class="orange" name="send_message_author">Envoyer un message</button></a>
		<button class="red" name="suspend_vid">Suspendre</button>
		<button type="submit" class="red" name="request_delete_vid">Demander la suppression</button>
	</form>

	<div class="center"><img src="http://dummyimage.com/468x60/f0f0f0/242424&text=add" width="468" height="60"></div>
</section>


<div class="content">
	<section id="comments">
		<form onsubmit="return false;" method="post" action="">
			<textarea id="text_comment" required rows="4" cols="10" placeholder="Commentaire"></textarea>
			<input id="submit_comment" type="submit" value="Envoyer">
		</form>

		<h3 class="title">Commentaires Populaires</h3>

		<div id="comments-best">
			<div class="comment">
				<div class="comment-head">
					<div class="user">
						<img src="img/avatar_user.png" alt="Avatar de Pseudo">
						<a href="channel">Pseudo</a>
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
						<a href="channel" class="validate">Lorem</a><b class="rank" data-rank="1">Admin</b>
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
						<a href="channel">Pseudo</a>
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

			<div class="comment">
				<div class="comment-head">
					<div class="user">
						<img src="img/avatar_user.png" alt="Avatar de Pseudo">
						<a href="channel">Lorem</a><b class="rank" data-rank="3">Staff</b>
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
						<a href="channel">Pseudo</a><b class="rank" data-rank="2">Modo</b>
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


	<aside class="column-cards-list">
		<h3>Recommandations</h3>
		
		<div class="card video">
			<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/simpsons/627/200/3">
				<div class="time">1:27:24</div>
				<a href="video" class="overlay"></a>
			</div>
			<div class="description">
				<a href="video"><h4>Les Simpson, le film</h4></a>
				<div>
					<span class="view">401</span>
					<a class="channel" href="channel">Home Simpson</a>
				</div>
			</div>
		</div>

		<div class="card video">
			<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/nemo/627/300/4">
				<div class="time">3:27</div>
				<a href="video" class="overlay"></a>
			</div>
			<div class="description">
				<a href="video"><h4>Nemo [Bande Annonce]</h4></a>
				<div>
					<span class="view">32 546</span>
					<a class="channel" href="channel">Nemo</a>
				</div>
			</div>
		</div>

		<div class="card video">
			<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/rio/350/200/1">
				<div class="time">2:34:53</div>
				<a href="video" class="overlay"></a>
			</div>
			<div class="description">
				<a href="video"><h4>Rio</h4></a>
				<div>
					<span class="view">1 752</span>
					<a class="channel" href="channel">Hungry Bird</a>
				</div>
			</div>
		</div>

		<div class="card video">
			<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/up/627/300/4">
				<div class="time">2:43</div>
				<a href="video" class="overlay"></a>
			</div>
			<div class="description">
				<a href="video"><h4>La Haut ! Bande Annonce</h4></a>
				<div>
					<span class="view">513</span>
					<a class="channel" href="channel">Pixar</a>
				</div>
			</div>
		</div>
	</aside>
</div>