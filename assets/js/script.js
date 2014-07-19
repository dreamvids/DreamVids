var marmottajax=function(a){return marmottajax.get(a)};marmottajax.n=function(a){return a?"string"==typeof a?{url:a}:a:!1},marmottajax.json=function(a){return(a=marmottajax.n(a))?(a.json=!0,new marmottajax.r(a)):void 0},marmottajax.get=function(a){return new marmottajax.r(a)},marmottajax.post=function(a){return(a=marmottajax.n(a))?(a.method="POST",new marmottajax.r(a)):void 0},marmottajax.r=function(a){if(!a)return!1;if("string"==typeof a&&(a={url:a}),"POST"===a.method){var b="?";for(var c in a.options)b+=a.options.hasOwnProperty(c)?"&"+c+"="+a.options[c]:""}else{a.method="GET",a.url+=a.url.indexOf("?")<0?"?":"";for(var c in a.options)a.url+=a.options.hasOwnProperty(c)?"&"+c+"="+a.options[c]:""}this.x=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP"),this.x.o=a,this.x.c={t:[],e:[]},this.then=function(a){return this.x.c.t.push(a),this},this.error=function(a){return this.x.c.e.push(a),this},this.x.l=function(a,b){for(var c=0;c<this.c[a].length;c++)"function"==typeof this.c[a][c]&&this.c[a][c](b)},this.x.y=function(a){this.l("t",a)},this.x.z=function(a){this.l("e",a)},this.x.onreadystatechange=function(){if(4===this.readyState&&200==this.status){var a=this.responseText;if(this.o.json)try{a=JSON.parse(a)}catch(b){return this.z("invalid json"),!1}this.y(a)}else 4===this.readyState&&404==this.status?this.z("404"):4===this.readyState&&this.z("unknow")},this.x.open(a.method,a.url,!0),this.x.setRequestHeader("Content-type","application/x-www-form-urlencoded"),this.x.send("undefined"!=typeof b?b:null)};

/**
 * Core/launch.js
 *
 * CORE LAUNCH
 */

document.addEventListener("DOMContentLoaded", function() {

	for (var i = 0; i < _scripts_.length; i++) {

		var can_call = false,
			script = _scripts_[i];

		if (script.pages === "*" || script.pages === "all" || !script.pages) {

			can_call = true;

		}

		else {

			for (var p = 0; p < script.pages.length; p++) {
				
				if (script.pages[p] === _currentpage_) {

					can_call = true;

				}

			}
			
		}

		if (can_call) {

			script.call();

		}

	}

}, false);

/**
 * Core/main.js
 *
 * MAIN CORE FILE
 */

var _scripts_ = [];

var Script = function(script) {

	this.pages = script.pages;

	this.to_call = script.call;

	_scripts_.push(this);

};

Script.prototype.call = function() {
	
	this.to_call();

};

/**
 * Scripts/bg-loader.js
 *
 * BACKGROUND LOADER
 */

function background_loader(element) {

     this.element = element;
     this.src = this.element.getAttribute("data-background");;
     this.element.style.backgroundImage = "url(" + this.src + ")";

     this.imgLoader = new Image();
     this.imgLoader.src = this.src;

     this.imgLoader.addEventListener("load", function(event) {

         element.className = element.className.replace("bgLoader", "");
         element.className = element.className.replace("bg-loader", "");

         element.className += " bgLoaderTransition bgLoaded";
         element.className += " bg-loader-transition bg-loaded";

         setTimeout(function(element) {

             return function() {

                 element.className = element.className.replace("bg-loader-transition", "");

             }

         }(element), 300);

     }, false);

 }

var bg_loader = new Script({

	call: function() {

		var elements = document.getElementsByClassName("bgLoader");

		if (elements.length) {

			console.error(elements.length + " éléments possedent la classe bgLoader qui n'est plus utilisée.");

		}

		var new_class_elements = document.getElementsByClassName("bg-loader");

		for (var i = 0; i < new_class_elements.length; i++) {

			elements.push(new_class_elements[i]);
			
		}

		if (elements && elements.length) {

		    for (var i = 0, length = elements.length; i < length; i++) {

		        new background_loader(elements[i]);

		    }

		}

	}

});

/**
 * Scripts/example.js
 *
 * EXAMPLE SCRIPT
 */

var meteo = new Script({

	pages: ["default", "watch"], // Pages 

	// OU // pages: "all", // OU ne pas spécifier

	call: function() { // Fonction appelée lorsque la page peut être manipulée

		console.log("Il pleut!", "{example script}");

	}

});

/**
 * MIGRÉ VERS LES NOUVEAUX MODELES DE SCRIPTS
 */

function postComment(vid, commentContent, fromChannel) {
	marmottajax.post({
		'url': '../comments/',
		'options': {'commentSubmit': 'lol', 'comment-content': commentContent, 'from-channel': fromChannel, 'video-id': vid}
	}).then(function(result) {
		var comment = JSON.parse(result);

		var commentDiv = document.createElement('div');
			commentDiv.className = 'comment';

			var headDiv = document.createElement('div');
				headDiv.className = 'comment-head';

				var userDiv = document.createElement('div');
					userDiv.className = 'user';

					var avatar = document.createElement('img');
					avatar.setAttribute('src', '../assets/img/avatar_user.png'); //TODO: Use channel's avatar

					var a = document.createElement('a');
					a.setAttribute('href', '#'); //TODO: Use channel's avatar

					var username = document.createTextNode(comment.author);
					a.appendChild(username);

					userDiv.appendChild(avatar);
					userDiv.appendChild(a);

				headDiv.appendChild(userDiv);


				var dateDiv = document.createElement('div');
					dateDiv.className = 'date';

					var p = document.createElement('p');
					var date = document.createTextNode(comment.relativeTime);

					p.appendChild(date);
					dateDiv.appendChild(p);

				headDiv.appendChild(dateDiv);

			commentDiv.appendChild(headDiv);

			var textDiv = document.createElement('div');
				textDiv.className = 'comment-text';

				var p1 = document.createElement('p');
				var text = document.createTextNode(comment.comment);
				
				p1.appendChild(text);
				textDiv.appendChild(p1);

			commentDiv.appendChild(textDiv);

			var noteDiv = document.createElement('div');
				noteDiv.className = 'comment-notation';

					var ul = document.createElement('ul');

						var li1 = document.createElement('li');
						var li2 = document.createElement('li');

						li1.className = 'plus';
						li2.className = 'moins';

						var plus = document.createElement('a');
							plus.setAttribute('href', '#');

							var plusText = document.createTextNode('+');
							plus.appendChild(plusText);
						li1.appendChild(plus);

						var moins = document.createElement('a');
							moins.setAttribute('href', '#');

							var moinsText = document.createTextNode('-');
							moins.appendChild(moinsText);
						li2.appendChild(moins);

						var plusNumber = document.createTextNode('0');
						li1.appendChild(plusNumber);

						var moinsNumber = document.createTextNode('0');
						li2.appendChild(moinsNumber);

						ul.appendChild(li1);
						ul.appendChild(li2);

					noteDiv.appendChild(ul);

			commentDiv.appendChild(noteDiv);

		document.getElementById('comments-best').appendChild(commentDiv);
	});
}
var filePreview = function(element) {
    this.element = element;
    this.input = document.getElementById(this.element.getAttribute('data-input'));

    this.input.addEventListener('change', function(event) {
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(event) {
                this.cible.className = this.cible.className.replace(" none", "");
                this.cible.src = event.target.result;
            }

            reader.cible = document.getElementById(this.getAttribute('data-preview'));
            reader.readAsDataURL(this.files[0]);
        }
    }, false);
}

