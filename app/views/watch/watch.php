<section id="video">
	<div id="video-top-infos">
		<div id="video-top-title">
			<h1><?php echo $title; ?></h1>
			<hr/>
		</div>
		<div id="video-top-channel">
			<img src="<?php echo IMG.'avatar_top_nav.png'; ?>" alt="Image de la chaîne">
			<span id="hover_subscribe" data-vid="0"><i>S'abonner</i></span>
			<div id="video-top-channel-infos">
				<p id="video-top-pseudo"><?php echo $author; ?></p>
				<hr>
				<p id="video-top-abonnes"><span class="strong"><?php echo $subscribers; ?></span> abonnés</p>
			</div>
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
				<?php echo $description; ?>
			</div>
		</div>
		<hr/>
		<div id="buttons">
			<img class="share" src="<?php echo IMG.'share.png'; ?>"/>
			<img class="star" src="<?php echo IMG.'star.png'; ?>"/>
			<img class="flag" src="<?php echo IMG.'flag.png'; ?>"/>
		</div>
	</section>
</section>


<div id="bottom">
	<section id="comments">
		<section id="createComment">
			<div id="wysiwyg">
			    <span data-tag="bold" style="background-image: url(img/wysiwyg/1.png);"></span>
			    <span data-tag="italic" style="background-image: url(img/wysiwyg/2.png);"></span>
			    <span data-tag="underline" style="background-image: url(img/wysiwyg/3.png);"></span>
			    <span data-tag="strikeThrough" style="background-image: url(img/wysiwyg/4.png);"></span>
			    <span data-tag="createLink" style="background-image: url(img/wysiwyg/5.png);"></span>
			    <span class="button" style="background-image: url(img/wysiwyg/6.png);" onclick="ouvrir();"></span>
			    <span data-tag="undo" style="background-image: url(img/wysiwyg/7.png);"></span>
			    <div id="modal">
			        <img src="<?php echo IMG.''; ?>img/smiley/close.png" class="close" onclick="fermer();" width="30" height="30">
			        <span class="smiley" data-value="smile.png" data-tag="smiley"><img src="<?php echo IMG.''; ?>img/smiley/smile.png"></span>
			        <span class="smiley" data-value="blink.gif" data-tag="smiley"><img src="<?php echo IMG.''; ?>img/smiley/blink.gif"></span>
			        <span class="smiley" data-value="clin.png" data-tag="smiley"><img src="<?php echo IMG.''; ?>img/smiley/clin.png"></span>
			        <span class="smiley" data-value="heureux.png" data-tag="smiley"><img src="<?php echo IMG.''; ?>img/smiley/heureux.png"></span>
			        <span class="smiley" data-value="hihi.png" data-tag="smiley"><img src="<?php echo IMG.''; ?>img/smiley/hihi.png"></span>
			        <span class="smiley" data-value="huh.png" data-tag="smiley"><img src="<?php echo IMG.''; ?>img/smiley/huh.png"></span>
			        <span class="smiley" data-value="langue.png" data-tag="smiley"><img src="<?php echo IMG.''; ?>img/smiley/langue.png"></span>
			        <span class="smiley" data-value="pleure.png" data-tag="smiley"><img src="<?php echo IMG.''; ?>img/smiley/pleure.png"></span>
			        <span class="smiley" data-value="rire.gif" data-tag="smiley"><img src="<?php echo IMG.''; ?>img/smiley/rire.gif"></span>
			        <span class="smiley" data-value="siffle.png" data-tag="smiley"><img src="<?php echo IMG.''; ?>img/smiley/siffle.png"></span>
			        <span class="smiley" data-value="triste.png" data-tag="smiley"><img src="<?php echo IMG.''; ?>img/smiley/triste.png"></span>
			        <span class="smiley" data-value="unsure.gif" data-tag="smiley"><img src="<?php echo IMG.''; ?>img/smiley/unsure.gif"></span>
			    </div>
			</div>
			<div id="editor" contenteditable="true" tabindex="3" onkeyup="document.getElementById('text').value = this.innerHTML;"></div>
			<input type="hidden" name="text" id="text"/><br />
		</section>
		<div id="comments-title">
			<h3>Commentaires Populaires</h3>
			<hr/>
		</div>

		<div id="comments-best">
			<?php foreach ($comments as $comment) { ?>

			<div class="comment">
				<div class="comment-head">
					<div class="user">
						<img src="<?php echo IMG.'avatar_user.png'; ?>" alt="Avatar de Pseudo">
						<p><?php echo $this->model->getCommentAuthor($comment); ?></p>
					</div>
					<div class="date">
						<p><?php echo Utils::relative_time($comment->timestamp); ?></p>
					</div>
				</div>
				<div class="comment-text">
					<p><?php echo $comment->comment; ?></p>
				</div>
				<div class="comment-notation">
					<ul>
						<li class="plus"><a href="#">+</a><?php echo $comment->likes; ?></li>
						<li class="moins"><a href="#">-</a><?php echo $comment->dislikes; ?></li>
					</ul>
				</div>
			</div>

			<?php } ?>
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
				<div class="recomandation-time"><p>12:05</p></div>
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

	<script src="<?php echo JS.'vote.js'; ?>"></script>
	<script src="<?php echo JS.'wysiwyg.js'; ?>"></script>
	<script src="<?php echo JS.'player.js'; ?>"></script>
</div>