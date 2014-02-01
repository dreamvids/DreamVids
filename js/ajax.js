function loadAjax() {
	var xhr = null;
	
	if (window.XMLHttpRequest || window.ActiveXObject)
	{
		if (window.ActiveXObject)
		{
			try
			{
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e)
			{
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
		else
		{
			xhr = new XMLHttpRequest(); 
		}
	}
	else
	{
		alert("Votre navigateur ne supporte pas l'objet XMLHttpRequest");
		return null;
	}
	
	return xhr;
}

function ajax(url, post) {
    var xhr = loadAjax();
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
        {
        	
        }
    };
    if (typeof post == 'undefined') {
	    xhr.open("GET", url, true);
	    xhr.send(null);
    }
    else {
    	xhr.open("POST", url, true);
    	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    	xhr.send(post);
    }
}

function subscribe(dr_id) {
	var button = document.getElementById('subscribe-'+dr_id);
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
	ajax('index.php?page=ajax&action=subscribe&dr_id='+dr_id)
}

function unsubscribe(dr_id) {
	var button = document.getElementById('subscribe-'+dr_id);
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
	button.innerHTML = button.getAttribute("data-subscribe")+' ('+button.getAttribute("data-subscribers")+')';
	ajax('index.php?page=ajax&action=unsubscribe&dr_id='+dr_id)
}

function like(vid) {
	var like = document.getElementById('like-'+vid);
	var dislike = document.getElementById('dislike-'+vid);
	if (dislike.getAttribute('disliked') == 'disliked') {
		dislike.removeAttribute('disliked');
		dislike.innerHTML--;
	}
	if (like.getAttribute('liked') != 'liked') {
		like.innerHTML++;
		like.setAttribute('liked', 'liked');
		ajax('index.php?page=ajax&action=like&vid='+vid);
	}
}

function dislike(vid) {
	var like = document.getElementById('like-'+vid);
	var dislike = document.getElementById('dislike-'+vid);
	if (like.getAttribute('liked') == 'liked') {
		like.removeAttribute('liked');
		like.innerHTML--;
	}
	if (dislike.getAttribute('disliked') != 'disliked') {
		dislike.innerHTML++;
		dislike.setAttribute('disliked', 'disliked');
		ajax('index.php?page=ajax&action=dislike&vid='+vid);
	}
}

function comment(vid, username, comment) {
	var newCom = document.getElementById('new_comments');
	newCom.innerHTML = getCommentHTML(username, comment) + newCom.innerHTML;
	document.getElementById('text_comment').value = '';
	ajax('index.php?page=ajax&action=comment&vid='+vid, 'comment='+encodeURIComponent(comment) );
}

function getCommentHTML(username, comment) {
	var date = new Date();
	return '<div class="panel panel-default" style="width: 100%;"><div class="panel-heading"><h5>'+username+' <small>'+date.getDate()+'/'+(date.getMonth()+1)+'/'+date.getFullYear()+' '+date.getHours()+':'+date.getMinutes()+':'+date.getSeconds()+'</small></h5></div><div class="panel-body"><p>'+noHTML(comment)+'</p></div></div>';
}

function noHTML(str) {
	return str.replace('<', '&lt;').replace('>', '&gt;');
}