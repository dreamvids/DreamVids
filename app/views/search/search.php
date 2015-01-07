<div class="content">
	<aside class="aside-cards-list">
		<h3 class="title">Rechercher - "<?php echo $search; ?>" (Vous ne trouvez pas ? Faite une <a href="<?php echo  WEBROOT. 'search/advanced' ?>">recherche avancée</a>)</h3>
<!-- Starting order select  -->
		<form method="post" id="form-order" action="<?php echo WEBROOT."search/order"?>">
	
			<input type="hidden" name="_method" value="put" id="order">
			<input type="hidden" name="order" value="" id="order_field">
			<input type="hidden" name="order_way" value="" id="order_way_field">
			
			<?php 
$order="";
$order_way="";
	if(isset($filteredFields)){
		$order = @$filteredFields['order'];
		$order_way = @$filteredFields['order_way'];
		unset($filteredFields['order'], $filteredFields['order_way']);
		foreach ($filteredFields as $k => $value) {
			echo '<input type="hidden" name="'.$k.'" value="'.$value.'">'.PHP_EOL;
		}	
		
}
?>	
			
		</form>
		<select id="order-select" onload="" name="order" onchange="
			document.getElementById('order_field').value=this.value; 
			document.getElementById('order_way_field').value = this.options[this.selectedIndex].dataset.order;
			document.getElementById('form-order').submit();
			">
			<option value="views" data-order="DESC" selected="selected">Les plus vues</option>
			<option value="views" data-order="ASC">Les moins vues</option>
			<option value="likes" data-order="DESC">Les vidéos ayant le plus de "+"</option>
			<option value="timestamp" data-order="DESC">Les vidéos les plus récentes</option>
			<option value="timestamp" data-order="ASC">Les vidéos les plus vielles</option>
		</select>
<!-- Ending order select  -->
		
		
<?php
			if(!empty($channels)) { 
				foreach($channels as $chan) {

echo '
				<div class="card video"  ">
					<div class="thumbnail bg-loader" data-background-load-in-view data-background="'.$chan->getAvatar().'" style="width:50%; margin:auto;">
						<a href="'.WEBROOT.'channel/'.$chan->id.'" class="overlay"></a>
					</div>
					<div class="description">
						<a href="'.WEBROOT.'channel/'.$chan->id.'"><h4>'.$chan->name.'</h4></a>
						<div>
							<span class="view">'.number_format($chan->getAllViews()).' / ' .$chan->getSubscribersNumber().' Abonnés </span>

						</div>
					</div>
				</div>';
	
				}
				
			}
			?>
		<?php 
		if(!empty($videos)) {
			foreach ($videos as $vid) {
				echo Utils::getVideoCardHTML($vid);
			}
		} ?>
	</aside>
</div>
<?php
		if(isset($order_way, $order)){
?>
		<script type="text/javascript">
		
			var options = document.getElementById('order-select').options;
			for (var i = 0; i < options.length; i++) {
				if(options[i].dataset.order == "<?php echo $order_way; ?>" && options[i].value == "<?php echo $order; ?>"){
					options[0].selected = false;
					options[i].selected = true;
					break;
				}
			}
		</script>
<?php 
		}


