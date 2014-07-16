<?php if (isset($session) && ($session->getRank() == $config['rank_adm'] || $session->getRank() == $config['rank_modo'])) {
    echo '<br><center><a class="btn btn-success" href="admin/?page=moderation">Centre de modération</a><br /><br /><a class="btn btn-danger" href="./admin">Panneau d\'administration</a></center>';
} ?>

<div class="chat" id="time-real-chat-element">
    
    <div class="content not-yet">
    
        Le chat en temps réel sera prochainement disponible sur DreamVids ;)
    
    </div>

    <!-- <div class="content">
        
        <div class="tabs">
            <span class="current">Chat global</span>
            <span>Chat privé</span>
        </div>
    
    </div> -->

</div>

<script src="js/chat.js"></script>

<br><br>
<footer>
    <div id="inner-footer">

        <div class="row">

            <h1>DreamVids</h1>
      
            <a href="index.php?page=contributors">Contributeurs</a>
            <a href="http://blog.dreamvids.fr/" target="_blank">Blog de développement</a>
            <a href="http://dreamvids.spreadshirt.fr/" target="_blank">Boutique</a>

        </div>

        <div class="row">

            <h1>Partenaires</h1>

            <?php foreach ($partnerships as $partner) { ?>
              <a href="<?php echo $partner['url']; ?>" target="_blank"><?php echo $partner['name']; ?></a>
            <?php } ?>

            <a href="javascript:void(0)" onclick="alert('Pour toute demande de partenariat, envoyez un E-Mail à \'jeremy [at] dreamvids [dot] fr\'')">Votre site ici ?</a>

        </div>

        <div class="row">

            <h1>Social</h1>
      
            <a target="_blank" href="https://twitter.com/DreamVids_">Twitter</a>
            <a target="_blank" href="https://facebook.com/DreamVids">Facebook</a>
            <a target="_blank" href="http://github.com/DreamVids">Github</a>

        </div>

        <div class="rights">

            <span class="love">Fait en France, avec le <i>♥</i></span>
      
            <a class="license" rel="license" title="Cette œuvre est mise à disposition selon les termes de la Licence Creative Commons Attribution - Pas d’Utilisation Commerciale - Partage dans les Mêmes Conditions 4.0 International" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licence Creative Commons" src="img/license.png" /></a>
            dreamvids.fr - CopyLeft DeamVids 2013-<?php echo date('Y'); ?> <a href="https://github.com/DreamVids/DreamVids" class="github">Code source sur Github</a>
    
        </div>

    </div>
</footer>

<script src="js/bgLoader.js"></script>
<script src="js/interactions.js"></script>
<script src="js/filePreview.js"></script>
	
    <script>
	    function inArray(needle, haystack) {
	        var length = haystack.length;
	        for(var i = 0; i < length; i++) {
	            if(haystack[i] == needle) return true;
	        }
	        return false;
	  	}
    
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		ga('create', 'UA-34423249-4', 'dreamvids.fr');
		ga('send', 'pageview');
    </script>

	
	</body>
</html>
