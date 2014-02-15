var annoTimeLine = true,
    player = document.getElementById('player'),
    video = player.getElementsByTagName('video')[0],
    selectedTools = document.getElementById('selectedTools');

function offsetX(object) {
    if (document.webkitFullscreenElement || document.mozFullscreenElement || document.fullscreenElement)
        return object.offsetLeft;

    var x = 0;
    element = object;
    while (element) {
        x += (element.offsetLeft - (element == document.body ? 0 : element.scrollLeft) + element.clientLeft);
        element = element.offsetParent;
    }
    return x;
}

function offsetY(object) {
    if (document.webkitFullscreenElement || document.mozFullscreenElement || document.fullscreenElement)
        return object.offsetLeft;

    var y = 0;
    element = object;
    while (element) {
        y += (element.offsetTop - (element == document.body ? 0 : element.scrollTop) + element.clientTop);
        element = element.offsetParent;
    }
    return y;
}

selectedAnnotation = null;

resizeElement = null;
dragElement = null;
elementId = null;
dragListElement = null;
resizeLeftListElement = null;
resizeRightListElement = null;

mouseX = 0;
mouseY = 0;

lastElementX = 0;
lastElementY = 0;

lastElementWidth = 0;
lastElementHeight = 0;

function deleteAnnotation(element) {
    selectedTools.style.display = 'none';
    annotations.splice(parseInt(element.id.slice(3)) - 1, 1);
    annotationsElement.innerHTML = '';
    annoList.innerHTML = '';
    setAnnotations(annotations);
}

function keyPressAnno(event, element) {
    if (event.keyCode == 46)
        deleteAnnotation(element);
}

function videoDurationLoaded() {
    allAnnotInList = annoList.children;
    for (tag in allAnnotInList) {
        if (allAnnotInList.hasOwnProperty(tag) && allAnnotInList[tag].nodeName) {
            annotation = allAnnotInList[tag];
            annotation.style.opacity = 1;
            annotation.style.left = annotation.dataset.start / video.duration * 100 + '%';
            annotation.style.width = (annotation.dataset.end - annotation.dataset.start) / video.duration * 100 + '%';
        }
    }
}

video.addEventListener('durationchange', videoDurationLoaded, false);

function createAnnotationInList(id, data) {
    annotInList = document.createElement("li");
    annotInList.id = 'annList' + (id + 1);
    annotInList.className = (data.color ? data.color : '');
    annotInList.innerHTML = '<p class="resizeLeft"></p><p>' + data.text + '</p><p class="resizeRight"></p>';

    annotInList.dataset.start = data.start;
    annotInList.dataset.end = data.end;

    annotInList.addEventListener('mousedown', function(event) {
        selectAnnotation(parseInt(this.id.slice(7)) - 1);
        element = event.target.nodeName.toLowerCase() === 'p' || event.target.nodeName.toLowerCase() === 'a' ? event.target.parentNode : event.target;
        elementId = parseInt(element.id.slice(7)) - 1;

        annoTimeLine = document.getElementById('annoTimeLine');

        if (event.target.className == 'resizeLeft') {
            resizeLeftListElement = element;

            lastElementX = (offsetX(resizeLeftListElement) - offsetX(annoTimeLine));
            lastElementWidth = resizeLeftListElement.clientWidth / annoTimeLine.clientWidth * 100;
        } else if (event.target.className == 'resizeRight') {
            resizeRightListElement = element;

            lastElementX = event.clientX;
            lastElementWidth = resizeRightListElement.clientWidth / annoTimeLine.clientWidth * 100;
        } else {
            dragListElement = element;
            lastElementX = event.layerX;
        }
    }, false);

    annoList.appendChild(annotInList);

    if (video.duration)
        videoDurationLoaded();
}

function selectAnnotation(id) {
    element = document.getElementById('ann' + (id + 1));
    selectedAnnotation = id;
    annotation = annotations[id];

    document.getElementById('STtitle').value = annotation.text;
    document.getElementById('STleft').value = annotation.left;
    document.getElementById('STtop').value = annotation.top;
    document.getElementById('STwidth').value = annotation.width;
    document.getElementById('STheight').value = annotation.height;

    selectedTools.style.display = 'block';
}

