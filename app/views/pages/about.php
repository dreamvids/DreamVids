<div class="content">
	<h1 class="title">Qui sommes-nous ?</h1>

	<h3 class="title">Un peu d'histoire</h3>
	<p style="text-align:justify;">
		<b>DreamVids</b> est une plateforme qui a vu le jour le 11 Décembre 2013.
		À cette époque le scandale sur la nouvelle politique de YouTube vient d'éclater. Tout le monde,
		même les plus grands YouTubers, s'indignent contre ces mesures. Je m'appelle Peter, j'ai alors 19
		ans et je poste un floppée de tweet en disant que ce serait génial de lancer une toute nouvelle
		plateforme pile le jour de la mise en place de la nouvelle politique, le 1er Janvier 2014. Je tweet,
		je tweet, <a href="https://twitter.com/DarkWos1" target="_blank">@DarkWos1</a> et
		<a href="https://twitter.com/VincentBanana" target="_blank">@VincentBanana</a> me font savoir qu'ils
		sont prêts suivre le mouvement mais pour le moment ce ne sont que des tweets, jusqu'à ce que...
		<blockquote class="twitter-tweet" lang="fr"><p><a href="https://twitter.com/p_cauty">@p_cauty</a>
		<a href="https://twitter.com/Experimentboy">@experimentboy</a> J&#39;te paye les serveurs, tu fait
		la plateforme, on partage ? ;)</p>&mdash; Jérémy Martin (@caaptusss)
		<a href="https://twitter.com/caaptusss/status/410833781021368320">11 Décembre 2013</a></blockquote>
		<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		À partir de là le concept devient sérieux, on en parle sur Skype, on met en place un plan d'attaque,
		et c'est finalement avec <a href="https://twitter.com/oliviermis" target="_blank">@oliviermis</a>
		que le partenariat se fera.
	</p>

	<h3 class="title">Et Maintenant ?</h3>
	<p style="text-align:justify;">
		Aujourd'hui, DreamVids est un projet bénévole composé de 17 personnes passionnées.
		Nous travaillons tous les jours pour faire de DreamVids une plateforme cool et reconnue !
		Actuellement, vous naviguez sur la version 2 du site, qui fait suite à la version 1, qui était
		une bêta, et qui a durée presque un an.
	</p>

	<h3 class="title">L'équipe</h3>
	<?php foreach ($team as $teammate): ?>
	<div style="margin-bottom:50px">
		<div style="float:left">
			<img src="<?php echo StaffContact::getImageName($teammate); ?>" style="height:50px;width:50px;border-radius:25px;" />
		</div>
		<p style="padding-left:70px">
			<b><?php echo StaffContact::getShownName($teammate); ?></b><br />
			<?php echo StaffContact::getDescription($teammate); ?>
		</p>
	</div>
	<?php endforeach; ?>
</div>
