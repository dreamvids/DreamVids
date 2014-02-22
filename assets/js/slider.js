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

var slider = document.getElementById('slider');
var sliderList = document.getElementById('sliderList');

function slideTo(nb) {
    newClass = 'slide' + nb;
    slider.className = sliderList.className = newClass;
}

function slideToNext() {
    nb = parseInt(slider.className.replace('slide', ''));
    nb = nb == 3 ? 1 : nb + 1;
    slider.className = sliderList.className = 'slide' + nb;
}

function slideToPrevious() {
    nb = parseInt(slider.className.replace('slide', ''));
    nb = nb == 1 ? 3 : nb - 1;
    slider.className = sliderList.className = 'slide' + nb;
}


var slideInterval = setInterval(function() {
    if (!slideHover)
        slideToNext();
}, 7000);

var slideHover = false;

slider.addEventListener('mouseover', function() {
    slideHover = true;
}, false);
slider.addEventListener('mouseout', function() {
    slideHover = false;
}, false);


lastTouchX = 0;
slider.addEventListener('touchstart', function(event) {
    if (event.changedTouches[0])
        lastTouchX = event.changedTouches[0].clientX;
}, false);
slider.addEventListener('touchmove', function(event) {
    marginLeft = (event.changedTouches[0].clientX - lastTouchX) / 2;
    slider.childNodes[1].style.marginLeft = slider.childNodes[3].style.marginLeft = slider.childNodes[5].style.marginLeft = marginLeft + 'px';
}, false);
slider.addEventListener('touchend', function(event) {
    slider.childNodes[1].style.marginLeft = slider.childNodes[3].style.marginLeft = slider.childNodes[5].style.marginLeft = 0;
    if (event.changedTouches[0]) {
        moved = lastTouchX - event.changedTouches[0].clientX;
        if (moved < -150)
            slideToPrevious();
        else if (moved > 150)
            slideToNext();
    }
}, false);