function annotDraggable(element) {
    element.innerHTML += "<span class=\"close\" onclick=\"deleteAnnotation(this.parentNode);\"></span>";

    resizer = document.createElement("p");
    resizer.className = 'resize';

    resizer.addEventListener('mousedown', function(event) {
        if (event.target.className != 'resize')
            return;

        resizeElement = event.target.nodeName.toLowerCase() === 'p' || event.target.nodeName.toLowerCase() === 'a' ? event.target.parentNode : event.target;
        elementId = parseInt(resizeElement.id.slice(3)) - 1;

        lastElementX = event.clientX;
        lastElementY = event.clientY;
        lastElementWidth = resizeElement.clientWidth / player.clientWidth * 100;
        lastElementHeight = resizeElement.clientHeight / player.clientHeight * 100;
    });

    element.appendChild(resizer);

    element.addEventListener('mousedown', function(event) {
        if (event.target.className != 'close')
            selectAnnotation(parseInt(this.id.slice(3)) - 1);
    });

    element.addEventListener('mousedown', function(event) {
        if (event.target.className == 'resize')
            return;

        dragElement = event.target.nodeName.toLowerCase() === 'p' || event.target.nodeName.toLowerCase() === 'a' ? event.target.parentNode : event.target;
        elementId = parseInt(dragElement.id.slice(3)) - 1;

        lastElementX = event.layerX;
        lastElementY = event.layerY;
    }, false);

    element.addEventListener('DOMCharacterDataModified', function(event) {
        if (document.activeElement !== document.getElementById('STtitle')) {
            document.getElementById('annList' + parseInt(this.id.slice(3))).innerHTML = '<p class="resizeLeft"></p><p>' + event.newValue + '</p><p class="resizeRight"></p>';
            annotations[parseInt(this.id.slice(3)) - 1].text = event.newValue;
            selectAnnotation(parseInt(this.id.slice(3)) - 1);
            updateAnnotations();
        }
    }, false);
}

function valueSTchange(newValue) {
    document.getElementById('ann' + (selectedAnnotation + 1)).getElementsByTagName('p')[0].innerHTML = newValue;
    document.getElementById('annList' + (selectedAnnotation + 1)).innerHTML = '<p class="resizeLeft"></p><p>' + newValue + '</p><p class="resizeRight"></p>';
    annotations[selectedAnnotation].text = newValue;
    updateAnnotations();
}

function leftSTchange(input, newValue) {
    annotation = document.getElementById('ann' + (selectedAnnotation + 1));

    newValue = Math.min(100, Math.max(0, parseInt(newValue)));
    if ((newValue / 100 * player.clientWidth + annotation.clientWidth) / player.clientWidth * 100 > 100)
        newValue = 100 - annotation.clientWidth / player.clientWidth * 100;
    newValue = Math.floor(newValue * 10) / 10;

    if (annotation)
        annotation.style.left = newValue + '%';
    input.value = isNaN(newValue) ? 0 : newValue;
    annotations[selectedAnnotation].left = newValue;
    updateAnnotations();
}

function topSTchange(input, newValue) {
    annotation = document.getElementById('ann' + (selectedAnnotation + 1));

    newValue = Math.min(100, Math.max(0, parseInt(newValue)));
    if ((newValue / 100 * player.clientHeight + annotation.clientHeight) / player.clientHeight * 100 > 100)
        newValue = 100 - annotation.clientHeight / player.clientHeight * 100;
    newValue = Math.floor(newValue * 10) / 10;

    annotation.style.top = newValue + '%';
    input.value = isNaN(newValue) ? 0 : newValue;
    annotations[selectedAnnotation].top = newValue;
    updateAnnotations();
}

function widthSTchange(input, newValue) {
    annotation = document.getElementById('ann' + (selectedAnnotation + 1));

    newValue = Math.min(100, Math.max(0, parseInt(newValue)));
    if ((annotation.offsetLeft + newValue / 100 * player.clientWidth) / player.clientWidth * 100 > 100)
        newValue = (player.clientWidth - annotation.offsetLeft) / player.clientWidth * 100;
    newValue = Math.floor(newValue * 10) / 10;

    annotation.style.width = Math.max(10, newValue) + '%';
    input.value = isNaN(newValue) ? 0 : newValue;
    annotations[selectedAnnotation].width = Math.max(10, newValue);
    updateAnnotations();
}

function heightSTchange(input, newValue) {
    annotation = document.getElementById('ann' + (selectedAnnotation + 1));

    newValue = Math.min(100, Math.max(0, parseInt(newValue)));
    if ((annotation.offsetTop + newValue / 100 * player.clientHeight) / player.clientHeight * 100 > 100)
        newValue = (player.clientHeight - annotation.offsetTop) / player.clientHeight * 100;
    newValue = Math.floor(newValue * 10) / 10;

    annotation.style.minHeight = newValue + '%';
    input.value = isNaN(newValue) ? 0 : newValue;
    annotations[selectedAnnotation].height = newValue;
    updateAnnotations();
}

function STsetColor(newColor) {
    document.getElementById('ann' + (selectedAnnotation + 1)).className = 'annotation ' + newColor;
    document.getElementById('annList' + (selectedAnnotation + 1)).className = newColor;
    annotations[selectedAnnotation].color = newColor;
    updateAnnotations();
}

