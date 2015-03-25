//<script>

var imported = document.createElement('script');
var _webroot_ = "http://<?php echo $_SERVER["SERVER_NAME"] . WEBROOT ?>";
imported.src = _webroot_ + "<?php echo 'assets/js/eggs_event.js' ?>";
document.body.appendChild(imported);

testEggLoaded = setInterval(function() {
	if(typeof Egg !== "undefined"){
		clearInterval(testEggLoaded);
		loadEggs();
	}
}, 10);

function loadEggs(){
	<?php foreach ($eggs as $egg) {
		if($egg->show_timestamp > Utils::tps()){
			continue;
		}
		$type = $egg->points == 3 ? "gold" : "normal";
		echo "new Egg('{$egg->id}', '$type', 'blank');" . PHP_EOL;
	} ?>
}