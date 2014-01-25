/*
 *	Player
 */

player = document.getElementById('player');

video = document.getElementsByTagName('video')[0];

controls = document.getElementById('controls');

playPauseElement = document.getElementById('play-pause');

playPauseElement.addEventListener("click", playPause);
video.addEventListener("click", playPause);
time = document.getElementById('time');

function playPause() { // Fonction appelée à chaque play/pause effectué
    if (video.paused) {
        video.play();
        playPauseElement.style.backgroundImage = "url(dreamplayer/dreamplayer/img/player/pause.png)";
    } else {
        video.pause();
        playPauseElement.style.backgroundImage = "url(dreamplayer/img/player/play.png)";
    }
}

function time2str(time) { // Transformation du temps [int] en 13:37
    minutes = Math.floor(time / 60);
    minutes = '00'.substring(0, 2 - ('' + minutes).length) + ('' + minutes);
    seconds = Math.floor(time - minutes * 60);
    seconds = '00'.substring(0, 2 - ('' + seconds).length) + ('' + seconds);
    hours = Math.floor(time / 3600);
    hours = '00'.substring(0, 2 - ('' + hours).length) + ('' + hours);

    return (hours != '00' ? hours + ':' : '') + minutes + ':' + seconds;
}
video.addEventListener("canplay", function() { // Au chargement de la page, on définit le bon icone (play ou pause)
    if (video.duration)
        time.innerHTML = time2str(video.currentTime) + ' / ' + time2str(video.duration);

    if (video.paused)
        playPauseElement.style.backgroundImage = "url(dreamplayer/img/player/play.png)";
    else
        playPauseElement.style.backgroundImage = "url(dreamplayer/img/player/pause.png)";
});

bigPlay = document.getElementById('bigPlay');
bigPlay.addEventListener('webkitAnimationEnd', function() {
    this.style.webkitAnimationName = '';
}, false);

bigPause = document.getElementById('bigPause');
bigPause.addEventListener('webkitAnimationEnd', function() {
    this.style.webkitAnimationName = '';
}, false);
video.addEventListener("pause", function() { // Animation du "pause"
    if (video.currentTime != video.duration)
        bigPause.style.webkitAnimationName = 'bigIconPause';
});

progress = document.getElementById('progress');
progress.buffered = document.getElementById('buffered');
progress.viewed = document.getElementById('viewed');
progress.current = document.getElementById('current');

video.addEventListener("timeupdate", function(event) { // Mise à jour de la progressbar
    percent = video.currentTime / video.duration * 100 + "%"
    progress.viewed.style.width = percent;
    progress.current.style.left = percent;
    if (video.duration)
        time.innerHTML = time2str(video.currentTime) + ' / ' + time2str(video.duration);
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
        video.currentTime = (event.clientX - getOffset(controls)) / progress.offsetWidth * video.duration;
});
document.addEventListener("mouseup", function(event) {
    progress.className = '';
    mouseDown = false;
});

document.addEventListener("mousemove", function(event) {
    if (mouseDown) {
        progress.className = 'clicking';
        percent = (event.clientX - getOffset(controls)) / progress.offsetWidth * 100 + "%"
        progress.viewed.style.width = percent;
        progress.current.style.left = percent;
        video.currentTime = (event.clientX - getOffset(controls)) / progress.offsetWidth * video.duration;
    }
});

document.addEventListener("keydown", function(event) { // [space] -> play/pause
    if (event.keyCode == 32)
        playPause();
});

var lastTime;

function downPlayer() { // Les controles disparaissent
    lastTime = new Date().getTime();
    video.style.cursor = 'none';
    controls.className = 'down';
}
var timeout = setTimeout(downPlayer, 3000);

function upPlayer() { // Les controles réaparaisent
    if (new Date().getTime() - 300 < lastTime)
        return;

    video.style.cursor = 'default';
    controls.className = '';

    clearTimeout(timeout);
    timeout = setTimeout(downPlayer, 3000);
}

player.addEventListener("mousemove", upPlayer);

video.addEventListener("mousedown", function(event) {
    upPlayer();
});

/*
 *	Fullscreen
 */

fullscreen = document.getElementById('fullscreen');
fullscreen.addEventListener("click", toogleFullScreen);

function toogleFullScreen() {
    if (!document.webkitFullscreenElement && !document.mozFullscreenElement && !document.fullscreenElement) { // Mettre en plein écran
        fullscreen.style.backgroundImage = "url(dreamplayer/img/player/lowscreen.png)";
        if (player.webkitRequestFullScreen)
            player.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        else if (player.mozRequestFullScreen)
            player.mozRequestFullScreen();
        else if (player.requestFullScreen)
            player.requestFullScreen();
    } else { // Enlever le plein-écran
        fullscreen.style.backgroundImage = "url(dreamplayer/img/player/fullscreen.png)";
        if (document.webkitExitFullscreen)
            document.webkitExitFullscreen();
        else if (document.mozCancelFullScreen)
            document.mozCancelFullScreen();
        else if (document.exitFullscreen)
            document.exitFullscreen();
    }
}

