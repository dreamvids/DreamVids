<div class="content">
	<section class="messages">
		<h1 class="title">Messages privés
			<button onclick="createDiscution();">Nouveau</button>
		</h1>

		<aside class="list">
			<select name="channels" id="channels">
			<?php foreach ($channels as $channel): ?>
				<option value="<?php echo $channel->id; ?>"><?php echo $channel->name; ?></option>
			<?php endforeach ?>
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
</div>