document.onmousemove = function(event) {
    mouseX = document.all ? window.event.clientX : event.pageX;
    mouseY = document.all ? window.event.clientY : event.pageY;

    if (dragElement) {
        newX = (mouseX - offsetX(player) - lastElementX) / player.clientWidth * 100;
        newY = (mouseY - offsetY(player) - lastElementY) / player.clientHeight * 100;

        if ((newX / 100 * player.clientWidth + dragElement.clientWidth) / player.clientWidth * 100 > 100)
            newX = 100 - dragElement.clientWidth / player.clientWidth * 100;
        if ((newY / 100 * player.clientHeight + dragElement.clientHeight) / player.clientHeight * 100 > 100)
            newY = 100 - dragElement.clientHeight / player.clientHeight * 100;

        newX = Math.max(0, newX);
        newY = Math.max(0, newY);

        annotation = annotations[elementId];
        annotation.left = newX;
        annotation.top = newY

        dragElement.style.left = Math.floor(newX * 10) / 10 + "%";
        dragElement.style.top = Math.floor(newY * 10) / 10 + "%";

        selectAnnotation(elementId);
    } else if (resizeElement) {
        newWidth = lastElementWidth + (mouseX - lastElementX) / player.clientWidth * 100;
        newHeight = lastElementHeight + (event.clientY - lastElementY) / player.clientHeight * 100;

        if (lastElementWidth + (resizeElement.offsetLeft + (mouseX - lastElementX)) / player.clientWidth * 100 > 100)
            newWidth = (player.clientWidth - resizeElement.offsetLeft) / player.clientWidth * 100;
        if (lastElementHeight + (resizeElement.offsetTop + (event.clientY - lastElementY)) / player.clientHeight * 100 > 100)
            newHeight = (player.clientHeight - resizeElement.offsetTop) / player.clientHeight * 100;

        newWidth = Math.max(10, newWidth);

        annotation = annotations[elementId];
        annotation.width = newWidth;
        annotation.height = newHeight

        resizeElement.style.width = Math.floor(newWidth * 10) / 10 + "%";
        resizeElement.style.minHeight = Math.floor(newHeight * 10) / 10 + "%";

        selectAnnotation(elementId);
    } else if (dragListElement) {
        annoTimeLine = document.getElementById('annoTimeLine');
        newX = (mouseX - offsetX(annoTimeLine) - lastElementX) / annoTimeLine.clientWidth * 100;

        if ((newX / 100 * annoTimeLine.clientWidth + dragListElement.clientWidth) / annoTimeLine.clientWidth * 100 > 100)
            newX = 100 - dragListElement.clientWidth / annoTimeLine.clientWidth * 100;

        newX = Math.max(0, newX);

        annotations[elementId].start = newX / 100 * video.duration;

        dragListElement.style.left = newX + "%";

        updateAnnotations();
    } else if (resizeLeftListElement) {
        annoTimeLine = document.getElementById('annoTimeLine');
        newLeft = (mouseX - annoTimeLine.offsetLeft) / annoTimeLine.clientWidth * 100;
        newLeft = Math.max(0, newLeft)
        newWidth = lastElementX / annoTimeLine.clientWidth * 100 + lastElementWidth - newLeft;


        resizeLeftListElement.style.width = Math.floor(newWidth * 10) / 10 + "%";
        resizeLeftListElement.style.left = Math.floor(newLeft * 10) / 10 + "%";

        updateAnnotations();
        selectAnnotation(elementId);
    } else if (resizeRightListElement) {
        annoTimeLine = document.getElementById('annoTimeLine');
        newWidth = lastElementWidth + (mouseX - lastElementX) / annoTimeLine.clientWidth * 100;

        if (newWidth + (resizeRightListElement.offsetLeft - annoTimeLine.offsetLeft) / annoTimeLine.clientWidth * 100 > 100)
            newWidth = 100 - (resizeRightListElement.offsetLeft - annoTimeLine.offsetLeft) / annoTimeLine.clientWidth * 100;

        newWidth = Math.max(0, newWidth);

        annotations[elementId].end = annotations[elementId].start + newWidth / 100 * video.duration;
        resizeRightListElement.style.width = Math.floor(newWidth * 10) / 10 + "%";

        updateAnnotations();
        selectAnnotation(elementId);
    }
};

document.onmouseup = function() {
    resizeElement = null;
    dragElement = null;
    elementId = null;
    dragListElement = null;
    resizeLeftListElement = null;
    resizeRightListElement = null;
};

function addAnnotation() {
    end = (video.currentTime + 5) > video.duration ? video.duration : video.currentTime + 5;
    inWait = {
        text: "Texte",
        left: 30,
        top: 40,
        width: 50,
        height: 20,
        start: video.currentTime,
        end: end
    };

    annotations.push(inWait);
    updateAnnotations();
    createAnnotation(annotations.length - 1, annotations[annotations.length - 1]);
    createAnnotationInList(annotations.length - 1, annotations[annotations.length - 1])
}