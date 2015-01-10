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
		<select id="order-select" onload="" name="none" onchange="
			document.getElementById('order_field').value=this.value; 
			document.getElementById('order_way_field').value = this.options[this.selectedIndex].dataset.order;
			this.form.submit();
			">
			<option value="views" data-order="DESC" selected="selected">Les plus vues</option>
			<option value="views" data-order="ASC">Les moins vues</option>
			<option value="likes" data-order="DESC">Les vidéos ayant le plus de "+"</option>
			<option value="timestamp" data-order="DESC">Les vidéos les plus récentes</option>
			<option value="timestamp" data-order="ASC">Les vidéos les plus vielles</option>
		</select>
			
		</form>
	
<!-- Ending order select  -->