<div class="list-group">
<?php
foreach ($flaggedVids as $vid) {
	?>

	<a href="../&<?php echo $vid->getId(); ?>" class="list-group-item">
		<h4 class="list-group-item-heading"><?php echo $vid->getTitle().' - Par '.User::getNameById($vid->getUserId()); ?></h4>
	</a>

	<?php
}

?>
</div>