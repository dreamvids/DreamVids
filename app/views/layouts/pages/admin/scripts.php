<script src="<?php echo JS.'admin_panel.js'; ?>"></script>
<script>$(document).ready(function(){  
    $('.table-to-sort').DataTable({
    	"iDisplayLength": 50
        });
});
</script>
	<script type="text/javascript" src="<?php echo ASSETS . 'admin/js/DataTableTheme.js';?>"></script>
	
	<?php if(isset($data_for_graph)){ ?>
    <script type="text/javascript">


$(function() {
	data_for_graph.forEach(function(v, i, ar){
	    Morris.Line({
	        element: 'graph_' + i,
	        data: v,
	        xkey: 'day',
	        ykeys: ['count'],
	        labels: $('#graph_' + i)[0].dataset.graph_label,
	        pointSize: 5,
	        hideHover: 'auto',
	        resize: true,
	        smooth:false,
	        resize: true
	    });
	
	});
		
	}); 
</script>
    <?php } ?>