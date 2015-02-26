<div class="content">
		<h1 class="title" id="live-creation-title">Vos lives</h1>

		<form class="form middle" action="" method="post">

			<label for="channel">Créer un nouvel accès live sur la chaîne</label>
			<select name="channel-id" id="channel">
				<?php foreach ($channels as $channel): ?>
					<?php if(!$channel->hasLiveAccess()) { ?>
						<option value="<?php echo $channel->id; ?>"><?php echo $channel->name; ?></option>
					<?php } ?>
				<?php endforeach ?>
			</select>
			
			<div id="live-form-button">
				<input type="submit" class="btn--raised btn--blue" value="Créer l'accès" />
			</div>

		</form>

		<?php
		if (@$accessGranted) {
			foreach($liveAccesses as $access) { ?>
			<p id="live-key" class="live-creation-paragraph">

				Accès au live sur la chaîne <?php echo $access->getChannel()->name; ?><br /><br />
				
				<ul>
					<li>- "Clé de live" ou "Nom de live" : <b><?php echo $access->getChannel()->name.'?key='.$access->key; ?></b></li>
					<li>- URL de Streaming: <b>rtmp://dreamvids.fr/stream</b>
					<li>- Lien du live : <b><a href="<?php echo WEBROOT.'lives/'.$access->getChannel()->name; ?>">http://dreamvids.fr/lives/<?php echo $access->getChannel()->name; ?></a></b></li>
					<button class="btn btn--raised btn--red" onclick="revokeLive(<?php echo $access->id; ?>)">Révoquer l'accès live</button>
				</ul>

				<br/><br/>

			</p>
		<?php	} 
			}?>

	<h1 class="title">Quelques explications à propos des lives</h1>
	<p>
		Sur DreamVids, les "accès live" permettent d'ouvrir l'accès au live stream sur une chaine donnée.
		Une fois l'accès créé, il n'est plus nécessaire de le révoquer, vous pourrez garder toujours les
		mêmes paramètres, cela vous évite de reconfigurer votre logiciel de livestream à chaque fois !
	</p>
	<br />
	<p>
		Comme DreamVids propose des chaines multi-utilisateurs, l'accès aux lives de celles-ci est régulé:
		Un seul admin peut avoir accès au live en même temps. Si vous souhaiter "transférer" l'accès live à un
		autre admin de votre chaine, il existe deux méthodes:
	</p>
	<br />
	<ul>
		<li>1. Vous pouvez simplement copier la "clé" ou le "nom" du live (la partie qui ressemble à
		NomChaine?key=ad6526bf6e56a...) et la donner à l'autre admin</li>
		<br />
		<li>2. Si vous n'êtes pas sur ou que vous ne comprenez pas la première technique, vous pouvez
		simplement cliquer sur "Révoquer l'accès" pour la chaine voulue et le second admin n'aura qu'à créer un
		nouvel accès depuis son propre compte. <b>ATTENTION TOUTEFOIS: Révoquer l'accès à un live est synonyme
		de reconfiguration de votre logiciel (xSplit, OBS ou autre) car la clé change entre deux créations
		d'accès !</b>
	</ul>
	<br />
	<p>
		La "clé" ou le "nom" de votre live est la seule barrière, la seule donnée permettant de vous identifier.
		Si quelqu'un d'extérieur à votre chaine arrive à se procurer la clé (par exemple parce qu'elle aura
		circulée de main en main), il pourra streamer sur votre chaine, et il vous faudra révoquer l'accès et
		en créer un nouveau pour réparer le soucis. Mais n'oubliez pas, vous devrez revoir la config de votre
		logiciel ;) Soyez donc extrêmement prudent avec les accès à vos lives, et ne les donnez pas à
		n'importe qui !
	</p>
</div>