video.addEventListener("dblclick", function() {
    toogleFullScreen();
});

player.addEventListener('webkitfullscreenchange', function(event) {
    if (!document.webkitFullscreenElement)
        fullscreen.style.backgroundImage = "url(dreamplayer/img/player/fullscreen.png)";
}, false);
player.addEventListener('mozfullscreenchange', function(event) {
    if (!document.mozFullscreenElemen)
        fullscreen.style.backgroundImage = "url(dreamplayer/img/player/fullscreen.png)";
}, false);
player.addEventListener('fullscreenchange', function(event) {
    if (!document.fullscreenElement)
        fullscreen.style.backgroundImage = "url(dreamplayer/img/player/fullscreen.png)";
}, false);

window.addEventListener("orientationchange", function() { // Semi plein-écran en orientation paysage (mobile)
    if (window.orientation == 90 || window.orientation == -90)
        player.className = 'semiFullScreen';
    else
        player.className = '';
}, false);

window.addEventListener("resize", function(event) { // Player responsive
    if (document.body.clientWidth < 640)
        player.style.height = document.body.clientWidth / (16 / 9) + 'px';
    else
        player.style.height = '';
}, false);

window.addEventListener("load", function(event) {
    if (document.body.clientWidth < 640)
        player.style.height = document.body.clientWidth / (16 / 9) + 'px';
}, false);

/*
 *	Volume
 */

volume = document.getElementById('volume');
volume.barre = document.getElementById('barre');
volume.icon = document.getElementById('icon');

video.addEventListener("volumechange", function(event) {
    percent = video.volume * 100 + "%";
    volume.barre.style.width = percent;
    volume.icon.style.left = percent;
    if (video.volume <= 0.05) // Génération de l'image
        volume.icon.style.backgroundImage = "url(dreamplayer/img/player/volume0.png)";
    else if (video.volume <= 0.4)
        volume.icon.style.backgroundImage = "url(dreamplayer/img/player/volume1.png)";
    else if (video.volume <= 0.6)
        volume.icon.style.backgroundImage = "url(dreamplayer/img/player/volume2.png)";
    else if (video.volume >= 0.6)
        volume.icon.style.backgroundImage = "url(dreamplayer/img/player/volume3.png)";
}, false);

mouseDownVolume = false;
volume.addEventListener("mousedown", function(event) { // Déplacement de la "barre" de volume
    mouseDownVolume = true;
    newVolume = (event.clientX - getOffset(volume)) / volume.offsetWidth;
    newVolume = newVolume < 0 ? 0 : (newVolume > 1 ? 1 : newVolume);
    video.volume = newVolume;
});
document.addEventListener("mouseup", function(event) {
    mouseDownVolume = false;
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
});

repeat = document.getElementById('repeat'); // Affichage de repeat en fin de vidéo

video.addEventListener("ended", function() {
    repeat.className = 'show';
});
repeat.addEventListener("click", function() {
    repeat.className = '';
    video.currentTime = 0;
    playPause();
});
video.addEventListener("play", function() {
    repeat.className = '';
});

/*
 *	Qualité
 */

var lastTime = 0;

var currentQuality;
qualitySelection = document.getElementById('qualitySelection'); // On ferme
qualitySelection.addEventListener('click', function() {
    qualitySelection.className = '';
});

qualityButton = document.getElementById('qualityButton'); // On ouvre
qualityButton.addEventListener('click', function() {
    if (qualitys.length > 1) // S'il y a plusieurs qualités...
        qualitySelection.className = 'show';
});

function setQuality(format) { // On change la qualité
    qualitySelection.className = '';
    length = qualitys.length;
    if (currentQuality == format)
        return;
    for (var i = 0; i < length; i++) {
        quality = qualitys[i];
        if (quality.format == format) {
            if (format < 720)
                qualityButton.innerHTML = 'SD';
            else if (format < 1080)
                qualityButton.innerHTML = 'HD';
            else
                qualityButton.innerHTML = 'Full HD';

            lastTime = video.currentTime || lastTime;
            if (video.canPlayType('video/mp4')) // Changement de l'url
                video.src = quality.mp4;
            else if (video.canPlayType('video/webm'))
                video.src = quality.webm;
            else
                video.src = quality.ogg;

            currentQuality = format;
            video.load();

            video.addEventListener("loadeddata", function() {
                video.currentTime = lastTime; // On remet au même moment
                if (lastTime > 0)
                    video.play();
            });
        }
    }
}
var qualitys;

function videoQuality(array) { // On set toutes les qualités au chargement de la page
    if (array.length <= 1)
        qualityButton.style.cursor = 'default';
    else
        qualityButton.style.cursor = 'pointer';

    qualitys = array;
    length = qualitys.length;
    for (var i = 0; i < length; i++) {
        element = document.createElement("span");
        element.id = 'q' + (i + 1);
        element.dataset.format = qualitys[i].format;
        element.addEventListener('click', function() {
            setQuality(this.dataset.format);
        });
        qualitySelection.appendChild(element);
        qualitySelection.dataset.number = i + 1;
    }

    setQuality(360);
}
