 <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item" href="/profile"><?php echo $lang['my_account']; ?></a>
          <a class="blog-nav-item" href="/pass"><?php echo $lang['password']; ?></a>
          <a class="blog-nav-item active" href="/manager"><?php echo $lang['my_vids']; ?></a>
          <a class="blog-nav-item" href="/mail"><?php echo $lang['msg']; ?></a>

        </nav>
      </div>
    </div>

<div class="container">
	<div class="container">
		<div class='border-top'></div>
			<h1><?php echo $session->getName(); ?><small> Mises en ligne</small></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class="container">
		<?php
		echo (isset($err) ) ? '<div class="container"><div class="container" style="width: 80%;"><div class="alert alert-danger">'.$lang['error'].': '.$err.'</div></div></div>' : '';
		
		foreach ($vids as $vid)
		{
		?>
			<div class="row">
				<div class="container">
					<div class="col-md-4">
						<a href="./&<?php echo $vid->getId(); ?>" class="thumbnail" style="width: 171px; height:100px;">
						 <div style="height:90px;width:100%;overflow:hidden">
					      <img data-src="holder.js/171x97" width="161" src="<?php echo ($vid->getTumbnail() != '') ? secure($vid->getTumbnail() ) : secure($vid->getPath() ).'.jpg'; ?>" />
					     </div>
					    </a>
					</div>

					<div class="col-md-4">
					    <p>Titre: <?php echo secure($vid->getTitle() ); ?></p>
					    <p>Vues: <?php echo secure($vid->getViews() ); ?></p>
					    <p>+: <?php echo secure($vid->getLikes() ); ?></p>
					    <p>-: <?php echo secure($vid->getDislikes() ); ?></p>
					</div>

					<br><br>
				    
				    <a href="./&<?php echo $vid->getId(); ?>" class="btn btn-info">Regarder</a>
			    	<a href="./?page=videoproperties&vidId=<?php echo $vid->getId(); ?>" class="btn btn-success">Paramètres</a>
			    	<a href='./?page=manager&delVid=<?php echo $vid->getId(); ?>' class="btn btn-danger" onclick="confirm('<?php echo $lang['confirm_delete_vid']; ?>')">Supprimer</a>
					
				</div>

				<div class="container separator" style="width: 80%;"></div>
		<?php
		}
		?>
		</div>
	</div>
</div>
