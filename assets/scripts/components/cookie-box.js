
/**
 * components/cookie-box.js
 *
 * Script de l'encart cookies
 */

function closeCookie(){
	document.getElementById("cookie-box").style.display="none";
}

function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+d.toUTCString();
	document.cookie = cname + "=" + cvalue + "; " + expires;
}