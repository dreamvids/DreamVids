<div class="container">

	<h1 class="title">Report de bugs</h1>

	<div class="container">
<?php echo (isset($err) ) ? '<div class="alert alert-danger">'.$err.'</div>' : '';
echo (!isset($err) && isset($_POST['submit']) ) ? '<div class="alert alert-success">Bug reporté avec succès !</div>' : ''; ?>
		<h2 class="title">Reporter un bug</h2>
<?php if (isset($session) ) {?>		<form role="form" action="" method="post">
			<div class="form-group">
				<label for="bug">Description du bug :</label>
				<textarea required="required" rows="8" cols="50" name="bug" id="bug" class="form-control"></textarea>
			</div>
			<div class="form-group">
				<label for="url">Adresse URL du bug (facultative) :</label>
				<input type="url" name="url" id="url" class="form-control" />
			</div>
			<input type="submit" name="submit" value="Reporter" class="btn btn-primary btn-info" />
		</form>
<?php } else echo '<h4 class="text-center">Afin d\'éviter le spam, merci de vous connecter pour pouvoir reporter un bug.</h4>'; ?>
		
		<h2 class="title">Bugs déjà reportés</h2>
<?php
echo (count($bugs) == 0) ? '<h1 style="text-align:center">Aucun bug actuellement !</h1>' : '';

foreach ($bugs as $bug)
{
?>
		<div class="panel panel-default" style="width: 100%;" id="bug-<?php echo $bug['id']; ?>">
			<div class="panel-heading">
<?php
	if ($session->getRank() == $config['rank_adm'] || $session->getRank() == $config['rank_dev'])
	{
?>
				<div style="float:right">
					<div class="btn-group" data-toggle="buttons">
					    <label onclick="document.location.href='index.php?page=bugs&p=<?php echo $page; ?>&id=<?php echo $bug['id']; ?>&resolution=0';" class="btn btn-danger <?php echo ($bug['resolution'] == 0) ? 'active' : ''; ?>">
					        <input type="radio" />
					        <?php echo $res[0]; ?>
					    </label>
					    <label onclick="document.location.href='index.php?page=bugs&p=<?php echo $page; ?>&id=<?php echo $bug['id']; ?>&resolution=1';" class="btn btn-warning  <?php echo ($bug['resolution'] == 1) ? 'active' : ''; ?>">
					        <input type="radio" />
					        <?php echo $res[1]; ?>
					    </label>
					    <label onclick="document.location.href='index.php?page=bugs&p=<?php echo $page; ?>&id=<?php echo $bug['id']; ?>&resolution=2';" class="btn btn-success  <?php echo ($bug['resolution'] == 2) ? 'active' : ''; ?>">
					        <input type="radio" />
					        <?php echo $res[2]; ?>
					    </label>
					    <label onclick="document.location.href='index.php?page=bugs&p=<?php echo $page; ?>&id=<?php echo $bug['id']; ?>&resolution=3';" class="btn btn-info">
					        <input type="radio" />
					        Corrigé
					    </label>
					</div>
				</div>
<?php
	}
?>
				<h5>Reporté par <a href="index.php?page=member&name=<?php echo User::getNameById($bug['user_id']); ?>"><?php echo User::getNameById($bug['user_id']); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-<?php echo $rclass[$bug['resolution']]; ?>"><?php echo $res[$bug['resolution']]; ?></span></h5>
			</div>
			<div class="panel-body">
				<p><?php echo nl2br(secure($bug['description']) ); ?></p>
				<p><?php echo ($session->getRank() == $config['rank_adm']) ? 'URL: <a href="'.$bug['url'].'">'.$bug['url'].'</a>' : ''; ?></p>
			</div>
		</div>
<?php
}
?>
	</div>
</div>
