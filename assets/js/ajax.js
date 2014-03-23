/*
 *  Ajax 1.3.0
 *  Librairie pour envoyer et recevoir des informations simplement avec Ajax
 *
 *  [1.3.0] Callback dÃ©sormais dans des "promises"
 *
 *  ajax.js
 */

var ajax = function(method, url, object) {
    if (method == 'GET') {
        url += '?';
        for (var key in object) {
            url += object.hasOwnProperty(key) ? '&' + key + '=' + object[key] : '';
        }
    } else {
        postData = '?';
        for (var key in object) {
            postData += object.hasOwnProperty(key) ? '&' + key + '=' + object[key] : '';
        }
    }

    this.xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

    this.then = function(callback) {
        this.xhr.callback = callback;
    };

    this.xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200 && this.callback) {
            this.callback(this);
        }
    };

    this.xhr.open(method, url, true);
    this.xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    this.xhr.send(typeof postData != 'undefined' ? postData : null);

    return this;
};

ajax.get = function(url, object) {
    return ajax('GET', url, object);
},

ajax.post = function(url, object) {
    return ajax('POST', url, object);
};