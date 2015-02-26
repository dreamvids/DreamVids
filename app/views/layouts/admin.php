<!DOCTYPE html>
<html lang="fr">

<head>
	<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/meta.php') : include(VIEW.'layouts/pages/default/meta.php'); ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo IMG.'favicon_admin.png'; ?>" />

    <title>Administration - DreamVids</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo ASSETS.'admin/'; ?>bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo ASSETS.'admin/'; ?>bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo ASSETS.'admin/'; ?>dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo ASSETS.'admin/'; ?>dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo ASSETS.'admin/'; ?>bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo ASSETS.'admin/'; ?>bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script type="text/javascript"> var _webroot_ = "<?php echo WEBROOT; ?>";</script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
<?php include VIEW."layouts/admin_menu.php"; ?>

        <div id="page-wrapper">
			<?php include($content); ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	
	
	<!-- jQuery -->
    <script src="<?php echo ASSETS.'admin/'; ?>bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo ASSETS.'admin/'; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo ASSETS.'admin/'; ?>bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="<?php echo ASSETS.'admin/'; ?>bower_components/raphael/raphael-min.js"></script>
    <script src="<?php echo ASSETS.'admin/'; ?>bower_components/morrisjs/morris.min.js"></script>
    <script src="<?php echo ASSETS.'admin/'; ?>bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <!-- <script src="<?php echo ASSETS.'admin/'; ?>js/morris-data.js"></script> -->

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo ASSETS.'admin/'; ?>dist/js/sb-admin-2.js"></script>
<?php if(isset($video_graph_data)){ ?>
    <script type="text/javascript">


$(function() {
	<?php 
	$length = count($video_graph_data);
	$i = 0;
	echo "data_ = [";
	foreach ($video_graph_data as $data) {
		$i++;
		echo "{day:\"$data[0]\", count:$data[1]}";
		echo $i != $length ? "," : "";
	}
	echo "];";
	?>
    Morris.Area({
        element: 'videos-morris-area-chart',
        data: data_,
        xkey: 'day',
        ykeys: ['count'],
        labels: ['Videos postées'],
        pointSize: 5,
        hideHover: 'auto',
        resize: true,
        smooth:false
    });

});
</script>
    <?php } ?>
<?php include(VIEW.'layouts/pages/admin/scripts.php'); ?>
</body>

</html>

<!--
<!DOCTYPE html>
<html>
	<head>
		<title>DreamVids - Administration</title>
		<meta charset="utf-8">

		<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/meta.php') : include(VIEW.'layouts/pages/default/meta.php'); ?>

		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<link rel="stylesheet" href="<?php echo CSS.'admin.css'; ?>">
	</head>

	<body>
		<div class="page">
			<div id="menu">
				<div class="pure-menu pure-menu-open">
					<a class="pure-menu-heading" href="<?php echo WEBROOT.'admin'; ?>">DreamVids</a>

					<ul>
						<li><a href="<?php echo WEBROOT.'admin/dashboard'; ?>">Tableau de bord</a></li>
						<li><a href="<?php echo WEBROOT.'admin/videos'; ?>">Videos</a></li>
						<li><a href="<?php echo WEBROOT.'admin/channels'; ?>">Chaînes</a></li>
						<li><a href="<?php echo WEBROOT.'admin/comments'; ?>">Commentaires</a></li>
						<li><a href="<?php echo WEBROOT.'admin'; ?>">Déconnexion</a></li>
					</ul>
				</div>
			</div>

			<?php //include($content); ?>
			<br>
		</div>

		<?php isset($currentPage) ? include(VIEW.'layouts/pages/'.$currentPage.'/scripts.php') : include(VIEW.'layouts/pages/default/scripts.php'); ?>
	</body>
</html>
-->