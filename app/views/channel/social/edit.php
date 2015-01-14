<div class="content">
	<section class="">
		<h1 class="title">Modifier un post <a href="<?php echo WEBROOT . "channel/" . $channel_id . "/social" ?>" >Revenir à la chaîne</a></h1>
		<?php include VIEW.'layouts/messages.php'; ?>
		<form  class="form" method="post" action="<?php echo WEBROOT.'posts/'.$post_id ?>">
			<input type="hidden" name="_method" value="put">
			
			<label for="message">Contenu du message :</label>
			<textarea rows="8" cols="50" required="required" name="post_content" id="description"><?php echo $post_content; ?></textarea><br>
						
			<input type="submit" name="post-message-submit" value="Modifier le message">
		</form>
	</section>
</div>