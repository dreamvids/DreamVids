<?php foreach ($messagesArray as $message): ?>
	<?php if ($message->isError()): ?>

		<div class="message error">
			<?php echo $message->getText(); ?>
		</div>

	<?php endif ?>
	<?php if ($message->isSuccess()): ?>

		<div class="message success">
			<?php echo $message->getText(); ?>
		</div>
		
	<?php endif ?>
<?php endforeach ?>