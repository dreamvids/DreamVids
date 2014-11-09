<script>
	
	var _VIDEO_ID_ = "<?php echo $video->id; ?>";

</script>

<section class="content">

	<div id="video-top-infos">
		<div id="video-top-title">
			<div id="video-top-channel">
				<img src="<?php echo $author->getAvatar(); ?>">
				<span id="hover_subscribe" data-channel="<?php echo $author->id; ?>" class="<?php echo $subscribed ? 'subscribed' : ''; ?>">
					<i><?php echo $subscribed ? 'Abonné': 'S\'abonner'; ?></i>
				</span>
				<div id="video-top-channel-infos">
					<a id="video-top-pseudo" href="<?php echo WEBROOT.'channel/'.$author->id; ?>" class="<?php echo $author->isVerified() ? 'validate' : ''; ?>">
						<?php echo $author->name; ?>
					</a>
					<hr>
					<p id="video-top-abonnes"><span class="strong"><?php echo $subscribers; ?></span> abonnés</p>
				</div>
			</div>
			<h1 class="<?php echo ($discover != 0) ? 'staff-selected' : ''; ?>"><?php echo $title; ?></h1>
		</div>
	</div>
	
	<div id="player">
		<video id="video-tag" x-webkit-airplay="allow" autobuffer preload="auto" poster="<?php echo $thumbnail; ?>">
			<source id="srcMp4" type="video/mp4" src="">
			<source id="srcWebm" type="video/webm" src="">
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
		<span id="redirect-at-end" class="video__redirect-at-end" data-message='Prochaine vidéo dans {time}' data-cancel-message="Annuler"></span>
	</div>

	<section class="video-infos">

		<div class="views"><?php echo $views; ?> vues</div>

		<hr>

		<div class="votes">

			<p class="plus<?php if($likedByUser) echo " active"; ?>" onclick="votePlus('<?php echo $video->id; ?>', this);"><?php echo $likes; ?></p>
			<m class="moins<?php if($dislikedByUser) echo " active"; ?>" onclick="voteMoins('<?php echo $video->id; ?>', this);"><?php echo $dislikes; ?></m>

		</div>

		<hr>

		<div class="description" id="video-info-description">

			<div class="inner-description">

				<?php echo nl2br($description).'<br /><br />Tags: ';
				foreach ($tags as $tag) {
					echo '<a href="search?q=%23'.$tag.'">#'.$tag.'</a> ';
				}
				?>
				
			</div>

			<div class="inner-export">

				<input id="exporter-input" onclick="this.select();" type="text" spellcheck="false" value='<iframe width="640" height="360" src="//dreamvids.fr/embed/<?php echo $video->id; ?>" allowfullscreen frameborder="0"></iframe>'>

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

			<div class="inner-playlist">

				<h3>Ajouter à une playlist :</h3>

				<div class="form no-style" id="playlist-add-form-list">
				<?php
				$playlistsCount = 0;

				foreach ($channels as $chan) {

					if (count($playlists[$chan->id]) > 0) {

						$playlistsCount ++;

						echo '<h4>'.$chan->name.'</h4>';
						
						foreach ($playlists[$chan->id] as $play) {
							$checked = (in_array($video->id, json_decode($play->videos_ids))) ? 'checked="checked"' : '';
							echo '<input type="checkbox" '.$checked.' data-playlist-id="'.$play->id.'" id="playlist-add-checkbox-'.$play->id.'"/><label for="playlist-add-checkbox-'.$play->id.'">'.$play->name.'</label><br>';
						}

					}

				}

				if (!$playlistsCount) {

					echo "Vous n'avez pas encore de playlist.<br><a href=\"" . WEBROOT . "playlists/\">Créez-en une</a>";

				}
				?>
				</div>
			
			</div>

		</div>

		<hr>

		<div class="buttons">

			<div id="share-video-block" class="share-video-block">
								
				<a href="https://twitter.com/share" class="twitter-share-button" data-text="''<?php echo (strlen($title)  > 50) ? substr($title, 0, 50).'...' : $title; ?>'' sur @DreamVids_ ! Check this out !" data-lang="fr">Tweeter</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			
			</div>

			<img title="Partager" id="share-video-icon" class="share" src="<?php echo IMG.'share.png'; ?>">
			<img title="Signaler" class="flag" src="<?php echo IMG.'flag.png'; ?>" onclick="flag('<?php echo $video->id; ?>');">
			<img title="Télécharger" class="download" src="<?php echo IMG.'download.png'; ?>" onclick="window.open('<?php echo WEBROOT.'uploads/'.$video->poster_id.'/'.$video->id.'.'.$ext; ?>');">
			<img title="Intégrer" id="embed-video-icon" class="embed-icon" src="<?php echo IMG.'embed.png'; ?>">
			<?php if(Session::isActive()) { ?>
				<img title="Ajouter à une playlist" data-vidid="<?php echo $video->id; ?>" id="add-playlist-icon" src="<?php echo IMG.'plus.png'; ?>" title="Ajouter à une playlist">
			<?php } ?>

		</div>

	</section>
