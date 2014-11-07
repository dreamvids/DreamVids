<div class="content">

	<?php if(@!$accessGranted) { ?>
		
		<section class="middle">
			<h1 class="title" id="live-creation-title">Lancer un live</h1>
		</section>

		<div class="form middle">

			<label for="channel">Veuillez choisir votre chaîne :</label>
			<select name="channels" id="channel">
				<?php foreach ($channels as $channel): ?>
					<option value="<?php echo $channel->id; ?>"><?php echo $channel->name; ?></option>
				<?php endforeach ?>
			</select>
			
			<div id="live-form-button">
				<button class="btn btn--raised btn--blue" onclick="createLive(document.getElementById('channel').value)">Commencer un live</button>
			</div>

		</div>

		<p id="live-key" class="live-creation-paragraph"></p>

	<?php } else { ?>

		<section class="middle">
			<h1 class="title" id="live-creation-title">Votre live</h1>
		</section>

		<div class="form middle">

			<label for="channel">Veuillez choisir votre chaîne :</label>
			<select name="channels" id="channel" disabled>
				<?php foreach ($channels as $channel): ?>
					<option value="<?php echo $channel->id; ?>" <?php if ($channel->id == $liveChannel->id) { echo "selected"; } ?>><?php echo $channel->name; ?></option>
				<?php endforeach ?>
			</select>
			
			<div id="live-form-button">
				<button class="btn btn--raised btn--red" onclick="revokeLive('<?php echo $access->id; ?>')">Révoquer l'accès live</button>
			</div>

		</div>

		<p id="live-key" class="live-creation-paragraph">
			
			Accès a votre live disponible (chaîne: <?php echo $liveChannel->name; ?>)<br><br>
			Clé de live : <?php echo $access->key; ?><br>
			Lien du live : <a href="<?php echo WEBROOT.'lives/'.$liveChannel->name; ?>">http://dreamvids.fr/lives/<?php echo $liveChannel->name; ?></a>

		</p>

	<?php } ?>

</div>