var elements = document.getElementsByClassName('filePreview');
if (elements && elements.length) {
    for (var i = 0, length = elements.length; i < length; i++) {
        filePreview(elements[i]);
    }
}

/*
 *  Interactions utilisateur
 *
 */

var body = document.getElementById("page");

// Menu utilisateur

var button_nav_mobile = document.getElementById("mobile-nav-icon") || document.createElement("div"),
    nav = document.getElementById("header-menu-nav") || document.createElement("div");

button_nav_mobile.addEventListener("click", function() {

    if (button_nav_mobile.className.search("open") > 0) {

        button_nav_mobile.className = button_nav_mobile.className.replace("open", "");
        nav.className = nav.className.replace("open", "");

    }

    else {

        button_nav_mobile.className += " open";
        nav.className += " open";

    }

});

var button_user_info = document.getElementById("top-nav-user-information-button") || document.createElement("div"),
    user_info_menu = document.getElementById("top-nav-user-information-menu") || document.createElement("div");

button_user_info.addEventListener("click", function() {

    user_info_menu.style.display = user_info_menu.style.display != "inline" ? "inline" : "none";

});

body.addEventListener("click", function(event) {

    user_info_menu.style.display = event.target.id != "top-nav-user-information-button" && event.target.parentNode.id != "top-nav-user-information-button" ? "none" : user_info_menu.style.display;

});

var hover_subscribe = document.getElementById("hover_subscribe") || document.createElement("div");

hover_subscribe.addEventListener("click", function() {

    if (hover_subscribe.className == "subscribed") {

        hover_subscribe.className = "";
        hover_subscribe.childNodes[0].innerHTML = "S'abonner";

        ajax.post({

            action: "unsubscribe",
            dr_id: hover_subscribe.dataset.vid

        });

    }

    else {

        hover_subscribe.className = "subscribed";
        hover_subscribe.childNodes[0].innerHTML = "Abonné";

        ajax.post({

            action: "subscribe",
            dr_id: hover_subscribe.dataset.vid

        });

    }

});

// S'abonner sur une page chaine

var subscribe_button = document.getElementById("subscribe-button") || document.createElement("div");

subscribe_button.addEventListener("click", function() {

    if (subscribe_button.className == "subscribed") {

        subscribe_button.className = "";
        subscribe_button.innerHTML = subscribe_button.dataset.text.split("|")[0];

        ajax.post({ action: "unsubscribe" });

    }

    else {

        subscribe_button.className = "subscribed";
        subscribe_button.innerHTML = subscribe_button.dataset.text.split("|")[1];

        ajax.post({ action: "subscribe" });

    }

});

/**
 * main.js
 *
 * MAIN FILE
 */

console.log(_currentpage_);

