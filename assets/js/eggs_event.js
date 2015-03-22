Eggs = function() {}

Eggs.eggs = [];

Eggs.create = function(id, egg_type) {
	var egg = document.createElement('img');
	egg.id = id;
	egg.dataset.type = egg_type;
	egg.className = "egg egg_" + egg_type; //egg_gold or egg_normal
	egg.src = _webroot_ + "assets/img/eggs/egg_" + egg_type + ".png";
	Eggs.eggs.push(egg);
}

Eggs.onclick = function() {
	document.location = _webroot_ + "egg/" + this.id;
}

Eggs.showAll = function () {
	container = document.getElementById('eggs_container');
	for(var i=0; i< Eggs.eggs.length; i++){
		
		var egg = Eggs.eggs[i];
		
		egg.onclick = Eggs.onclick;
		egg.style.left = Math.round(Math.random()*80) + 1 + "%"; //Change these to put eggs randomly on predefined emplacements
		egg.style.top = Math.round(Math.random()*200) + 1 + "%"; // <-/
		container.appendChild(egg)
	}
	
}

