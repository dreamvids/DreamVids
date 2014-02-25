<?php
if(isset($session) && ($session->getRank() == $config['rank_adm'] || $session->getRank() == $config['rank_modo']) )
{
    echo '<center><a class="btn btn-success" href="/?page=moderation">Centre de modération</a></center>';
}
?>
                <br /><br />
<div style="background-color:#ecf0f1; color:#34495e;">
<div class="container">            
    <div class="row">
      <div class="col-md-3">
          <h3>Informations légales</h3>
          dreamvids.fr - CopyLeft DeamVids 2013-<?php echo @date('Y'); ?>.<br><a href="http://github.com/vetiore/dreamvids" target="_blank">Code source</a>
      </div>
      <div class="col-md-3">
      	<h3>Partenaires</h3>
<?php
foreach ($partnerships as $partner)
{
?>
      	<a href="<?php echo $partner['url']; ?>" target="_blank"><?php echo $partner['name']; ?></a><br />
<?php
}
?>
      	<a href="#" onclick="alert('Envoyez un E-Mail à \'jeremy [at] dreamvids [dot] fr\'')">Votre site ici ?</a><br />
      </div>
      <div class="col-md-3">
      	<h3>DreamVids</h3>
      	<a href="index.php?page=contributors">Contributeurs</a><br />
      	<a href="http://dreamvids.net" target="_blank">Blog de développement</a><br />
      </div>
      <div class="col-md-3">
      	<h3>Suivez-nous</h3>
      	<a target="_blank" href="https://facebook.com/DreamVids">Facebook</a><br />
      	<a target="_blank" href="https://twitter.com/DreamVids_">Twitter</a><br />
      	<a target="_blank" href="https://github.com/Vetiore/DreamVids">GitHub</a><br />
      </div>
      <!-- <div class="col-md-4">
          <h3>Remerciments</h3>
          <p style="color:grey;">
			Librement réalisé par:
			<a href="http://twitter.com/BokoratMC" target="_blank">Bokorat</a>, 
			<a href="http://twitter.com/JouetR" target="_blank">BrezhDev</a>, 
			<a href="http://twitter.com/Sebraecha" target="_blank">Charlie</a>, 
			<a href="http://twitter.com/DarkWos1" target="_blank">DarkWos</a>, 
			<a href="http://twitter.com/jeremy__fr" target="_blank">Jeremy</a>, 
			<a href="http://twitter.com/Dark_Tagnan" target="_blank">Jonathan</a>, 
			<a href="http://twitter.com/oliviermis" target="_blank">Olivier</a>, 
			<a href="http://twitter.com/p_cauty" target="_blank">PHPeter</a>, 
			<a href="http://twitter.com/_quadrifoglio" target="_blank">Quadrifoglio</a>, 
			<a href="http://twitter.com/VincentBanana" target="_blank">VincentBanana</a> 
			et <a href="http://skype.com/" target="_blank">La bonne humeur</a> !
		</p>
      </div> -->
    </div>  
</div>
</div>
	
		

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
     
      ga('create', 'UA-34423249-4', 'dreamvids.fr');
      ga('send', 'pageview');
     
    </script>

	
	</body>
</html>
