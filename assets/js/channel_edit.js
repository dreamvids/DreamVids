var admins = [];

function autocompletion(obj) {
	var div = document.getElementById("autocomplete");
	if (obj.value.length != 0) {
		if (obj.value.length >= 3) {
			marmottajax.get({
				'url': _webroot_ + 'channel/autocomplete/'+obj.value+'/'
			}).then(function(result) {
				var users = JSON.parse(result);
				div.innerHTML = '';
				for(var i = 0; i < users.length; i++) {
					div.innerHTML += '<div onclick="complete('+users[i]['user_id']+', \''+users[i]['name']+'\', \''+users[i]['avatar']+'\')" class="channel-admin"><img class="admin-avatar" src="'+users[i]['avatar']+'" />'+users[i]['name']+'</div>';
				}
			});
		}
		else {
			div.innerHTML = '';
		}
	}
	else {
		div.innerHTML = '';
	}
}

function complete(user_id, name, avatar) {
	var div = document.getElementById("adm");
	var div2 = document.getElementById("autocomplete");
	var div3 = document.getElementById("add_admin");
	div.innerHTML += '<div id="adm_'+user_id+'" class="channel-admin"><img class="admin-avatar" src="'+avatar+'" />'+name+'<img class="delete-admin" src="../../assets/img/message_error_icon.png" onclick="remove_adm('+user_id+')" /></div>';
	admins.push(user_id);
	div2.innerHTML = '';
	div3.value = '';
}

function remove_adm(user_id) {
	document.getElementById("adm").removeChild(document.getElementById("adm_"+user_id));
	admins.push(-1 * user_id);
}

function eraseChannel(chanId) {
	if(confirm('Voulez-vous vraiment supprimer cette chaîne ainsi que toutes les vidéos qui lui sont associées de façon DEFINITIVE ?')) {
		marmottajax.delete({
			'url': _webroot_ + 'channel/' + chanId,
			'options': {}
		}).then(function(result) {
			window.location.href = _webroot_+'account/channels';
		});
	}
}

function checkChannelNameAvailable(input, currentName){
	msg_el = document.getElementById('avaiabilityNameMessage');
	if(input.value == '' || input.value == currentName){
		msg_el.innerText = '';
	} 
	else {

		marmottajax.get({
			'url': _webroot_ + 'channels/checkChannelNameAvailable/' + input.value
		}).then(function(result) {
			result = JSON.parse(result);
			msg_el.style.color = result.available ? 'green' : 'red';
			msg_el.innerText = result.available ? 'Nom disponible !' : 'Nom indisponible';
			
			msg_el.style.color = input.value.length < 3 ? 'red' : msg_el.style.color;
			msg_el.innerText = input.value.length < 3 ? 'Le nom doit faire plus de 3 caractères' : msg_el.innerText;
			
		});
	}

}