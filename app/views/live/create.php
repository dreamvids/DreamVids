<div class="content">

	<?php if(@!$accessGranted) { ?>
		
		<section class="middle">
			<h1 class="title" id="live-creation-title">Lancer un live</h1>
		</section>

		<div class="form middle">

			<label for="channel">Veuillez choisir votre chaîne :</label>
			<select name="channels" id="channel">
				<?php foreach ($channels as $channel): ?>
					<?php if(!$channel->hasLiveAccess()) { ?>
						<option value="<?php echo $channel->id; ?>"><?php echo $channel->name; ?></option>
					<?php } ?>
				<?php endforeach ?>
			</select>
			
			<div id="live-form-button">
				<button class="btn btn--raised btn--blue" onclick="createLive(document.getElementById('channel').value)">Commencer un live</button>
			</div>

		</div>

		<p id="live-key" class="live-creation-paragraph"></p>

	<?php } else { ?>

		<h1 class="title" id="live-creation-title">Vos lives</h1>

		<div class="form middle">

			<label for="channel">Lancer un nouveau live sur la chaîne</label>
			<select name="channels" id="channel">
				<?php foreach ($channels as $channel): ?>
					<?php if(!$channel->hasLiveAccess()) { ?>
						<option value="<?php echo $channel->id; ?>"><?php echo $channel->name; ?></option>
					<?php } ?>
				<?php endforeach ?>
			</select>
			
			<div id="live-form-button">
				<button class="btn btn--raised btn--blue" onclick="createLive(document.getElementById('channel').value)">Commencer un live</button>
			</div>

		</div>

		<?php foreach($liveAccesses as $access) { ?>
			<p id="live-key" class="live-creation-paragraph">

				Accès au live sur la chaîne <?php echo $access->getChannel()->name; ?><br>
				
				<ul>
					<li>Clé de live : <?php echo $access->getChannel()->name.'?key='.$access->key; ?><br></li>
					<li>Lien du live : <a href="<?php echo WEBROOT.'lives/'.$access->getChannel()->name; ?>">http://dreamvids.fr/lives/<?php echo $access->getChannel()->name; ?></a></li>
					<button class="btn btn--raised btn--red" onclick="revokeLive(<?php echo $access->id; ?>)">Révoquer l'accès live</button>
				</ul>

				<br/><br/>

			</p>
		<?php } ?>

	<?php } ?>

</div>
