
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

    var channel = hover_subscribe.dataset.channel;

    if (hover_subscribe.className == "subscribed") {

        hover_subscribe.className = "";

        for (var i = 0; i < hover_subscribe.childNodes.length; i++) {

            if (hover_subscribe.childNodes[i].tagName === "I") {

                hover_subscribe.childNodes[i].innerHTML = "S'abonner";

            }

        }

        marmottajax.put({

            url: _webroot_ + "channel/" + channel,
            options: { unsubscribe: true }

        });

    }

    else {

        hover_subscribe.className = "subscribed";

        for (var i = 0; i < hover_subscribe.childNodes.length; i++) {

            if (hover_subscribe.childNodes[i].tagName === "I") {

                hover_subscribe.childNodes[i].innerHTML = "Abonné";

            }

        }

        marmottajax.put({

            url: _webroot_ + "channel/" + channel,
            options: { subscribe: true }

        });

    }

});

// S'abonner sur une page chaine

var subscribe_button = document.getElementById("subscribe-button") || document.createElement("div");

subscribe_button.addEventListener("click", function() {

    var channel = subscribe_button.dataset.id;

    if (subscribe_button.className == "subscribed") {

        subscribe_button.className = "";
        subscribe_button.innerHTML = subscribe_button.dataset.text.split("|")[0];

        marmottajax.put({

            url: _webroot_ + "channel/" + channel,
            options: { unsubscribe: true }

        });

    }

    else {

        subscribe_button.className = "subscribed";
        subscribe_button.innerHTML = subscribe_button.dataset.text.split("|")[1];

        marmottajax.put({

            url: _webroot_ + "channel/" + channel,
            options: { subscribe: true }

        });

    }

});