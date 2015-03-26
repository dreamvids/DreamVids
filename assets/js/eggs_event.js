
/**
 * eggs_event.js
 * 
 * Eggs event
 */

function Egg(id, eggType, blank, site) {

	this.blank = blank;
	this.site = site;
	
	this.id = id;
	this.el = document.createElement("img");
	this.el.id = this.id;
	this.el.src = _webroot_ + "assets/img/eggs/egg_" + eggType + ".png";

	this.el.onclick = this.onclick.bind(this);

	this.el.style.position = "absolute";
	this.el.style.width = this.el.style.height = "50px";
	this.el.style.cursor = "pointer";

	switch (Math.round(Math.random() * (Egg.positions - 1)) + 1) {

	    case 1: // Positionnement absolue aléatoire

	        this.el.style.left = Math.round(Math.random() * document.body.clientWidth - 51) + 1 + "px";
			this.el.style.top = Math.round(Math.random() * document.body.clientHeight - 51) + 1 + "px";
			this.el.style.zIndex = "99999";

	        break;

	    case 2:

	    	// Autre type de positionnement

	    	break;

	}

	document.body.appendChild(this.el);

}

Egg.prototype.onclick = function() {
	if(this.blank == "blank"){
		/*if(this.site == "cavicon"){ this.checkInterval = setInterval(function() { }, 1000); }*/
		
		window.open(_webroot_ + "egg/" + this.id, '_blank');
	}else{
		document.location = _webroot_ + "egg/" + this.id;
	}

};

Egg.positions = 1;