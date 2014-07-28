
/**
 * Video actions
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

        // Unlike video
        marmottajax.put({
            'url': '../videos/' + vid,
            'options': { unlike: true }
        });

    }

    else {

        plusElement.className = plusElement.className + " active";
        plusElement.innerHTML = parseInt(plusElement.innerHTML) + 1;

        // Like video
        marmottajax.put({
            'url': '../videos/' + vid,
            'options': { like: true }
        });

        if (moinsElement.className.search("active") > -1) {

            moinsElement.className = moinsElement.className.replace("active", "");
            moinsElement.innerHTML = parseInt(moinsElement.innerHTML) - 1;

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

        // Undislike video
        marmottajax.put({
            'url': '../videos/' + vid,
            'options': { undislike: true }
        });

    }

    else {

        moinsElement.className = moinsElement.className + " active";
        moinsElement.innerHTML = parseInt(moinsElement.innerHTML) + 1;

        // Dislike video
        marmottajax.put({
            'url': '../videos/' + vid,
            'options': { dislike: true }
        });

        if (plusElement.className.search("active") > -1) {

            plusElement.className = plusElement.className.replace("active", "");
            plusElement.innerHTML = parseInt(plusElement.innerHTML) - 1;

        }

    }

}

function flag(vid) {

    if(confirm("Attention ! Cette video sera envoyée aux moderateurs ! Voulez-vous continuer ?")) {

        marmottajax.put({

            'url': '../videos/' + vid,

            'options': { flag: true }

        });

    }
}