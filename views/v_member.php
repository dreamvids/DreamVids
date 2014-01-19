<?php

?>

<div class='container'>
	<div class="container" style=''>
		<div class='border-top'></div>
			<h1><?php echo $pseudo; ?></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class='container' style=''>
<?php
if (isset($session) && $session->getId() != $member->getId() )
{
	if (in_array($member->getId(), $session->getSubscriptions() ) )
	{
?>
<button id="subscribe-<?php echo $member->getId(); ?>" class="btn btn-danger" data-subscribe="S'abonner" data-unsubscribe="Abonné" data-onmouseover="Se désabonner" data-subscribers="<?php echo $member->getSubscribers(); ?>" onclick="unsubscribe(<?php echo $member->getId(); ?>)" onmouseover="this.innerHTML=this.getAttribute('data-onmouseover')" onmouseout="this.innerHTML=this.getAttribute('data-unsubscribe')">Abonné</button>
<?php 
	}
	else
	{
?>
<button id="subscribe-<?php echo $member->getId(); ?>" class="btn btn-success" data-subscribe="S'abonner" data-unsubscribe="Abonné" data-onmouseover="Se désabonner"data-subscribers="<?php echo $member->getSubscribers(); ?>" onclick="subscribe(<?php echo $member->getId(); ?>)">S'abonner (<?php echo $member->getSubscribers(); ?>)</button>
<?php 
	}
}

			var_dump($vids);
			/*foreach ($vids as $video) {
				print_r($video)."<br>";
			}*/
?>
	</div>
</div>
