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