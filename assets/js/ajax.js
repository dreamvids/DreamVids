var ajax = function(method, object, callback) {
    url = 'index.php?page=ajax';
    if (object) {
        for (var key in object)
            url += object.hasOwnProperty(key) ? '&' + key + '=' + object[key] : '';
    }

    if (window.XMLHttpRequest)
        waiting = new XMLHttpRequest();
    else
        waiting = new ActiveXObject("Microsoft.XMLHTTP");

    waiting.callback = callback ? callback : false;

    waiting.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200 && this.callback)
            this.callback(this);
    };

    waiting.open(method, url, true);
    waiting.send();

    ajax.list.push(waiting);
};
ajax.list = [],

ajax.get = function(object, callback) {
    ajax('GET', object, callback);
},

ajax.post = function(object, callback) {
    ajax('POST', object, callback);
};

function subscribe(dr_id) {
    var button = document.getElementById('subscribe-' + dr_id);
    button.onclick = function() {
        unsubscribe(dr_id);
    };
    button.className = 'btn btn-danger';
    button.onmouseover = function() {
        button.innerHTML = button.getAttribute("data-onmouseover");
    };
    button.onmouseout = function() {
        button.innerHTML = button.getAttribute("data-unsubscribe");
    };
    button.innerHTML = button.getAttribute("data-unsubscribe");
    ajax.post({
        action: 'subscribe',
        dr_id: dr_id
    });
}

function unsubscribe(dr_id) {
    var button = document.getElementById('subscribe-' + dr_id);
    button.onclick = function() {
        subscribe(dr_id);
    };
    button.className = 'btn btn-success';
    button.onmouseover = function() {
        return false;
    };
    button.onmouseout = function() {
        return false;
    };
    button.innerHTML = button.getAttribute("data-subscribe") + ' (' + button.getAttribute("data-subscribers") + ')';
    ajax.post({
        action: 'unsubscribe',
        dr_id: dr_id
    });
}

function comment(vid, username, comment) {
    var newCom = document.getElementById('new_comments');
    newCom.innerHTML = getCommentHTML(username, comment) + newCom.innerHTML;
    document.getElementById('text_comment').value = '';
    ajax.post('index.php?page=ajax&action=comment&vid=' + vid, 'comment=' + encodeURIComponent(comment));
}

function getCommentHTML(username, comment) {
    var date = new Date();
    return '<div class="panel panel-default" style="width: 100%;"><div class="panel-heading"><h5>' + username + ' <small>' + date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds() + '</small></h5></div><div class="panel-body"><p>' + noHTML(comment) + '</p></div></div>';
}

function noHTML(str) {
    return str.replace('<', '&lt;').replace('>', '&gt;');
}