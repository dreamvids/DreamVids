<div class="container">

	<div id="video-top-infos">
		<div id="video-top-title">
			<div id="video-top-channel">
				<a href="/@<?php echo secure($author -> getName()); ?>">
					<img src="<?php echo secure($author -> getAvatarPath()); ?>" alt="Image de la chaîne">
				</a>

				<div id="video-top-channel-infos">
					<a id="video-top-pseudo" href="/@<?php echo secure($author -> getName()); ?>">
						<?php echo secure($author -> getName()); ?>
					</a>
					<hr>
					<p id="video-top-abonnes"><span class="strong"><?php echo secure($author->getSubscribers() ); ?></span> abonné<?php echo (secure($author->getSubscribers()) > 1 ? "s": ""); ?></p>
				</div>
			</div>
			<h1 title="<?php echo secure($title); ?>" itemprop="name"><?php echo secure($title); ?></h1>
		</div>
	</div>

	<?php if(isset($err)) {
		echo '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>';
		if (isset($session) && Watch::isModerator($session)) { ?>
	
	<br>

	<form method="post" action="" role="form" class="moderating-commands" onsubmit="if(!confirm('Êtes-vous sur de vouloir effectuer cette action ?')){return false}">

		<?php if ($video->isFlagged()) { ?>

			<button class="blue" name="unflag_vid">Annuler le flag</button>			

		<?php }

		if ($video->isSuspended()) { ?>

			<button class="orange" name="unsuspend_vid">Ré-activer</button>	

		<?php } else { ?>

			<button class="orange" name="suspend_vid">Suspendre</button>

		<?php } ?>

	</form>

	<br>

	<?php } 
	}
	else {
	?>

	<div class="container" style="">
		<div id="player">
			<video x-webkit-airplay="allow" autobuffer preload="auto" poster="<?php echo ($tumbnail != '') ? secure($tumbnail) : secure($path).'.jpg'; ?>" autoplay>
				<source id="srcMp4" type="video/mp4"/>
				<source id="srcWebm" type="video/webm"/>
			</video>
			<div id="errorLoading"><p>Oops ! Ça n'a pas l'air de fonctionner.<br />Réessayez plus tard ;)</p></div>
			<div id="annotationsElement"></div>
			<span id="repeat">
				<span class="icon"></span>
			</span>
			<span id="qualitySelection" class="show"></span>
			<span id="bigPlay"></span>
			<span id="bigPause"></span>
			<div id="controls">
				<span id="progress">
					<span id="buffered"></span>
					<span id="viewed"></span>
					<span id="current"></span>
				</span>
				<span id="play-pause"></span>
				<span id="time"></span>
				<span id="annotationsButton" style="display: none"></span>
				<span id="qualityButton">SD</span>
				<span id="volume">
					<span id="barre"></span>
					<span id="icon"></span>
				</span>
				<span id="widescreen"></span>
				<span id="fullscreen"></span>
			</div>
		</div>
	
		<a href="http://dreamvids.spreadshirt.fr/"><img src="img/spreadshirt/banner2.png" alt="T-shirt et produits DreamVids sur la Boutique SpreadShirt !" class="spreadshirt-de-ouf"></a>
		<a href="http://dreamvids.spreadshirt.fr/"><img src="img/spreadshirt/banner.png" alt="T-shirt et produits DreamVids sur la Boutique SpreadShirt !" class="spreadshirt-de-ouf-media-query"></a>

	</div>

	<?php if (isset($session) && Watch::isModerator($session)) { ?>
	
	<br>

	<form method="post" action="" role="form" class="moderating-commands" onsubmit="if(!confirm('Êtes-vous sur de vouloir effectuer cette action ?')){return false}">

		<?php if ($video->isFlagged()) { ?>

			<button class="blue" name="unflag_vid">Annuler le flag</button>			

		<?php }

		if ($video->isSuspended()) { ?>

			<button class="orange" name="unsuspend_vid">Ré-activer</button>	

		<?php } else { ?>

			<button class="orange" name="suspend_vid">Suspendre</button>

		<?php } ?>
		
		<button class="blue" name="staff_select">Définir comme Sélection du staff</button>

	</form>

	<br>

	<?php } ?>
	<br /><br />
	<form method="post" action="" role="form" class="moderating-commands" onsubmit="if(!confirm('Êtes-vous sur de vouloir effectuer cette action ?')){return false}">
		
			<button class="red" name="submitFlag">Signaler la vidéo</button>
			
	</form>

	<br>
	
	<div class="container">
	<table class="watch">
		<tr>
			<td>
				<div style="float:left;">
					<?php
					echo $lang["by"]." <a href=\"/@".secure($author->getName() )."\">".secure($author->getName() )."</a> ".User::getDisplayableRank($author->getId() )."<br/>";
					echo "Le  ".TraduireDate(date('j F Y \à H\hi', $video->getTimestamp()));
					?>
				</div>
				<div style="float:right;">
				<?php
				if (isset($session) && $session->getId() != $author->getId() )
				{
					if (in_array($author->getId(), $session->getSubscriptions() ) )
					{
				?>
				<button id="subscribe-<?php echo secure($author->getId() ); ?>" class="btn btn-danger" data-subscribe="S'abonner" data-unsubscribe="Abonné" data-onmouseover="Se désabonner" data-subscribers="<?php echo secure($author->getSubscribers() ); ?>" onclick="unsubscribe(<?php echo secure($author->getId() ); ?>)" onmouseover="this.innerHTML=this.getAttribute('data-onmouseover')" onmouseout="this.innerHTML=this.getAttribute('data-unsubscribe')">Abonné</button>
				<?php 
					}
					else
					{
				?>
				<button id="subscribe-<?php echo secure($author->getId() ); ?>" class="btn btn-success" data-subscribe="S'abonner" data-unsubscribe="Abonné" data-onmouseover="Se désabonner"data-subscribers="<?php echo secure($author->getSubscribers() ); ?>" onclick="subscribe(<?php echo secure($author->getId() ); ?>)">S'abonner (<?php echo secure($author->getSubscribers() ); ?>)</button>
				<?php 
					}
				}
				?>
				</div>
			</td>
			<td>
		<?php
		$log = (isset($session) );
			?>
				<img src="img/videos/positive.png" <?php if($log){ ?>onclick="like('<?php echo secure($_GET['vid']); ?>')"<?php } ?> width="32" style="cursor:pointer" alt="Like" /> <span <?php echo @$isLiked; ?> id="like-<?php echo secure($_GET['vid']); ?>"><?php echo $likes; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<img src="img/videos/negative.png" <?php if($log){ ?>onclick="dislike('<?php echo secure($_GET['vid']); ?>')"<?php } ?> width="32" style="cursor:pointer" alt="Dislike" /> <span <?php echo @$isDisliked; ?> id="dislike-<?php echo secure($_GET['vid']); ?>"><?php echo $dislikes; ?></span>
			</td>
			<td>
			<b><?php echo $CurView; ?> vues</b>
			</td>
			<td>
				
				<a href="https://twitter.com/share" class="twitter-share-button" data-text="''<?php echo (strlen(secure($title) )  > 50) ? substr(secure($title), 0, 50).'...' : secure($title); ?>'' sur @DreamVids_ ! Check this out !" data-lang="fr">Tweeter</a>
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
				<div class="fb-share-button" data-href="http://dreamvids.fr/&<?php echo htmlspecialchars($_GET['vid']); ?>" data-type="button_count"></div><br />
			</td>
