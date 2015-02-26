(function(win, doc){

var window = win,
	document = doc;

/**
 * Core/main.js
 *
 * Core variables
 */

window.ELCO_MAX_COMPONENTS_GENERATED = 2048;

/**
 * Events/main.js
 *
 * Add event to an element
 */

var elAndCoEvents = {

	list: {}

};

elAndCoEvents.add = function(name, fn) {

	elAndCoEvents.list[name] = fn;

};

function on(element, event, callback, binding) {

	if (element.length) {

		for (var i = 0; i < element.length; i++) {

			on(element[i], event, callback, binding);

		}

		return;

	}

	if (element.nodeName === "#document-fragment") {

		on(element.childNodes, event, callback, binding)

		return;

	}

	if (typeof elAndCoEvents.list[event] === "function") {

		elAndCoEvents.list[event](element, function() {

			return function(event) {

				if (typeof callback === "string") {

					eval(callback);

				}

				else {

					callback(event, binding);

				}

			};

		}(callback, binding));

	}

	else {

		if (isset(element.addEventListener)) {

			element.addEventListener(event, function() {

				return function(event) {

					callback(event, binding);

				}

			}(callback, binding), false);

		}

		else {

			element.attachEvent("on" + event, function() {

				return function(event) {

					callback(event, binding);

				}

			}(callback, binding));
			
		}

	}

	return element;

}

/**
 * Events/CLICK.js
 *
 * CLICK event
 */

elAndCoEvents.onClickEventsList = [];

elAndCoEvents.add("CLICK", function(element, callback) {

	var eventListener = new elAndCoEvents.onClickObject(element, callback);

	elAndCoEvents.onClickEventsList.push(eventListener);

});

elAndCoEvents.onClickObject = function(element, callback) {

	this.callback = callback;
	this.element = element;

	this.touchstart = function(eventListener) {

		return function(event) {

			eventListener.moved = false;

			eventListener.startX = event.touches[0].clientX;
			eventListener.startY = event.touches[0].clientY;

		}

	}(this);

	this.touchmove = function(eventListener) {

		return function(event) {

			if (Math.abs(event.touches[0].clientX - eventListener.startX) > 10 || Math.abs(event.touches[0].clientY - eventListener.startY) > 10) {
			    
			    eventListener.moved = true;

			}

		}

	}(this);

	this.touchend = function(eventListener) {

		return function(event) {

			if (!eventListener.moved) {

				eventListener.callback(event);

			}

		}

	}(this);

	on(this.element, "touchstart", this.touchstart);
	on(this.element, "touchmove", this.touchmove);
	on(this.element, "touchend", this.touchend);
	on(this.element, "touchcancel", this.touchend);

	on(this.element, "click", function(event, eventListener) {

	    if (!("ontouchstart" in window)) {

	        eventListener.callback(event);

	    }

	}, this);

};

/**
 * Core/child-node-list.js
 *
 * Generate a list of childs of an element
 */

function childNodeList(element) {

	var array = [];

	for (var i = 0; i < element.childNodes.length; i++) {

		array.push(element.childNodes[i]);

		if (element.childNodes[i].childNodes) {

			var sub_childs = childNodeList(element.childNodes[i]);

			for (var c = 0; c < sub_childs.length; c++) {

				array.push(sub_childs[c]);

			}

		}

	}

	return array;

}

/**
 * Core/isset.js
 *
 * Test if a variable is not `undefined`
 */

function isset(variable) {

	return typeof variable !== "undefined";

}

/**
 * Element/main.js
 *
 * Element model
 */

var El = Element = function(name, settings) {

	if (typeof this.self === "undefined") {

		var element = Element.create(name, settings);

	}

	else {

		var element = Element.select(name, settings);

	}

	if (!element) {

		return;

	}

	element.childs = element.childNodes;
	element.parent = element.parentNode;
	element.clone = element.cloneNode;

	for (method in Element.methods) {

		if (Element.methods.hasOwnProperty(method) && typeof element[method] === "undefined") {

			element[method] = function(element, fn) {

				return function() {
		
					return fn(element, arguments);
					
				}
		
			}(element, Element.methods[method]);

		}

	}

	return element;

};

/**
 * Element/add-method.js
 *
 * Add method to Element
 */

Element.methods = {};

Element.addMethod = function(name, fn) {

	if (typeof name === "string" && typeof fn === "function") {

		Element.methods[name] = fn;

	}

	else {

		console.error("el & co erreur 002\nLes arguments donnés lors de l'ajout d'une méthode aux Elements sont invalides.");

	}

};

/**
 * Element/create.js
 *
 * Element create
 */

Element.create = function(name, settings) {

	var element,
		tagName = /[-\w]+/.exec(name)[0];

	element = document.createElement(tagName);

	if (typeof settings === "object") {

		for (attribute in settings) {

			if (settings.hasOwnProperty(attribute) && !element.getAttribute(attribute)) {

				element.setAttribute(attribute, settings[attribute]);

			}

		}

	}

	var classNames = name.replace(/#([a-z-_]+)/i, "").replace(/\w+/, "").split(".");

	if (classNames.length > 1) {

		element.className = "";

		for (var i = 1; i < classNames.length; i++) {

			element.className += " " + classNames[i];

		}

	}

	var id = /([a-z-_]+)(#([a-z-_]+))/i.exec(name);

	if (id) {

		element.id = id[3];

	}

	return element;

};

/**
 * Element/select.js
 *
 * Element select
 */

Element.select = function(name, settings) {

	var element;

	if (typeof name !== "string") {

		element = name;

	}

	else if (name[0] == "#") {

		element = document.getElementById(name.substring(1));

	}
	
	return element;

};

/**
 * Element/methods/add-class.js
 *
 * Ajouter une classe à un Element
 */

Element.addMethod("addClass", function(element, arguments) {

	if (typeof arguments[0] !== "string") {

		return element;

	}

	if (!element.hasClass(name)) {

		element.className += " " + arguments[0];

	}

	return element;

});

/**
 * Element/methods/add-first.js
 *
 * Méthode d'ajout d'un ou plusieurs éléments en première position
 */

Element.addMethod("addFirst", function(element, arguments) {

	var child = arguments[0];

	if (!child) {

		return;

	}

	if (child.nodeName === "#document-fragment") {

		var array = [],
			childs = child.childNodes,
			length = childs.length;

		for (var i = 0; i < length; i++) {

			element.insertBefore(childs[0], element.firstChild);

			array.push(element.childNodes[element.childNodes.length - 1]);

		}

		return array;

	}

	else if (child.length) {

		for (var i = 0; i < child.length; i++) {
			
			var array = [],
				length = child.length;

			for (var i = 0; i < length; i++) {

				element.insertBefore(child[0], element.firstChild);

				array.push(element.childNodes[element.childNodes.length - 1]);

			}

			return array;

		}

	}

	else {

		element.insertBefore(child, element.firstChild);

		return El(child);

	}

});

/**
 * Element/methods/add.js
 *
 * Méthode d'ajout d'un ou plusieurs éléments
 */

Element.addMethod("add", function(element, arguments) {

	var child = arguments[0];

	if (!child) {

		return;

	}

	if (child.nodeName === "#document-fragment") {

		var array = [],
			childs = child.childNodes,
			length = childs.length;

		for (var i = 0; i < length; i++) {

			element.appendChild(childs[0]);

			array.push(element.childNodes[element.childNodes.length - 1]);

		}

		return array;

	}

	else if (child.length) {

		for (var i = 0; i < child.length; i++) {
			
			var array = [],
				length = child.length;

			for (var i = 0; i < length; i++) {

				element.appendChild(child[0]);

				array.push(element.childNodes[element.childNodes.length - 1]);

			}

			return array;

		}

	}

	else {

		element.appendChild(child);

		return El(child);

	}

});

/**
 * Element/methods/has-class.js
 *
 * Si un Element possède une classe
 */

Element.addMethod("hasClass", function(element, arguments) {

	if (typeof arguments[0] !== "string") {

		return element;

	}

	return (" " + element.className + " ").indexOf(" " + arguments[0] + " ") > -1;

});

/**
 * Element/methods/offset.js
 *
 * Retourne les informations à propos de la position et taille de l'Element
 */

Element.addMethod("offset", function(element) {

	var offsets = {

		x: 0,
		y: 0,

		width: element.clientWidth,
		height: element.clientHeight

	}

	while (element) {

	    offsets.x += (element.offsetLeft - (element == document.body ? 0 : element.scrollLeft) + element.clientLeft);
	    offsets.y += (element.offsetTop - (element == document.body ? 0 : element.scrollTop) + element.clientTop);
	    element = element.offsetParent;

	}

	return offsets;

});

/**
 * Element/methods/on.js
 *
 * Ajout d'événement à un Element
 */

Element.addMethod("on", function(element, arguments) {

	if (typeof arguments === "object" && typeof arguments[0] === "string" && typeof arguments[1] === "function") {

		on(element, arguments[0], arguments[1], arguments[2]);

	}

});

/**
 * Element/methods/remove-class.js
 *
 * Retirer une classe à un Element
 */

Element.addMethod("removeClass", function(element, arguments) {

	if (typeof arguments[0] !== "string") {

		return element;

	}

	element.className = (" " + element.className + " ").replace(" " + arguments[0] + " ", " ");

	return element;

});

/**
 * Element/methods/toggle-class.js
 *
 * Retirer une classe à un Element
 */

Element.addMethod("toggleClass", function(element, arguments) {

	if (typeof arguments[0] !== "string") {

		return element;

	}

	if (element.hasClass(arguments[0])) {

		element.removeClass(arguments[0]);

	}

	else {

		element.addClass(arguments[0]);

	}

	return element;

});

/**
 * Components/main.js
 *
 * Component model
 */

var Co = Component = function(firstAttribute, data) {

	if (typeof this.self === "undefined") {

		if (typeof firstAttribute !== "object" && typeof firstAttribute.name !== "string") {

			// TODO : ERROR

			return;

		}

		Co.components[firstAttribute.name] = this;

		this._mixinsCallbacks = {

			created: []

		};

		for (variable in firstAttribute) {

			if (firstAttribute.hasOwnProperty(variable) && !isset(this[variable])) {

				this[variable] = firstAttribute[variable];

			}

		}

		if (this.mixins instanceof Array) {

			for (var i = 0; i < this.mixins.length; i++) {

				if (Co.mixins[this.mixins[i]]) {

					var mixin = Co.mixins[this.mixins[i]];

					for (variable in mixin) {

						if (mixin.hasOwnProperty(variable)) {

							if (typeof this._mixinsCallbacks[variable] !== "undefined" && typeof mixin[variable] === "function") {

								this._mixinsCallbacks[variable].push(mixin[variable]);

							}

							else if (!isset(this[variable])) {

								this[variable] = mixin[variable];

							}

						}

					}

				}
				
			}

		}

	}

	else {

		return Co.generate(firstAttribute, data);

	}

};

Co.components = {};

/**
 * Components/attributes.js
 *
 * Transform attributes in an object
 */

Component.attributesParser = function(attributes, parameters) {

	var result = {};

	for (var i = 0; i < attributes.length; i++) {

		result[attributes[i].name] = attributes[i].value;

		if (typeof attributes[i].value === "string" && attributes[i].value[0] == "$" && parameters) {

			for (parameter in parameters) {

				if (attributes[i].value === "${" + parameter + "}" && parameters.hasOwnProperty(parameter)) {

					result[attributes[i].name] = parameters[parameter];

				}

			}

		}
		
	}

	return result;

}

/**
 * Components/call-callback.js
 *
 * Component model
 */

Component.prototype.callCallback = function(callback, argument) {

	for (var i = 0; i < this._mixinsCallbacks[callback].length; i++) {

		this._mixinsCallbacks[callback][i](argument);
		
	}

	if (typeof this[callback] === "function") {

		this[callback](argument);

	}

}

/**
 * Components/create.js
 *
 * Création d'un component
 */

Component.prototype.create = function(values) {

	var component = this.render(values),
		childs = childNodeList(component);

	if (isset(values._CHILDNODES_) && values._CHILDNODES_.length) {

		var innerSet = false;

		for (var i = 0; i < childs.length; i++) {

			var child = childs[i];

			if (child.getAttribute("tag-name") === "_inner_") {

				while (values._CHILDNODES_.length) {

					child.parentNode.insertBefore(values._CHILDNODES_[0], child);

				}

				child.parentNode.removeChild(child);

				innerSet = true;

				break;

			}

		}

		if (!innerSet) {

			while (values._CHILDNODES_.length) {

				component.appendChild(values._CHILDNODES_[0]);

			}

		}

	}

	if (isset(this.created)) {

		// this.created(component);
		this.callCallback("created", component);

	}

	return component;

};

/**
 * Components/generate.js
 *
 * Components fragment generation
 */

Component.generate = function(html, parameters) {

	if ("string" != typeof html) {

		return document.createElement("div");

	}

	html = html.replace(/^\s+|\s+$/g, "");
	html = html.replace(/<([-\w]*)( (.+?))?\/>/g,'<$1$2></$1>');
	html = html.replace(/<([-\w]*)( (.+?))?>/g,'<div tag-name="$1"$2>').replace(/<\/(.+?)>/g,'</div>');

	var element = document.createElement("div");
	element.innerHTML = html;

	var noMoreComponent = false,
		elementGenerated = false;
		componentsCreated = 0;

	while (!noMoreComponent) {

		elementGenerated = false;

		if (ELCO_MAX_COMPONENTS_GENERATED && componentsCreated > ELCO_MAX_COMPONENTS_GENERATED) {

			console.error("el & co erreur 001\nUne boucle de création de components a été détectée.\nLa génération des components a alors été arrêtée.");

			noMoreComponent = true;

		}
		
		var childs = childNodeList(element);

		for (var i = 0; i < childs.length; i++) {

			var child = childs[i];

			var tagName = "";
			
			if (child.getAttribute) {

				tagName = child.getAttribute("tag-name") || "";

			}

			if (Co.components[tagName]) {

				var attributes = Component.attributesParser(child.attributes, parameters);
				attributes._CHILDNODES_ = child.childNodes;

				var component = Co.components[tagName].create(attributes);

				for (attribute in attributes) {

					if (attributes.hasOwnProperty(attribute) && component.getAttribute(attribute) === null && typeof attributes[attribute] === "string") {

						component.setAttribute(attribute, attributes[attribute]);

					}

				}

				component.removeAttribute("tag-name");

				child.parentNode.insertBefore(component, child);
				child.parentNode.removeChild(child);

				elementGenerated = true;
				componentsCreated ++;

				break;

			}

		}

		if (!elementGenerated) {

			noMoreComponent = true;

		}

	}

	return element.childNodes;

}

/**
 * Components/inner.js
 *
 * Set the Component inner place
 */

Component.inner = function(element) {

	var innerElement = document.createElement("div");

	innerElement.setAttribute("tag-name", "_inner_")

	element.appendChild(innerElement);

	return element;

};

/**
 * Components/attributes.js
 *
 * Transform attributes in an object
 */

Component.mixins = {};

Component.Mixin = function(name, parameters) {

	if (typeof name === "string" && typeof parameters === "object") {

		Component.mixins[name] = parameters;
		
	}

}

window.Co = window.Component;
window.El = window.Element;

})(window, document);