<div class="content">
	<h1 class="title">Lancer un live</h1>

	<?php if(@!$accessGranted) { ?>
		<select name="channels" id="channel">
			<?php foreach ($channels as $channel): ?>
				<option value="<?php echo $channel->id; ?>"><?php echo $channel->name; ?></option>
			<?php endforeach ?>
		</select>
		<br />

		<button class="btn btn--raised btn--blue" onclick="createLive(document.getElementById('channel').value)">Commencer un live</button>

		<p id="live-key"></p>
	<?php } else { ?>
		<p>Accès a votre live disponible (chaîne: <?php echo $liveChannel->name; ?>)</p>
		<p>Clé de live: <?php echo $access->key; ?></p>

		<br />

		<div id="access">
			<button class="btn btn--raised btn--red" onclick="revokeLive('<?php echo $access->id; ?>')">Révoquer l'accès live</button>
		</div>
	<?php } ?>
</div>