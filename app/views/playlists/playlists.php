<h1 class="title">Playlists</h1>
<section class="middle">
	<?php @include $messages; ?>
	<form method="post" action="" class="middle form">
		<label for="name">Nouvelle Playlist :</label>
		<input type="text" placeholder="Nom" id="name" name="name" />
		<select name="channel_id">
		<?php
			foreach ($channels as $chan) {
				echo '<option value="'.$chan->id.'">'.$chan->name.'</option>';
			}
		?>
		</select>
		<input type="hidden" name="channel_id" value="c_8CG5" />
		<input type="submit" class="blue" value="Créer" />
	</form>
</section>

<div class="content">
	<aside class="aside-cards-list">
<?php
foreach ($channels as $chan) {
	echo '<h3 class="title">'.$chan->name.'</h3>';
	foreach ($playlists[$chan->id] as $play) {
	?>
		<div class="card video long">
			<div class="thumbnail bg-loader" data-background="<?php echo Config::getValue_('default-thumbnail'); ?>">
				<div class="time"><?php echo count(json_decode($play->videos_ids)); ?> Vidéos</div>
				<a href="#" class="overlay"></a>
			</div>
			<div class="description">
				<a href="#"><h4><?php echo $play->name; ?></h4></a>
				<span class="buttons">
					<button onclick="erasePlaylist('<?php echo $play->id; ?>')">Supprimer</button>
				</span>
			</div>
		</div>
	<?php
	}
}
?>
	</aside>
</div>