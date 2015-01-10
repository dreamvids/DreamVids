<nav class="tabs four">
	<ul>
		<li <?php echo (isset($current) && $current == 'account') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/infos'; ?>"><?php echo Translator::get("pages.account.sub_menu.infos.title"); ?></a></li>
		<li <?php echo (isset($current) && $current == 'password') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/password'; ?>"><?php echo Translator::get("pages.account.sub_menu.password.title"); ?></a></li>
		<li <?php echo (isset($current) && $current == 'channels') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/channels'; ?>"><?php echo Translator::get("pages.account.sub_menu.channels.title"); ?></a></li>
		<li <?php echo (isset($current) && $current == 'videos') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/channelslist'; ?>"><?php echo Translator::get("pages.account.sub_menu.videos.title"); ?></a></li>
		<li <?php echo (isset($current) && $current == 'messages') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/messages'; ?>"><?php echo Translator::get("pages.account.sub_menu.messages.title"); ?></a></li>
		<li <?php echo (isset($current) && $current == 'notifications') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/notifications'; ?>"><?php echo Translator::get("pages.account.sub_menu.notifications.title")?></a></li>
		<li <?php echo (isset($current) && $current == 'language') ? 'class="current"' : ''; ?>><a href="<?php echo WEBROOT.'account/language'; ?>"><?php echo Translator::get("pages.account.sub_menu.language.title"); ?></a></li>
	</ul>
</nav>