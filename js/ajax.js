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

function ajax(url) {
    var xhr = loadAjax();
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
        {
        	
        }
    };
    xhr.open("GET", url, true);
    xhr.send(null);
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