if (!_currentpage_) {

	console.error("La variable _currentpage_ n'est pas définie.");

}
var marmottajax=function(a){return marmottajax.get(a)};marmottajax.n=function(a){return a?"string"==typeof a?{url:a}:a:!1},marmottajax.json=function(a){return(a=marmottajax.n(a))?(a.json=!0,new marmottajax.r(a)):void 0},marmottajax.get=function(a){return new marmottajax.r(a)},marmottajax.post=function(a){return(a=marmottajax.n(a))?(a.method="POST",new marmottajax.r(a)):void 0},marmottajax.r=function(a){if(!a)return!1;if("string"==typeof a&&(a={url:a}),"POST"===a.method){var b="?";for(var c in a.options)b+=a.options.hasOwnProperty(c)?"&"+c+"="+a.options[c]:""}else{a.method="GET",a.url+=a.url.indexOf("?")<0?"?":"";for(var c in a.options)a.url+=a.options.hasOwnProperty(c)?"&"+c+"="+a.options[c]:""}this.x=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP"),this.x.o=a,this.x.c={t:[],e:[]},this.then=function(a){return this.x.c.t.push(a),this},this.error=function(a){return this.x.c.e.push(a),this},this.x.l=function(a,b){for(var c=0;c<this.c[a].length;c++)"function"==typeof this.c[a][c]&&this.c[a][c](b)},this.x.y=function(a){this.l("t",a)},this.x.z=function(a){this.l("e",a)},this.x.onreadystatechange=function(){if(4===this.readyState&&200==this.status){var a=this.responseText;if(this.o.json)try{a=JSON.parse(a)}catch(b){return this.z("invalid json"),!1}this.y(a)}else 4===this.readyState&&404==this.status?this.z("404"):4===this.readyState&&this.z("unknow")},this.x.open(a.method,a.url,!0),this.x.setRequestHeader("Content-type","application/x-www-form-urlencoded"),this.x.send("undefined"!=typeof b?b:null)};
/*
 *  Player
 */

player = document.getElementById('player');
videoInfos = document.getElementById('videoInfos');

player.style.height = typeof embeded != 'undefined' ? document.documentElement.clientHeight + 'px' : player.offsetWidth / (16 / 9) + 'px';

if (document.body.clientWidth < 640) {
    player.style.width = document.body.clientWidth + 'px';
    player.style.height = typeof embeded != 'undefined' ? document.documentElement.clientHeight + 'px' : player.offsetWidth / (16 / 9) + 'px';
}
if (videoInfos)
    videoInfos.style.height = player.offsetWidth / (16 / 9) + 'px';

function resized() {
    if (document.body.clientWidth < 640) {
        player.style.width = document.body.clientWidth + 'px';
        player.style.height = typeof embeded != 'undefined' ? document.documentElement.clientHeight + 'px' : player.offsetWidth / (16 / 9) + 'px';
        if (videoInfos)
            videoInfos.style.height = player.offsetWidth / (16 / 9) + 'px';
    } else {
        player.style.width = '';
        player.style.height = '';
        if (videoInfos) {
            if (player.className.search('wide') > 0) {
                player.style.height = typeof embeded != 'undefined' ? document.documentElement.clientHeight + 'px' : player.offsetWidth / (16 / 9) + 'px';
                videoInfos.style.height = player.offsetWidth / (16 / 9) + 'px';
            } else
                videoInfos.style.height = '';
        }
    }
    player.style.height = typeof embeded != 'undefined' ? document.documentElement.clientHeight + 'px' : player.offsetWidth / (16 / 9) + 'px';
}
window.addEventListener("resize", resized, false);

video = player.getElementsByTagName('video')[0];
srcMp4 = document.getElementById('srcMp4');
srcWebm = document.getElementById('srcWebm');

controls = document.getElementById('controls');

playPauseElement = document.getElementById('play-pause');

playPauseElement.addEventListener("click", playPause);

annotationsElement = document.getElementById('annotationsElement');
annotationsElement.addEventListener("click", function(event) {
    if (event.target === annotationsElement) {
        if (controls.className == 'down')
            upPlayer();
        else
            playPause();
    }
});
time = document.getElementById('time');

function playPause() { // Fonction appelée à chaque play/pause effectué
    playPauseElement.className = video.paused ? 'play' : 'pause';

    if (video.paused)
        video.play();
    else
        video.pause();
}

function time2str(time) { // Transformation du temps [int] en 13:37
    var today = new Date(time);
    var h = Math.floor(time / 3600);
    var m = Math.floor(time / 60);
    var s = Math.floor(time - m * 60);
    m = m - h * 60;

    h = h < 10 ? '0' + h : h;
    m = m < 10 ? '0' + m : m;
    s = s < 10 ? '0' + s : s;

    return (h > 0 ? h + ":" : '') + m + ":" + s;
}
video.addEventListener("canplay", function() { // Au chargement de la page, on définit le bon icone (play ou pause)
    if (video.duration)
        time.innerHTML = time2str(video.currentTime) + ' / ' + time2str(video.duration);

    playPauseElement.className = video.paused ? 'play' : 'pause';
});

waitForPlay = document.getElementById('waitForPlay');
waitForPlay.addEventListener("click", function() {
    video.play();
}, false);

bigPlay = document.getElementById('bigPlay');
bigPlay.addEventListener('webkitAnimationEnd', function() {
    this.style.webkitAnimationName = '';
}, false);
bigPlay.addEventListener('msAnimationEnd', function() {
    this.style.msAnimationName = '';
}, false);
bigPlay.addEventListener('oAnimationEnd', function() {
    this.style.oAnimationName = '';
}, false);
bigPlay.addEventListener('animationend', function() {
    this.style.mozAnimationName = '';
    this.style.animationName = '';
}, false);
video.addEventListener("play", function() { // Animation du "play"
    waitForPlay.style.display = 'none';
    playPauseElement.className = 'pause';

    if (video.currentTime != video.duration && video.currentTime != 0) {
        bigPlay.style.webkitAnimationName = 'bigIconPlay';
        bigPlay.style.mozAnimationName = 'bigIconPlay';
        bigPlay.style.msAnimationName = 'bigIconPlay';
        bigPlay.style.oAnimationName = 'bigIconPlay';
        bigPlay.style.animationName = 'bigIconPlay';
    }
}, false);

bigPause = document.getElementById('bigPause');
bigPause.addEventListener('webkitAnimationEnd', function() {
    this.style.webkitAnimationName = '';
}, false);
bigPause.addEventListener('msAnimationEnd', function() {
    this.style.msAnimationName = '';
}, false);
bigPause.addEventListener('oAnimationEnd', function() {
    this.style.oAnimationName = '';
}, false);
bigPause.addEventListener('animationend', function() {
    this.style.mozAnimationName = '';
    this.style.animationName = '';
}, false);
video.addEventListener("pause", function() { // Animation du "pause"
    playPauseElement.className = 'play';

    if (video.currentTime != video.duration) {
        bigPause.style.webkitAnimationName = 'bigIconPause';
        bigPause.style.mozAnimationName = 'bigIconPause';
        bigPause.style.msAnimationName = 'bigIconPause';
        bigPause.style.oAnimationName = 'bigIconPause';
        bigPause.style.animationName = 'bigIconPause';
    }
});

progress = document.getElementById('progress');
progress.buffered = document.getElementById('buffered');
progress.viewed = document.getElementById('viewed');
progress.current = document.getElementById('current');

video.addEventListener("timeupdate", function(event) { // Mise à jour de la progressbar
    percent = video.currentTime / video.duration * 100 + "%"
    progress.viewed.style.width = percent;
    progress.current.style.left = percent;

    time.innerHTML = video.duration ? time2str(video.currentTime) + ' / ' + time2str(video.duration) : '';
});

function bufferUpdate() { // Mise à jour du "buffer"
    if (video.buffered && video.duration && video.buffered.length) {
        percent = video.buffered.end(video.buffered.length - 1) / video.duration * 100;
        progress.buffered.style.width = percent >= 0 && percent <= 100 ? percent + "%" : '0%';
    }
}
video.addEventListener("loadedmetadata", function(event) {
    if (video.buffered)
        setInterval(bufferUpdate, 500);
});

function getOffset(object) {
    if (document.webkitFullscreenElement || document.mozFullscreenElement || document.fullscreenElement) // Bug du fullscreen u_u
        return object.offsetLeft;

    var x = 0;
    element = object;
    while (element) {
        x += (element.offsetLeft - (element == document.body ? 0 : element.scrollLeft) + element.clientLeft);
        element = element.offsetParent;
    }
    return x;
}

mouseDown = false;
progress.addEventListener("mousedown", function(event) { // Déplacement de la progressbar
    mouseDown = true;
    if (video.duration)
        video.currentTime = (event.clientX - getOffset(progress)) / progress.offsetWidth * video.duration;
});
document.addEventListener("mouseup", function(event) {
    progress.className = '';
    mouseDown = false;
});

document.addEventListener("mousemove", function(event) {
    if (mouseDown) {
        progress.className = 'clicking';
        percent = (event.clientX - getOffset(progress)) / progress.offsetWidth * 100 + "%"
        progress.viewed.style.width = percent;
        progress.current.style.left = percent;
        video.currentTime = (event.clientX - getOffset(progress)) / progress.offsetWidth * video.duration;
    }
});

var lastTime;
var time2down = 4000;

function downPlayer() { // Les controles disparaissent
    if (!video.paused) {
        lastTime = new Date().getTime();
        annotationsElement.style.cursor = 'none';
        controls.className = 'down';
        player.className = 'down';
    }
}
var timeout = setTimeout(downPlayer, time2down / 2);

function upPlayer() { // Les controles réaparaisent
    if (new Date().getTime() - 300 < lastTime)
        return;

    annotationsElement.style.cursor = 'default';
    controls.className = '';
    player.className = player.className.replace('down', "");

    clearTimeout(timeout);
    timeout = setTimeout(downPlayer, time2down / 2);
}

player.addEventListener("mousemove", upPlayer);


/*
 *  Widescreen
 */

widescreen = document.getElementById('widescreen');

widescreen.addEventListener("click", function() {
    if (document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement)
        toogleFullScreen();

    player.style.height = '';
    if (videoInfos)
        videoInfos.style.height = '';

    if (player.className.search('wide') < 0) {
        player.className = 'animated wide';
        widescreen.className = 'smallscreen';
    } else {
        player.className = 'animated';
        widescreen.className = 'widescreen';
    }

    var unAnimate = setTimeout(function() {
        player.className = player.className.search('wide') > 0 ? 'wide' : '';
        player.style.height = typeof embeded != 'undefined' ? document.documentElement.clientHeight + 'px' : player.offsetWidth / (16 / 9) + 'px';
    }, 400);
});

/*
 *  Fullscreen
 */

fullscreen = document.getElementById('fullscreen');
fullscreen.addEventListener("click", toogleFullScreen);

function toogleFullScreen() {
    if (typeof annoTimeLine != 'undefined')
        return;

    player.className = player.className.search('wide') > 0 ? 'wide' : '';

    if (!(document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement)) {
        if (player.requestFullscreen)
            player.requestFullscreen();
        else if (player.msRequestFullscreen)
            player.msRequestFullscreen();
        else if (player.mozRequestFullScreen)
            player.mozRequestFullScreen();
        else if (player.webkitRequestFullscreen)
            player.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
    } else {
        if (document.exitFullscreen)
            document.exitFullscreen();
        else if (document.msExitFullscreen)
            document.msExitFullscreen();
        else if (document.mozCancelFullScreen)
            document.mozCancelFullScreen();
        else if (document.webkitExitFullscreen)
            document.webkitExitFullscreen();
    }
}

window.addEventListener("orientationchange", function() {
    if (window.orientation == 0) {
        if (document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement)
            toogleFullScreen();
    }
}, false);

annotationsElement.addEventListener("dblclick", toogleFullScreen);

function setImageFullscreen(name) {
    fullscreen.className = name;
}
document.addEventListener('webkitfullscreenchange', function() {
    if (!document.webkitFullscreenElement)
        setImageFullscreen('fullscreen');
    else
        setImageFullscreen('lowscreen');
}, false);
document.addEventListener('mozfullscreenchange', function() {
    if (!document.mozFullScreenElement)
        setImageFullscreen('fullscreen');
    else
        setImageFullscreen('lowscreen');
}, false);
document.addEventListener('msfullscreenchange', function() {
    if (!document.msFullscreenElement)
        setImageFullscreen('fullscreen');
    else
        setImageFullscreen('lowscreen');
}, false);
document.addEventListener('fullscreenchange', function() {
    if (!document.fullscreenElement)
        setImageFullscreen('fullscreen');
    else
        setImageFullscreen('lowscreen');
}, false);

/*
 *  Volume
 */

volume = document.getElementById('volume');
volume.barre = document.getElementById('barre');
volume.icon = document.getElementById('icon');

video.addEventListener("volumechange", function(event) {
    percent = video.volume * 100 + "%";
    volume.barre.style.width = percent;
    volume.icon.style.left = percent;
    if (video.volume <= 0.05) // Génération de l'image
        volume.icon.dataset.volume = 0;
    else if (video.volume <= 0.4)
        volume.icon.dataset.volume = 1;
    else if (video.volume <= 0.6)
        volume.icon.dataset.volume = 2;
    else if (video.volume >= 0.6)
        volume.icon.dataset.volume = 3;
}, false);

function volumeChange() {
    ajax.post({
        action: 'volume',
        vol: video.volume
    });
}

var volumeBeforeUp = 1;
var mouseDownVolume = false;
volume.addEventListener("mousedown", function(event) { // Déplacement de la "barre" de volume
    volumeBeforeUp = video.volume;
    mouseDownVolume = true;
    newVolume = (event.clientX - getOffset(volume)) / volume.offsetWidth;
    newVolume = newVolume < 0 ? 0 : (newVolume > 1 ? 1 : newVolume);
    video.volume = newVolume;
});

document.addEventListener("mousemove", function(event) {
    if (mouseDownVolume) {
        percent = video.volume * 100 + "%";
        volume.barre.style.width = percent;
        volume.icon.style.left = percent;
        newVolume = (event.clientX - getOffset(volume)) / volume.offsetWidth;
        newVolume = newVolume < 0 ? 0 : (newVolume > 1 ? 1 : newVolume);
        video.volume = newVolume;
    }
}, false);

document.addEventListener("mouseup", function(event) {
    mouseDownVolume = false;
    if (video.volume != volumeBeforeUp && event.target === volume.icon)
        volumeChange();
});

function setVolume(newVolume) {
    video.volume = newVolume;
}

function mouseWheelVolume(event) {
    if (!(document.webkitFullscreenElement || document.mozFullscreenElement || document.fullscreenElement))
        return;

    upPlayer();
    lastVolume = video.volume;

    video.volume = event.wheelDelta > 0 || event.detail < 0 ? Math.min(video.volume + 0.1, 1) : Math.max(video.volume - 0.1, 0);

    if (lastVolume != video.volume)
        volumeChange();
}

player.addEventListener("mousewheel", mouseWheelVolume, false);
player.addEventListener("DOMMouseScroll", mouseWheelVolume, false);

repeat = document.getElementById('repeat'); // Affichage de repeat en fin de vidéo

video.addEventListener("ended", function() {
    repeat.className = 'show';
}, false);
repeat.addEventListener("click", function() {
    repeat.className = '';
    video.currentTime = 0;
    playPause();
}, false);
video.addEventListener("play", function() {
    repeat.className = '';
}, false);

/*
 *  Qualité
 */

var lastTime = 0;

var currentQuality;
qualitySelection = document.getElementById('qualitySelection'); // On ferme
qualitySelection.addEventListener('click', function() {
    qualitySelection.className = '';
});

qualityButton = document.getElementById('qualityButton'); // On ouvre
qualityButton.addEventListener('click', function() {
    if (qualitys.length == 2) {
        if (qualitys[0].format == currentQuality)
            setQuality(qualitys[1].format)
        else
            setQuality(qualitys[0].format)

    } else if (qualitys.length > 1) // S'il y a plusieurs qualités...
        qualitySelection.className = 'show';
});

function setQuality(format) { // On change la qualité
    player.style.height = typeof embeded != 'undefined' ? document.documentElement.clientHeight + 'px' : player.offsetWidth / (16 / 9) + 'px';
    if (videoInfos)
        videoInfos.style.height = player.offsetWidth / (16 / 9) + 'px';

    qualitySelection.className = '';
    length = qualitys.length;
    if (currentQuality == format)
        return;

    for (var i = 0; i < length; i++) {
        quality = qualitys[i];
        if (quality.format == format) {
            qualityButton.className = format < 720 ? '' : 'bold';

            if (format < 720)
                qualityButton.innerHTML = 'SD';
            else if (format < 1080)
                qualityButton.innerHTML = 'HD';
            else
                qualityButton.innerHTML = 'Full HD';

            lastTime = video.currentTime || lastTime;
            srcMp4.src = quality.mp4;
            srcWebm.src = quality.webm;

            currentQuality = format;
            video.load();

            video.addEventListener("loadeddata", function() {
                if (typeof embeded == 'undefined' || video.currentTime != 0) {
                    video.currentTime = lastTime; // On remet au même moment
                    video.play();
                }
            });
        }
    }
}
var qualitys;

function setVideo(array) { // On set toutes les qualités au chargement de la page
    qualityButton.style.cursor = array.length <= 1 ? 'default' : 'pointer';

    qualitys = array;
    for (var i = 0, length = qualitys.length; i < length; i++) {
        element = document.createElement("span");
        element.id = 'q' + (i + 1);
        element.innerHTML = qualitys[i].format + 'p';
        element.dataset.format = qualitys[i].format;
        element.addEventListener('click', function() {
            setQuality(this.dataset.format);
        });
        qualitySelection.appendChild(element);
        qualitySelection.dataset.number = i + 1;
    }

    setQuality(array[0].format);
}

/*
 *  SubTiles
 */

var subtitles,
    subtitlesList = document.getElementById('subtitlesList');

document.getElementById('annotationsButton').addEventListener('click', function() {
    subtitlesList.className = !subtitlesList.className ? "hide" : "";
});

function createSubTilte(id, data) {
    element = document.createElement("span");
    element.id = 'sub_title' + (id + 1);
    element.className = 'subtitle';

    if (!(video.currentTime > data.start && video.currentTime < data.end)) {
        element.className += ' hidden';
    }

    element.innerHTML = "<p>" + data.text + "</p>";
    element.dataset.start = data.start;
    element.dataset.end = data.end;

    element.style.left = data.left + '%';
    element.style.top = data.top + '%';
    element.style.width = data.width + '%';
    element.style.minHeight = data.height + '%';

    subtitlesList.appendChild(element);
}

function updateSubTitles() {
    if (subtitles) {
        currentTime = video.currentTime;
        children = subtitlesList.children;

        for (var length = children.length, i = length - 1; i > -1; i--) {
            if (currentTime < children[i].dataset.start || currentTime > children[i].dataset.end) {
                if (children[i].className.search('hidden') < 0)
                    children[i].className += ' hidden';
            }
        }

        for (var i = 0, length = subtitles.length; i < length; i++) {
            if (currentTime > subtitles[i].start && currentTime < subtitles[i].end) {
                if (!document.getElementById('sub_title' + (i + 1)))
                    createSubTilte(i, subtitles[i]);
                else if (document.getElementById('sub_title' + (i + 1)).className.search('hidden'))
                    document.getElementById('sub_title' + (i + 1)).className = document.getElementById('sub_title' + (i + 1)).className.replace('hidden', '');
            }
        }
    }
}

video.addEventListener("timeupdate", updateSubTitles);

function setSubTitles(array) {
    if (array.length) {
        document.getElementById('annotationsButton').style.display = 'block';
        subtitles = array;
        for (var i = 0, length = subtitles.length; i < length; i++) {
            createSubTilte(i, subtitles[i]);
        }
    }
}

/*
 *  Annotations
 */

var annotations,
    annoList = document.getElementById('annoList');

function closeAnnotation(element) {
    element.style.display = 'none';
}

document.getElementById('annotationsButton').addEventListener('click', function() {
    if (!annotationsElement.className) {
        document.getElementById('annotationsButton').className = 'not';
        annotationsElement.className = 'hide';
    } else {
        document.getElementById('annotationsButton').className = '';
        annotationsElement.className = '';
    }
});

function createAnnotation(id, data) { // Création d'une annotation
    element = document.createElement("span");
    element.id = 'ann' + (id + 1);
    element.className = 'annotation ' + (data.color ? data.color : '');

    if (!(video.currentTime > data.start && video.currentTime < data.end))
        element.className += ' hidden';

    element.dataset.start = data.start;
    element.dataset.end = data.end;

    if (data.link) {
        if (typeof annoTimeLine == 'undefined')
            element.innerHTML = "<a href=" + data.link + " target=\"_blank\">" + data.text + "</a>";
        else
            element.innerHTML = "<a href=" + data.link + " contentEditable=\"true\" target=\"_blank\" onkeydown=\"keyPressAnno(event, this.parentNode);\">" + data.text + "</a>";
    } else {
        if (typeof annoTimeLine == 'undefined')
            element.innerHTML = "<p>" + data.text + "</p>";
        else
            element.innerHTML = "<p contentEditable=\"true\" onkeydown=\"keyPressAnno(event, this.parentNode);\">" + data.text + "</p>";
    }

    if (typeof annoTimeLine == 'undefined')
        element.innerHTML += "<span class=\"close\" onclick=\"closeAnnotation(this.parentNode);\"></span>";

    element.style.left = data.left + '%';
    element.style.top = data.top + '%';
    element.style.width = data.width + '%';
    element.style.minHeight = data.height + '%';

    element.addEventListener('click', function() {
        setQuality(this.dataset.format);
    });

    if (typeof annoTimeLine != 'undefined')
        annotDraggable(element);

    annotationsElement.appendChild(element);
}

function updateAnnotations() {
    if (annotations) {
        currentTime = video.currentTime;
        children = annotationsElement.children;

        for (var length = children.length, i = length - 1; i > -1; i--) {
            if (currentTime < children[i].dataset.start || currentTime > children[i].dataset.end) {
                if (children[i].className.search('hidden') < 0)
                    children[i].className += ' hidden';
            }
        }

        for (var i = 0, length = annotations.length; i < length; i++) {
            if (currentTime > annotations[i].start && currentTime < annotations[i].end) {
                if (!document.getElementById('ann' + (i + 1)))
                    createAnnotation(i, annotations[i]);
                else if (document.getElementById('ann' + (i + 1)).className.search('hidden'))
                    document.getElementById('ann' + (i + 1)).className = document.getElementById('ann' + (i + 1)).className.replace('hidden', '');
            }
        }
    }
}

video.addEventListener("timeupdate", updateAnnotations);

function setAnnotations(array) { // On set toutes les annotations au chargement de la page
    if (array.length) {
        document.getElementById('annotationsButton').style.display = 'block';
        annotations = array;
        for (var i = 0, length = annotations.length; i < length; i++) {
            createAnnotation(i, annotations[i]);

            if (typeof annoTimeLine != 'undefined')
                createAnnotationInList(i, annotations[i])
        }
    }
}

/*
 *  Raccourcis claviers
 */

document.addEventListener("keydown", function(event) {
    if (event.target != document.body)
        return;

    if (event.keyCode == 32) { // [espace]
        playPause();
        upPlayer();
    }

    if (event.keyCode == 70) // [F]
        toogleFullScreen();

    if (event.keyCode == 36) { // [début]
        video.currentTime = 0;
        video.play();
        progress.viewed.style.width = '0%';
        progress.current.style.left = '0%';
    }

    if (event.keyCode == 35) { // [fin]
        video.currentTime = video.duration;
        progress.viewed.style.width = '100%';
        progress.current.style.left = '100%';
    }

    if (event.keyCode == 38) { // [haut]
        lastVolume = video.volume;
        video.volume = Math.min(video.volume + 0.1, 1);

        if (lastVolume != video.volume)
            volumeChange();
    }

    if (event.keyCode == 40) { // [bas]
        lastVolume = video.volume;
        video.volume = Math.max(video.volume - 0.1, 0);

        if (lastVolume != video.volume)
            volumeChange();
    }

    if (event.keyCode == 37) // [gauche]
        video.currentTime -= 3;

    if (event.keyCode == 39) // [droite]
        video.currentTime += 3;
});

/**
 * CHROME CAST
 */

var chromecastplayicon = document.getElementById("chromecastplayicon"),
    currentMedia = null,
    currentSession = null;
    mediaCurrentTime = 0,
    chromecastTimer = null;

chromecastplayicon.addEventListener("click", function() {

    chrome.cast.requestSession(function(session) {

        currentSession = session;

        var mediaInfo = new chrome.cast.media.MediaInfo("http://dreamvids.fr/uploads/Dimou/AxRw02.webm_640x360p.mp4");
        mediaInfo.contentType = "video/mp4";

        var request = new chrome.cast.media.LoadRequest(mediaInfo);
        request.autoplay = true;
        request.currentTime = 0;
        
        //var payload = {
        //  "title:" : mediaTitles[i],
        //  "thumb" : mediaThumbs[i]
        //};

        //var json = {
        //  "payload" : payload
        //};

        //request.customData = json;

        currentSession.loadMedia(request, onMediaDiscovered.bind(this, "loadMedia"), function() {

            console.error("Erreur lors du lancement de la vidéo.");

        });

    }, function() {

        console.error("Erreur lors du lancement de l'application.");

    });

});

function onMediaDiscovered(how, media) {

    currentMedia = media;
    currentMedia.addUpdateListener(onMediaStatusUpdate);
    mediaCurrentTime = currentMedia.currentTime;

    

}

function onMediaStatusUpdate(isAlive) {

    if (currentMedia.playerState === "PLAYING") {

        mediaCurrentTime = currentMedia.currentTime;

        chromecastTimer = setInterval(function() {

            mediaCurrentTime ++;
            console.log(mediaCurrentTime);

        }, 1000);

    }

    else {

        clearInterval(chromecastTimer);

    }

}

function sessionListener(event) {

    console.log("New session ID: " + event.sessionId);
    currentSession = event;

    if (currentSession.media.length != 0) {

        console.log("Found " + currentSession.media.length + " existing media sessions.");
        onMediaDiscovered("sessionListener", currentSession.media[0]);

    }

    currentSession.addMediaListener(onMediaDiscovered.bind(this, "addMediaListener"));
    currentSession.addUpdateListener(sessionUpdateListener.bind(this)); 

}

function sessionUpdateListener(isAlive) {

    if (!isAlive) {

        currentSession = null;

        if (chromecastTimer) {

            clearInterval(chromecastTimer);

        }

    }

}

function receiverListener(event) {

    if (event === "available" ) {

        chromecastplayicon.style.display = "block";

        setTimeout(function() {

            chromecastplayicon.className += " show";

        }, 10);

    }

}

window.addEventListener("load", function() {
    
    if (!chrome.cast || !chrome.cast.isAvailable) {

        setTimeout(function() {

            var applicationID = chrome.cast.media.DEFAULT_MEDIA_RECEIVER_APP_ID;
            var sessionRequest = new chrome.cast.SessionRequest(applicationID);
            var apiConfig = new chrome.cast.ApiConfig(sessionRequest, sessionListener, receiverListener);
            
            chrome.cast.initialize(apiConfig, function onInitSuccess() {}, function() {

                console.error("Erreur lors de l'initialisation de ChromeCast.")

            });

        }, 1000);

    }

}, false);
function subscribeAction(channel) {
	var button = document.getElementById('subscribe-button');

	if(hasClass(button, 'subscribed')) {
		ajax.get(channel + '/unsubscribe/', {});
	}
	else {
		ajax.get(channel + '/subscribe/', {});
	}
}
var uploader = document.getElementById('uploader');
var uploadInput = document.getElementById('upload-input');
var fileName = document.getElementById('file-name');
var progressBar = document.getElementById('progress-bar');

var timeUpload = {
	started: 0,
	current: 0
};

function cancelUpload() {
	if (!uploadHttpRequest)
		return false;

	uploadHttpRequest.abort();
	uploadInput.removeAttribute('disabled');
}

function tempsRestant(timestamp) {
	var seconds = Math.round(timestamp / 1000);
	var minutes = Math.round(seconds / 60);
	var heures = Math.round(minutes / 60);

	if (seconds < 1)
		return "une seconde";
	else if (seconds < 60)
		return seconds + " secondes";
	else if (minutes === 1)
		return minutes + " une minute";
	else if (minutes < 14)
		return minutes + " minutes";
	else if (minutes < 16)
		return "un quart d'heures";
	else if (minutes < 29)
		return minutes + " minutes";
	else if (minutes < 31)
		return "une demi heure";
	else if (minutes < 55)
		return minutes + " minutes";
	else if (minutes < 65)
		return "une heure";
	else if (minutes < 120)
		return "une heure";
	else if (minutes < 1440)
		return heures + " heures";
	else
		return "trÃ¨s longtemps";
}

function submitVideoInfo() {
	var title = document.getElementById('video-title').value;
	var description = document.getElementById('video-description').value;
	var tags = document.getElementById('video-tags').value;
	var thumb = document.getElementById('video-tumbnail').files[0];
	var visibility = document.getElementById('video-visibility').value;

	ajax.post('upload/', {'videoTitle' : title, 'videoDescription' : description, 'videoTags': tags, 'videoVisibility' : visibility});

	var postRequest = new XMLHttpRequest();
	postRequest.open('POST', 'upload/addthumb');

	var thumbForm = new FormData();
	thumbForm.append('videoThumbnail', document.getElementById('video-tumbnail').files[0]);

	postRequest.send(thumbForm);
}

uploadInput.addEventListener('change', function(event) {
	var extension = uploadInput.value.split('.')[uploadInput.value.split('.').length - 1].toLowerCase();
	var validsExtensions = ['webm', 'mp4', 'mov', 'avi', 'wmv', 'ogg', 'ogv'];

	if (validsExtensions.indexOf(extension) != -1) {

		ajax.get('upload/preprocess');

		uploader.className = uploader.className.replace(' hover', '');
		uploader.className = 'uploading';

		var name = uploadInput.files[0].name.replace(/\.[0-9a-z]+$/i, '');
		fileName.innerHTML = name;
		if (document.getElementById('video-title').value == '') {
			document.getElementById('video-title').value = name;
		}

		uploadInput.setAttribute('disabled', '');
		document.getElementById('up-submit').removeAttribute('disabled');

		uploadHttpRequest = new XMLHttpRequest();
		uploadHttpRequest.open('POST', 'upload/process/');

		uploadHttpRequest.upload.onprogress = function(event) {
			timeUpload.current = new Date().getTime();
			var totalTime = (timeUpload.current - timeUpload.started) * event.total / event.loaded
			time = totalTime - (timeUpload.current - timeUpload.started);

			restant = tempsRestant(time);

			progressBar.dataset['restant'] = restant;

			percent = Math.round((event.loaded / event.total) * 100);
			progressBar.style.width = progressBar.dataset['percent'] = percent + '%';

			document.title = percent != 100 ? percent + '% | ' + restant + " restant" : 'Upload terminé';
		};

		uploadHttpRequest.onload = function() {
			uploader.className = 'uploaded';
			progressBar.style.width = '100%';
		};

		var form = new FormData();
		form.append('videoInput', uploadInput.files[0]);

		uploadHttpRequest.send(form);
		timeUpload.started = new Date().getTime();
	} else {
		alert("Type de fichier incorrect");
	}
}, false);
function hasClass(element, theClass) {
    return (' ' + element.className + ' ').indexOf(' ' + theClass + ' ') > -1;
}

/**
 * Votes
 */

function votePlus(vid, element) {

    var plusElement = element,
        moinsElement = document.createElement("div"),
        elements = element.parentNode.childNodes;

    for (var i = 0; i < elements.length; i++) {

        if (elements[i].className && elements[i].className.search("moins") > -1) {

            moinsElement = elements[i];

        }

    }

    if (plusElement.className.search("active") > -1) {

        plusElement.className = plusElement.className.replace("active", "")
        plusElement.innerHTML = parseInt(plusElement.innerHTML) - 1;

        ajax.get("unlike/" + vid, {});

    }

    else {

        plusElement.className = plusElement.className + " active";
        plusElement.innerHTML = parseInt(plusElement.innerHTML) + 1;

        ajax.get("like/" + vid, {});

        if (moinsElement.className.search("active") > -1) {

            moinsElement.className = moinsElement.className.replace("active", "");
            moinsElement.innerHTML = parseInt(moinsElement.innerHTML) - 1;

            ajax.get("undislike/" + vid, {});

        }

    }

}

function voteMoins(vid, element) {

    var moinsElement = element,
        plusElement = document.createElement("div"),
        elements = element.parentNode.childNodes;

    for (var i = 0; i < elements.length; i++) {

        if (elements[i].className && elements[i].className.search("plus") > -1) {

            plusElement = elements[i];

        }

    }

    if (moinsElement.className.search("active") > -1) {

        moinsElement.className = moinsElement.className.replace("active", "")
        moinsElement.innerHTML = parseInt(moinsElement.innerHTML) - 1;

        ajax.get("undislike/" + vid, {});

    }

    else {

        moinsElement.className = moinsElement.className + " active";
        moinsElement.innerHTML = parseInt(moinsElement.innerHTML) + 1;

        ajax.get("dislike/" + vid, {});

        if (plusElement.className.search("active") > -1) {

            plusElement.className = plusElement.className.replace("active", "");
            plusElement.innerHTML = parseInt(plusElement.innerHTML) - 1;

            ajax.get("unlike/" + vid, {});

        }

    }

}