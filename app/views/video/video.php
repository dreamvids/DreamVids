<script>
	
	var _VIDEO_ID_ = "llgZw6-0";

</script>

<section class="content">
	<div id="video-top-infos">
		<div id="video-top-title">
			<div id="video-top-channel">
				<img src="<?php echo $author->getAvatar(); ?>">
				<span id="hover_subscribe" data-channel="<?php echo $author->id; ?>" class="<?php echo $subscribed ? 'subscribed' : ''; ?>">
					<i><?php echo $subscribed ? 'Se desabonner': 'S\'abonner'; ?></i>
				</span>
				<div id="video-top-channel-infos">
					<a id="video-top-pseudo" href="<?php echo WEBROOT.'channel/'.$author->name; ?>" class="<?php echo $author->isVerified() ? 'validate' : ''; ?>">
						<?php echo $author->name; ?>
					</a>
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

		<div class="description export" id="video-info-description">

			<div class="inner-description">

				<?php echo $description; ?>
			
			</div>

			<div class="inner-export">

				<input id="exporter-input" type="text" spellcheck="false" value='<iframe width="640" height="360" src="//dreamvids.fr/embed/llgZw6-0" allowfullscreen frameborder="0"></iframe>'>

				<div class="form no-style">
					
					<select id="exporter-quality">
						<option value="0">1280x720</option>
						<option value="1" selected>640x360</option>
						<option value="2">320x180</option>
					</select>

					<input type="checkbox" checked id="exporter-autoplay"/><label for="exporter-autoplay">Autoplay</label><br>
					
					<br>
					<label for="exporter-time-checkbox">Démarrer à</label>
					<input type="checkbox" class="for-checkbox-dependence" id="exporter-time-checkbox"/>

					<label for="exporter-time-input" class="checkbox-dependence">
						<input type="time" id="exporter-time-input" value="00:00" min="00:00">
					</label>

				</div>
			
			</div>

		</div>

		<hr>

		<div class="buttons">

			<div id="share-video-block" class="share-video-block">
								
				<a href="https://twitter.com/share" class="twitter-share-button" data-text="''<?php echo (strlen($title)  > 50) ? substr($title, 0, 50).'...' : $title; ?>'' sur @DreamVids_ ! Check this out !" data-lang="fr">Tweeter</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
				
				<div id="fb-root"></div>

				<script>

					(function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) return;
						js = d.createElement(s); js.id = id;
						js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1";
						fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));

				</script>

				<div class="fb-share-button" data-href="http://dreamvids.fr/&<?php echo $video->id; ?>" data-type="button_count"></div>
			
			</div>

			<img id="share-video-icon" class="share" src="<?php echo IMG.'share.png'; ?>">
			<img class="flag" src="<?php echo IMG.'flag.png'; ?>" onclick="flag('<?php echo $video->id; ?>');">
			<img class="download" src="<?php echo IMG.'download.png'; ?>" onclick="window.open('<?php echo $video->url; ?>');">
			<img id="embed-video-icon" class="embed-icon" src="<?php echo IMG.'embed.png'; ?>">

		</div>

	</section>

	<?php if (Session::isActive() && (Session::get()->isModerator() || Session::get()->isAdmin())): ?>
		<form method="post" action="" role="form" class="moderating-commands" onsubmit="return false">
			<?php if ($video->isFlagged()) { ?>
				<button class="blue" onclick="unFlagVideo('<?php echo $video->id; ?>')">Annuler le flag</button>
			<?php } ?>

			<!--<a href="messages?to=Simpleworld"><button type="button" class="orange" name="send_message_author">Envoyer un message</button></a>-->

			<button class="red" onclick="suspendVideo('<?php echo $video->id; ?>')">Suspendre</button>
			<button class="red" onclick="alert('Pas encore implémenté')">Demander la suppression</button>
		</form>
	<?php endif ?>

</section>


<div class="content">
	<section id="comments">
		<h3 class="title">Commentaires</h3>

		<?php if(Session::isActive()): ?>
			<form method="post" action="" onsubmit="return false;">
				<div class="form-header-container">
					<span class="form-icn"><img src="<?php echo IMG.'/comment_icon.png'; ?>" alt="Poster un commentaire"></span>
					<img src="<?php echo Session::get()->getMainChannel()->getAvatar() ?>" alt="Votre avatar" id="add-comment-avatar">
					<div class="form">					
						<select name="channsl" id="channel">
							<?php foreach ($channels as $channel): ?>
								<option value="<?php echo $channel->id; ?>"><?php echo $channel->name; ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<button class="blue" onclick="postComment('<?php echo $video->id; ?>', document.getElementById('text_comment').value, document.getElementById('channel').value)"><img src="<?php echo IMG.'/post_comment_icon.png'; ?>" alt="Ajouter le commentaire"></button>
				</div>
				<textarea id="text_comment" name="comment-content" required rows="4" cols="10" placeholder="Commentaire"></textarea>
			</form>
		<?php endif ?>

		<div id="comments-best">
			<?php if (empty($comments)): ?>
				<p>Aucun commentaire à propos de cette video</p>
			<?php endif ?>
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
							<li onclick="reportComment('<?php echo $comment->id; ?>', this)">Signaler</li>
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