<!-- 			<td>
				<form method="post" role="form" action><input type="submit" value="Signaler" class="btn btn-danger" name="submitFlag"></form>
			</td> -->
		</tr>
		<tr>
			<td colspan="4">
					<?php echo '<strong class="title">'.$lang['desc'].' :</strong>'; ?><br/>
					<?php echo '<p class="description" id="description" style="max-height:50px">'.bbcode(nl2br(secure($desc) ) ).'</p>'; ?>
					<a href="javascript:void(0)" onclick="showNhideDesc()" id="desc-link">Afficher plus</a>
			</td>
		</tr>
		<tr>
			<td colspan="4">
<?php
echo 'Tags: '.implode(', ', $tags);
?>
			</td>
	</table> <!-- /////////////////////////////////////////////////////////////////// FIN DU TABLEAU -->
	<h2>Intégration</h2>
	AutoPlay : <label for="autoplay_y">Oui</label> <input id="autoplay_y" type="radio" name="autoplay"> <label for="autoplay_n">Non</label> <input id="autoplay_n" type="radio" name="autoplay" checked></br>
	<br>
	<p> Code à utiliser sur votre page web : <br/>
	<textarea id="code" cols="50" rows="2" style="width:100%;max-width:500px;cursor:text;" onClick="this.select();" readonly class="form-control"></textarea>
	
	<section id="comments">

		<?php if(isset($session)) { ?>

			<form onsubmit="comment(<?php echo '\''.$_GET['vid'].'\', \''.secure($session->getName() ).'\''; ?>, this.text_comment.value);return false" method="post" action="">
				<textarea id="text_comment" required rows="4" cols="10" placeholder="Commentaire..."></textarea>
				<input id="submit_comment" type="submit" value="Envoyer" />
			</form>

		<?php } else { ?>

			<h3 class="text-center">
				Vous devez être connecté pour pouvoir poster un commentaire.<br />
				<small>
					<a href="login">Connexion</a><br />
					<a href="signup">Inscription</a>
				</small>
			</h3>

		<?php } ?>

		<h3 class="title">Commentaires</h3>

		<div id="comments-best">

			<div id="new_comments"></div>

			<?php
				$comms = Watch::getComments($id);
				foreach ($comms as $comm) {

					$date = @date('d / m / Y à H:i', $comm->getTimestamp() ); ?>

					<?php 

						$author = new User($comm->getAuthorId());

					 ?>

					<div class="comment">
						<div class="comment-head">
							<div class="user">
								<img src="<?php echo secure($author -> getAvatarPath()); ?>" width="32">
								<a href="@<?php echo User::getNameById($comm->getAuthorId()); ?>"><?php echo User::getNameById($comm->getAuthorId()); ?></a>
							</div>
							<div class="date">
								<p><?php echo $date; ?></p>
							</div>
						</div>
						<div class="comment-text">
							<p><?php echo bbcode(nl2br(secure($comm -> getContent()))); ?></p>
						</div>
					</div>

			<?php } ?>

		</div>

	</section>


	<aside class="column-cards-list">
		<h3>Recommandations</h3>

		<?php
		foreach ($recommandations as $vid) {
				$nb++;
			
				$titleVid = (strlen($vid->getTitle() ) > 32) ? secure(substr($vid->getTitle(), 0, 29) ).'...' : secure($vid->getTitle() );
				$descVid = (strlen($vid->getDescription() ) > 60) ? secure(substr($vid->getDescription(), 0, 57) ).'...' : secure($vid->getDescription() );
				$userVid = (strlen(User::getNameById(secure($vid->getUserId())) ) > 23) ? secure(substr(User::getNameById(secure($vid->getUserId())), 0, 20) ).'...' : secure(User::getNameById(secure($vid->getUserId()) ));
				
				if($vid->getViews() > 1) {
					$views = $lang['views'] . ( $vid->getViews()>1 ? 's' : '' );
				}
	
				else {
					$views = $lang['views'];
				}
	
				?>
	
		    	<div class="card video">
		    		<div class="thumbnail bgLoader" data-background="<?php echo secure($vid->getTumbnail() ); ?>">
		    			<a href="&<?php echo secure($vid->getId()); ?>" class="overlay"></a>
		    		</div>
		    		<div class="description">
		    			<a href="&<?php echo secure($vid->getId()); ?>"><h4><?php echo $titleVid; ?></h4></a>
		    			<div>
		    				<span class="view"><?php echo $vid -> getViews(); ?></span>
		    				<a class="channel" href="@<?php echo User::getNameById(secure($vid->getUserId())); ?>"><?php echo $userVid; ?></a>
		    			</div>
		    		</div>
		    	</div>

		<?php
		}
		?>

	</aside>

	<?php
	}
	?>
