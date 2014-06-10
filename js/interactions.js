// Variables
var body = document.body;

var button_nav_mobile = document.getElementById('mobile-nav-icon') || document.createElement('div');
var nav = document.getElementsByTagName('nav')[0] || document.createElement('div');

var button_user_info = document.getElementById("top-nav-user-information-button") || document.createElement('div');
var user_info_menu = document.getElementById("top-nav-user-information-menu") || document.createElement('div');

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
    user_info_menu.className = user_info_menu.className != 'show' ? 'show' : '';
});

body.addEventListener('click', function(event) {
    user_info_menu.className = event.target.id != 'top-nav-user-information-button' && event.target.parentNode.id != 'top-nav-user-information-button' ? '' : user_info_menu.className;
});