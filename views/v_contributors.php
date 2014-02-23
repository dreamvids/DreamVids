<div class="container">
	<div class="container">
		<div class='border-top'></div>
			<h1>Contributeurs</h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class="container">
<?php
foreach ($contributors as $cont)
{
?>
		<div class="col-lg-4">
			<h2><?php echo $cont['username']; ?></h2>
			<img src="<?php echo $cont['avatar']; ?>" class="img-circle" width="100">
			<p class="text-default">
				<?php echo $cont['description']; ?>
			</p>
			<p>
				<a class="btn btn-primary" href="<?php echo $cont['url']; ?>" target="_blank" role="button">Suivez-le</a>
			</p>
		</div>
<?php
}
?>
	</div>
</div>