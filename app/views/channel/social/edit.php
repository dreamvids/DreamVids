<div class="content">

	<section class="">
		<h1 class="title">Modifier un post</h1>
		
		<form  class="form" method="post" action="<?php echo WEBROOT.'posts/'.$post_id ?>">
			<input type="hidden" name="_method" value="put">
			
			<label for="message">Contenu du message :</label>
			<textarea rows="8" cols="50" required="required" name="message" id="description"><?php echo $message; ?></textarea><br>
						
			<input type="submit" name="post-message-submit" value="Modifier le message">
		</form>
	</section>
</div>