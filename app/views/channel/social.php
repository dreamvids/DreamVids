<?php
include VIEW.'/layouts/channel_header.php';
?>
<div class="content">
	<?php if ($channelBelongsToUser) { ?>
		<form class="social-message-form" method="post" action="<?php echo WEBROOT.'posts'; ?>" onsubmit="return false;">

			<input type="hidden" name="channel" id="channel" value="<?php echo $id; ?>" />
			<div class="form-header-container">
				<span class="form-icn"><img src="<?php echo IMG.'/comment_icon.png'; ?>"></span>
				<span class="text">Poster un message</span>
				<button class="blue" id="channel-social-message-submit" data-channel-id="<?php echo $id; ?>"><img src="<?php echo IMG.'/post_comment_icon.png'; ?>" alt="Poster le message"></button>
			</div>
			<textarea id="post-content" rows="4" cols="10" placeholder="Message"></textarea>

		</form>

		<br><br>
	<?php } ?>

	<aside id="channel-posts">
		<?php foreach($posts as $post) { ?>
			<div class="channel-post"> 
				<img src="<?php echo $avatar ?>" alt="Avatar" />
				<p><span class="channel-name"><?php echo $name; ?></span> a posté un message :</p>
<?php if($channelBelongsToUser){ ?>
(<a href="<?php echo WEBROOT."posts/".$post->id."/edit"?>">Editer</a>
<a onclick="if(confirm('Supprimer ce message ?')){
			marmottajax.delete({
				url: _webroot_ + 'posts/<?php echo $post->id ?>'
				});
			this.parentElement.style.display = 'none';
			} 
			return false;
			" href="#">Supprimer</a>)				
<?php } ?>
				<div class="social-message"><?php echo $post->content; ?></div>
			</div>
		<?php } ?>
	</aside>
</div>