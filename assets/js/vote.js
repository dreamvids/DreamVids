
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