<?php foreach ($messagesArray as $message): ?>
	<?php if ($message->isError()): ?>

		<div class="alert alert-danger">
			<p>
			<i class="fa fa-times"></i>
			<?php echo $message->getText(); ?></p>
		</div>

	<?php endif ?>
	<?php if ($message->isSuccess()): ?>

		<div class="alert alert-success">
		<p>
			<i class="fa fa-check"></i>
			<?php echo $message->getText(); ?></p>
		</div>
		
	<?php endif ?>
<?php endforeach ?>