// Variables
var body = document.getElementById('page');

var button_nav_mobile = document.getElementById('mobile-nav-icon') || document.createElement('div');
var nav = document.getElementsByTagName('nav')[0] || document.createElement('div');

var button_user_info = document.getElementById("top-nav-user-information-button") || document.createElement('div');
var user_info_menu = document.getElementById("top-nav-user-information-menu") || document.createElement('div');
var hover_subscribe = document.getElementById("hover_subscribe") || document.createElement('div');

var subscribe_button = document.getElementById("subscribe-button") || document.createElement('div');

// Menu utilisateur

button_nav_mobile.addEventListener('click', function() {
    if (button_nav_mobile.className == "open") {
        button_nav_mobile.className = '';
        nav.className = '';
    } else {
        button_nav_mobile.className = "open";
        nav.className = "open";
    }
});


button_user_info.addEventListener('click', function() {
    user_info_menu.style.display = user_info_menu.style.display != 'inline' ? 'inline' : 'none';
});

body.addEventListener('click', function(event) {
    user_info_menu.style.display = event.target.id != 'top-nav-user-information-button' && event.target.parentNode.id != 'top-nav-user-information-button' ? 'none' : user_info_menu.style.display;
});

hover_subscribe.addEventListener('click', function() {
    if (hover_subscribe.className == 'subscribed') {
        hover_subscribe.className = '';
        hover_subscribe.childNodes[0].innerHTML = "S'abonner";
        ajax.post({
            action: 'unsubscribe',
            dr_id: hover_subscribe.dataset.vid
        });
    } else {
        hover_subscribe.className = 'subscribed';
        hover_subscribe.childNodes[0].innerHTML = "AbonnÃ©";
        ajax.post({
            action: 'subscribe',
            dr_id: hover_subscribe.dataset.vid
        });
    }
});

// S'abonner sur une page chaine

subscribe_button.addEventListener('click', function() {
    if (subscribe_button.className == 'subscribed') {
        subscribe_button.className = '';
        subscribe_button.innerHTML = subscribe_button.dataset.text.split('|')[0];
        ajax.post({
            action: 'unsubscribe'
        });
    } else {
        subscribe_button.className = 'subscribed';
        subscribe_button.innerHTML = subscribe_button.dataset.text.split('|')[1];
        ajax.post({
            action: 'subscribe'
        });
    }
});