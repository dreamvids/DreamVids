<div class="content">
	<aside class="aside-cards-list">
		<h3 class="title">Rechercher - "<?php echo $search; ?>" (Vous ne trouvez pas ? Faite une <a href="<?php echo  WEBROOT. 'search/advanced' ?>">recherche avancée</a>)</h3>
		
		
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