<?php

?>

<div class="container">

	<div class="container">
		<h1 class="title"><?php echo secure($title); ?></h1>
	</div>

	
	<?php
		if(isset($session) && Watch::isModerator($session)) {
	?>

	<div id='moderatingCommands' class='container'>
		<form method='post' action='' role='form'>
			<?php if($video->isFlagged()) { ?>

			<button class='btn btn-success' name='unflag_vid'>Annuler le flag</button>			

			<?php } ?>

			<?php if($video->isSuspended()) { ?>

			<button class='btn btn-success' name='unsuspend_vid'>Ré-activer</button>	

			<?php } else { ?>

			<button class='btn btn-warning' name='suspend_vid'>Suspendre</button>

			<?php } ?>

			<button type='submit' class='btn btn-info' name='send_message_author'>Envoyer un message au créateur</button>
			<button type='submit' class='btn btn-info' name='send_message_admin'>Envoyer un message à un admin</button>
			<button type='submit' class='btn btn-danger' name='request_delete_vid'>Demander la suppression</button>
		</form>
	</div>

	<br>

	<?php
	}

	if(isset($err)) {
		echo '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>';
	}
	else {
	?>

	<div class="container" style="">
		<div id="player">
			<video x-webkit-airplay="allow" autobuffer preload="auto" poster="<?php echo ($tumbnail != '') ? secure($tumbnail) : secure($path).'.jpg'; ?>" autoplay>
				<source id="srcMp4" type="video/mp4"/>
				<source id="srcWebm" type="video/webm"/>
			</video>
			<div id="errorLoading"><p>Oops ! Ça n'a pas l'air de fonctionner.<br />Réessayez plus tard ;)</p></div> <!-- Je sais... C'est pas bien d'utiliser des id -->
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
	</div>

	<br />
	
	<div class="container">
	<table class="watch">
	<?php
	function TraduireDate($Chaine)
	{
		$DateFR = array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre");
		$DateEN = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday","January","February","March","April","May","June","July","August","September","October","November","December");
		$jour = str_replace($DateEN, $DateFR, $Chaine);
		return $jour;
	}
	?>
		<tr>
			<td>
				<div style="float:left;">
					<?php
					echo $lang['by']." <a href=\"/@".secure($author->getName() )."\">".secure($author->getName() )."</a> ".User::getDisplayableRank($author->getId() )."<br/>";
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
				
				<a href="https://twitter.com/share" class="twitter-share-button" data-text="''<?php echo (strlen($title) > 50) ? substr($title, 0, 50).'...' : $title; ?>'' sur @DreamVids_ ! Check this out !" data-lang="fr">Tweeter</a>
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
					<?php echo '<p class="description">'.bbcode(nl2br(secure($desc) ) ).'</p>'; ?>
			</td>
		</tr>
	</table> <!-- /////////////////////////////////////////////////////////////////// FIN DU TABLEAU -->
	<h2>Intégration</h2>
	AutoPlay : <label for="autoplay_y">Oui</label> <input id="autoplay_y" type="radio" name="autoplay"> <label for="autoplay_n">Non</label> <input id="autoplay_n" type="radio" name="autoplay" checked></br>
	Commencer à <input style="margin-left: 5px; margin-right: 5px; width: 50px;" id="start_min" type="number" name="start" min="0" value="0">m <input style="margin-left: 5px;width: 40px;" id="start_sec" type="number" name="start" min="0" max="60" value="0"> s</br>
	<br>
	<p> Code à utiliser sur votre page web : <br/>
	<textarea id="code" cols="50" rows="2" style="width:100%;max-width:500px;cursor:text;" onClick="this.select();" readonly class="form-control"></textarea>
	
	<h2>Commentaires</h2>
	<?php if(isset($session)) { ?>
	<script>
		window.onload = function () {
			document.getElementById("text_comment").onkeydown = function (e) {
				if (e.keyCode == 13 && e.ctrlKey) { 
					document.getElementById("submit_comment").click();
				return false;
				}
			}
		}
	</script>
		<form onsubmit="comment(<?php echo '\''.$_GET['vid'].'\', \''.secure($session->getName() ).'\''; ?>, this.text_comment.value);return false" method="post" action="">
			<div class="form-group">
				<textarea id="text_comment" class="form-control" required rows="8" cols="50" placeholder="Commentaire..."></textarea>
				
			</div>
			<div class="form-group">
				<input  id="submit_comment" class="btn btn-primary btn-success" type="submit" value="Envoyer" />
				<p>Ou Ctrl+Enter pour envoyer</p>
			</div>
		</form>
	<?php
	}
	else {
	?>
		<h3 class="text-center">
			Vous devez être connecté pour pouvoir poster un commentaire.<br />
			<small>
				<a href="login">Connexion</a><br />
				<a href="signup">Inscription</a>
			</small>
		</h3>
	<?php } ?>
	<br><br>
	<div id="new_comments"></div>
	<?php
	$comms = Watch::getComments($id);
	foreach ($comms as $comm) {
		$date = @date('d/m/Y H:i:s', $comm->getTimestamp() );
		?>

		<div class="panel panel-default" style="width: 100%;">
			<div class="panel-heading">
				<h5><a href="@<?php echo User::getNameById($comm->getAuthorId()); ?>"><?php echo User::getNameById($comm->getAuthorId()).'</a>'.User::getDisplayableRank($comm->getAuthorId()); ?> <small><?php echo $date; ?></small></h5>
			</div>
			<div class="panel-body">
				<p><?php echo bbcode(nl2br(secure($comm->getContent() ) ) ); ?></p>
			</div>
		</div>

		<?php
	}
	?>


	<?php
	}
	?>
</div>
</div>

<!-- video player body-->
	<script src="dreamplayer/js/player.js?time=<?php echo time(); ?>"></script>
	<script src="utils/videoinfo.php?vid=<?php echo secure($id); ?>"></script>
<!-- End -->

	<script type="text/javascript">
		document.getElementById("text_comment").onkeydown = function(e) {
			e.stopPropagation();
		}
	</script>
	<script>
		var vid = "<?php echo $id; ?>";
	
		var ap_y = document.getElementById('autoplay_y');
		var ap_n = document.getElementById('autoplay_n');
		ap_y.addEventListener("change", update);
		ap_n.addEventListener("change", update);
	
		
		var start_sec = document.getElementById('start_sec');
		var start_min = document.getElementById('start_min');
		start_sec.addEventListener("change", update);
		start_min.addEventListener("change", update);
	
		var code = document.getElementById('code');
	
		code.innerHTML = '<iframe width="640px" height="360px" frameborder="0" src="http://stornitz.fr/DreamVids/' + vid + '-0" allowfullscreen></iframe>';
	
		function update()
		{
			var ap = "", start = "";
			var sec = 0;
			if(start_min.value != 0) sec += +start_min.value*60;
			if(start_sec.value != 0) sec += +start_sec.value;
			if(sec > 0) start = "-S" + sec;
			if(ap_n.checked){ ap = "-0"; }
			code.innerHTML = '<iframe width="640px" height="360px" frameborder="0" src="http://stornitz.fr/DreamVids/'+ vid + start + ap + '" allowfullscreen></iframe>';
		}
	</script>
