<<<<<<< HEAD
<?php if(isset($error)) { ?>
	<p style="color: #f00;"><?php echo $error ?></p>
	<br>
<?php } ?>

<?php if(isset($success)) { ?>
	<p style="color: #0f0;"><?php echo $success ?></p>
	<br>
<?php } ?>
=======
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
>>>>>>> dreamvids-2.0-dev
