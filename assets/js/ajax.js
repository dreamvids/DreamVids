/*
 *  Ajax 1.3.1
 *  Librairie pour envoyer et recevoir des informations simplement avec Ajax
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

    this.success = function(callback) {
        this.xhr.callbackSuccess = callback;
        return this;
    };

    this.error = function(callback) {
        this.xhr.callbackError = callback;
        return this;
    };

    this.xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status == 200 && this.callbackSuccess && typeof(this.callbackSuccess) == "function") {
            this.callbackSuccess(this);
        } else if (this.readyState === 4 && this.status == 404 && this.callbackError && typeof(this.callbackError) == "function") {
            this.callbackError('404');
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