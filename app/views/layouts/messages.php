<?php foreach ($messagesArray as $message): ?>
	<?php if ($message->isError()): ?>

		<div class="message error">
			<div class="message-icn"><img src="<?php echo IMG.'message_error_icon.png'; ?>" alt="Message de succès"></div>
			<p><?php echo $message->getText(); ?></p>
		</div>

	<?php endif ?>
	<?php if ($message->isSuccess()): ?>

		<div class="message success">
			<div class="message-icn"><img src="<?php echo IMG.'message_success_icon.png'; ?>" alt="Message de succès"></div>
			<p><?php echo $message->getText(); ?></p>
		</div>
		
	<?php endif ?>
<?php endforeach ?>