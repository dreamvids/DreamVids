<script src="<?php echo JS.'admin_panel.js'; ?>"></script>
<script>$(document).ready(function(){
    $.extend( $.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "form-control",
        "sLengthSelect": "form-control"
    });
    $('.table-to-sort').DataTable({
    	paging: false
    	
    });

});
	</script>