<?php if ($playlist !== false) { ?>
	<section class="playlist">
		
		<div class="playlist__title">Playlist "<?php echo $playlist->name; ?>"</div>

		<img title="Gauche" id="playlist-button-scroll-left" class="playlist__button playlist__button--left" src="<?php echo IMG.'/playlist-button-left.png'; ?>">

		<div id="playlist-videos" class="playlist__videos">
<?php
$videos_ids = json_decode($playlist->videos_ids);
foreach ($videos_ids as $vid) {
	$vid = Video::find($vid);
	echo '<a href="'.WEBROOT.'playlists/'.$playlist->id.'/watch/'.$vid->id.'"><div class="playlist__video bg-loader" data-background="'.$vid->getThumbnail().'"></div></a>';
}
?>
		</div>

		<img title="Droite" id="playlist-button-scroll-right" class="playlist__button playlist__button--right" src="<?php echo IMG.'/playlist-button-right.png'; ?>">

	</section>
<?php } ?>

	<?php if (Session::isActive() && (Session::get()->isModerator() || Session::get()->isAdmin())) { ?>
		<form method="post" action="" role="form" class="moderating-commands" onsubmit="return false">
			<?php if ($video->isFlagged()) { ?>
				<button class="blue" onclick="unFlagVideo('<?php echo $video->id; ?>')">Annuler le flag</button>
			<?php } ?>

			<!--<a href="messages?to=Simpleworld"><button type="button" class="orange" name="send_message_author">Envoyer un message</button></a>-->

			<button class="red" onclick="suspendVideo('<?php echo $video->id; ?>')">Suspendre</button>
			<button class="blue" onclick="setToDiscover('<?php echo $video->id; ?>')">Mettre en avant</button>
		</form>
	<?php } ?>

</section>


<div class="content">
	<section id="comments">
		<h3 class="title">Commentaires</h3>
		<div id="response" class="comment"></div>
		<br /><br /><br />
		<?php if(Session::isActive()) { ?>
			<form method="post" action="" onsubmit="return false;">
				<input type="hidden" value="" name="parent" id="parent-comment">
				<div class="form-header-container">
					<span class="form-icn"><img src="<?php echo IMG.'/comment_icon.png'; ?>" alt="Poster un commentaire"></span>
					<img src="<?php echo Session::get()->getMainChannel()->getAvatar() ?>" alt="Votre avatar" id="add-comment-avatar">
					<div class="form">					
						<select name="channel" id="channel-selector">
							<?php foreach ($channels as $channel): ?>
								<option value="<?php echo $channel->id; ?>"><?php echo $channel->name; ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<button id="post-comment-button" data-vid-id="<?php echo $video->id; ?>" class="blue"><img src="<?php echo IMG.'/post_comment_icon.png'; ?>" alt="Ajouter le commentaire"></button>
				</div>
				<textarea id="textarea-comment" name="comment-content" rows="4" cols="10" placeholder="Commentaire"></textarea>
			</form>
		<?php } ?>

		<div id="comments-best">
			<?php
			
			function displayComments($video, $parent, $i) {
				$comments = $video->getComments($parent);
				if (empty($comments)) { ?>
					<p>Aucun commentaire à propos de cette video</p>
				<?php }
				foreach ($comments as $comment) {
					$margin = $i * 8;
				?>
					<div style="width: <?php echo 100 - $margin; ?>%; margin-left:<?php echo $margin; ?>%" class="comment" id="c-<?php echo $comment->id; ?>">
						<div class="comment-head">
							<div class="user">
								<img src="<?php echo UserChannel::find($comment->poster_id)->getAvatar(); ?>" alt="[Avatar]">
								<a href="<?php echo WEBROOT.'channel/'.$comment->poster_id; ?>"><?php echo UserChannel::getNameById($comment->poster_id); ?></a>
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
								<li onclick="reportComment('<?php echo $comment->id; ?>', this)" style="cursor:pointer">Signaler</li>
								<li onclick="document.getElementById('response').innerHTML='<b>Répondre à <?php echo UserChannel::getNameById($comment->poster_id); ?> :</b>';document.getElementById('textarea-comment').focus();document.getElementById('parent-comment').value='<?php echo $comment->id; ?>';" style="cursor:pointer">Répondre</li>
							</ul>
						</div>
					</div>
			<?php
					if (Comment::count(array('conditions' => array('parent = ?', $comment->id))) >= 1) {
						displayComments($video, $comment->id, $i+1);
					}
				}
			}
			displayComments($video, '', 0);
			?>
		</div>

	</section>


	<aside class="column-cards-list">
		<h3>Recommandations</h3>

		<?php
		foreach ($recommendations as $vid) {
			echo Utils::getVideoCardHTML($vid);
		}
		?>
	</aside>
</div>