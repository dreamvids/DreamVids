Eggs = function() {}

Eggs.eggs = [];

Eggs.create = function(id, egg_type) {
	var div = new Element('a');
	div.href = _webroot_ + "egg/" + id;
	div.id = id;
	div.className = "egg egg_" + egg_type; //egg_gold or egg_normal
	div.onclick = Eggs.onclick;
	Eggs.eggs.push(div);
}

Eggs.onclick = function() {
	console.log(this.id);
}

Eggs.showAll = function () {
	container = document.getElementById('eggs_container');
	for(var i=0; i< Eggs.eggs.length; i++){
		var egg = Eggs.eggs[i];
		container.innerHTML += egg.outerHTML;
	}
	
}