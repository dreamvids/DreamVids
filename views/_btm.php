	<div id="foot">	
		<div class="container separator" style="width: 80%;"></div>
		<h4 style="color:grey;margin-top:40px;margin-bottom:40px;text-align:center;">
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
		</h4>
                <?php
                 if(@$session->getRank() == 5 OR @$session->getRank() == 9)  {
                     
                    
                    echo '<center><a class="btn btn-success" href="/?page=moderation">Centre de modération</a></center>';
                }           
                ?>
                
         
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
