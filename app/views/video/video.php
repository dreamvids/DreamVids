<section class="content">
	<div id="video-top-infos">
		<div id="video-top-title">
			<div id="video-top-channel">
				<img src="http://dreamvids.fr/uploads/Simpleworld/avatar.png" alt="Image de la chaîne">
				<span id="hover_subscribe" data-vid="0"><i>S'abonner</i></span>
				<div id="video-top-channel-infos">
					<a id="video-top-pseudo" href="<?php echo WEBROOT.'channel/'.$author; ?>" class="validate"><?php echo $author; ?></a>
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
		<div id="subtitlesList"></div>
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

			<span class="cast" id="chromecastplayicon"></span>

		</div>
	</div>

	<section class="video-infos">

		<div class="views"><?php echo $views; ?> vues</div>

		<hr>

		<div class="votes">

			<p class="plus<?php if($likedByUser) echo " active"; ?>" onclick="votePlus('<?php echo $video->id; ?>', this);"><?php echo $likes; ?></p>
			<m class="moins<?php if($dislikedByUser) echo " active"; ?>" onclick="voteMoins('<?php echo $video->id; ?>', this);"><?php echo $dislikes; ?></m>

		</div>

		<hr>

		<div class="description">

			<div class="inner-description">

				Ceci est une description que j'ai écrite à la main très très très longtemps pour avoir quelque chose de plus réaliste et inutile et pour pouvoir commiter quelquechose vu que je n'avais aucune idée de quoi faire.
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, laudantium, labore assumenda corporis ea dolor saepe nostrum quae molestias nobis illum accusamus magnam rerum! Velit, fuga, laborum qui ducimus nesciunt sequi necessitatibus dolores illo itaque tenetur ea cupiditate temporibus vero amet dolorem veniam possimus perferendis explicabo sed debitis delectus aliquam.
			
			</div>

		</div>

		<hr>

		<div class="buttons">

			<img class="share" src="<?php echo IMG.'share.png'; ?>">
			<img class="flag" src="<?php echo IMG.'flag.png'; ?>">
			<a href="http://yolo.com" target="_blank"><img class="download" src="<?php echo IMG.'download.png'; ?>"></a>
			<img class="embed-icon" src="<?php echo IMG.'embed.png'; ?>">
			<input class="embed" type="checkbox" onclick="document.getElementById('embed-input').select();">
			<input class="embed-input" value="Mega code d'embed de la mort qui tue !" onclick="this.select();" type="text" spellcheck="false">

		</div>

	</section>

	<form method="post" action="" role="form" class="moderating-commands">
		<button class="blue" name="unflag_vid">Annuler le flag</button>			
		<a href="messages?to=Simpleworld"><button type="button" class="orange" name="send_message_author">Envoyer un message</button></a>
		<button class="red" name="suspend_vid">Suspendre</button>
		<button type="submit" class="red" name="request_delete_vid">Demander la suppression</button>
	</form>

</section>


<div class="content">
	<section id="comments">
		<?php if(Session::isActive()): ?>
			<form method="post" action="" onsubmit="return false;">
				<label for="channels">Poster au nom de: </label>
				<select name="channsl" id="channel">
					<?php foreach ($channels as $channel): ?>
						<option value="<?php echo $channel->id; ?>"><?php echo $channel->name; ?></option>
					<?php endforeach ?>
				</select>
				<textarea id="text_comment" name="comment-content" required rows="4" cols="10" placeholder="Commentaire"></textarea>
				<button class="blue" onclick="postComment('<?php echo $video->id; ?>', document.getElementById('text_comment').value, document.getElementById('channel').value)">Envoyer</button>
			</form>
		<?php endif ?>

		<h3 class="title">Commentaires Populaires</h3>

		<div id="comments-best">
			<?php foreach ($comments as $comment): ?>
				<div class="comment">
					<div class="comment-head">
						<div class="user">
							<img src="<?php echo IMG.'avatar_user.png'; ?>" alt="Avatar de Pseudo">
							<a href="channel"><?php echo UserChannel::getNameById($comment->poster_id); ?></a>
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
							<li class="plus" id="plus-<?php echo $comment->id; ?>" onclick="likeComment('<?php echo $comment->id; ?>')">+<?php echo $comment->likes; ?></li>
							<li class="moins" id="moins-<?php echo $comment->id; ?>" onclick="dislikeComment('<?php echo $comment->id; ?>')">-<?php echo $comment->dislikes; ?></li>
						</ul>
					</div>
				</div>
			<?php endforeach ?>
		</div>

	</section>


	<aside class="column-cards-list">
		<h3>Recommandations</h3>

		<?php foreach ($recommendations as $vid): ?>
			<div class="card video">
				<div class="thumbnail bgLoader" data-background="http://lorempicsum.com/simpsons/627/200/3">
					<div class="time"><?php echo $vid->duration; ?></div>
					<a href="<?php echo WEBROOT.'watch/'.$vid->id; ?>" class="overlay"></a>
				</div>
				<div class="description">
					<a href="<?php echo WEBROOT.'watch/'.$vid->id; ?>"><h4><?php echo $vid->title; ?></h4></a>
					<div>
						<span class="view"><?php echo $vid->views; ?></span>
						<a class="channel" href="<?php echo WEBROOT.'channel/'.$vid->getAuthor()->name; ?>"><?php echo $vid->getAuthor()->name; ?></a>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	</aside>
</div>