</div>
</div>


<!-- video player body-->
	<script src="dreamplayer/js/player.js?time=<?php echo round(time() / 10); ?>"></script>
	<script src="utils/videoinfo.php?vid=<?php echo secure($id); ?>"></script>
<!-- End -->

	<script type="text/javascript">
		document.getElementById("text_comment").onkeydown = function(e) {
			e.stopPropagation();
		}
	</script>
	
	<script>
		var desc = document.getElementById("description");
		var link = document.getElementById("desc-link");
		function showNhideDesc() {
			if (desc.getAttribute('style')) {
				desc.removeAttribute('style');
				link.innerHTML = 'Afficher moins';
			}
			else {
				desc.setAttribute('style', 'max-height:50px');
				link.innerHTML = 'Afficher plus';
			}
		}
	</script>
	
	<script>
		var vid = "<?php echo $id; ?>";
	
		var ap_y = document.getElementById('autoplay_y');
		var ap_n = document.getElementById('autoplay_n');
		ap_y.addEventListener("change", update);
		ap_n.addEventListener("change", update);
		
		var code = document.getElementById('code');
	
		code.innerHTML = '<iframe width="640px" height="360px" frameborder="0" src="http://dreamvids.fr/embed/embed.php?id=' + vid + '&autoplay=false" allowfullscreen></iframe>';
	
		function update()
		{
			var ap = "";
			if(ap_y.checked){ ap = "&autoplay=true"; }
			if(ap_n.checked){ ap = "&autoplay=false"; }
			code.innerHTML = '<iframe width="640px" height="360px" frameborder="0" src="http://dreamvids.fr/embed/embed.php?id=' + vid + ap + '" allowfullscreen></iframe>';
		}
	</script>
