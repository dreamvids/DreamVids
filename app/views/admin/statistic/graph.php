<div class="row">
	<h1>Graphiques</h1>
	<div class="col-lg-6 col-md-12">
	<h3>Evolution des uploads de vidéos par jour les 30 derniers jours :</h3>
		<div id="graph_0" data-graph_label="Videos postées"></div>
	</div>
	<div class="col-lg-6 col-md-12">
	<h3>Evolution des inscripitons par jour les 30 derniers jours :</h3>
		<div id="graph_1" data-graph_label="Utilisateurs inscris"></div>
	</div>
	<div class="col-lg-6 col-md-12">
	<h3>Evolution des uploads de vidéos les 12 derniers mois :</h3>
		<div id="graph_2" data-graph_label="Videos postées"></div>
	</div>
	<div class="col-lg-6 col-md-12">
	<h3>Evolution des inscriptions les 12 derniers mois :</h3>
		<div id="graph_3" data-graph_label="Utilisateurs inscris"></div>
	</div>		
</div>

<script type="text/javascript">
data_for_graph = [];
<?php  
	$i = 0;
	foreach ($data_for_graph as $k => $d){ 
			echo "	data_for_graph[$i] = [];\n";
			foreach ($d as $element){
				echo "		data_for_graph[$i].push({day:\"$element[0]\", count:$element[1]});\n";
			}
	$i++; } ?>
</script>