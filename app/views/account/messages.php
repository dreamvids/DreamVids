<div class="content">
	<section class="messages">
		<h1 class="title">Messages privés de
			<select name="channels" id="channels">
			<?php foreach ($channels as $channel): ?>
				<option value="<?php echo $channel->id; ?>"><?php echo $channel->name; ?></option>
			<?php endforeach ?>
			</select>
			<button onclick="createDiscution();">Nouveau</button>
		</h1>

		<aside class="list">
			<select name="sorts-dropdown" id="sorts-dropdown">
				<option value="1">Tous les messages</option>
				<option value="2">Messages non lus</option>
				<option value="3">Messages de mes abonnements</option>
				<option value="4">Mes messages favoris</option>
			</select>

			<ul id="messages-list">
				Chargement en cours...
			</ul>
		</aside>

		<aside class="message none" id="message-right-content">
			<div class="title" id="discution-infos">
				<h1>Veuillez selectionner/créer une conversation</h1>
			</div>
			<div class="create-form none" id="create-form">
				<input type="text" placeholder="Sujet" id="create-input-title">
				<label for="create-input-members">
					<p>@</p>
					<input type="text" placeholder="Membres" id="create-input-members">
				</label>

				<button id="create-submit" class="submit">Créer</button>
			</div>

			<ul class="content" id="messages-discution"></ul>

			<div class="answer">
				<textarea name="message-text" id="message-text" cols="50" rows="5" placeholder="Votre réponse..."></textarea>

				<button id="message-submit" class="submit">Répondre</button>
			</div>
		</aside>
	</section>

	<div class="center"><img src="http://dummyimage.com/468x60/f0f0f0/242424&text=ad" width="468" height="60"></div>
</div>