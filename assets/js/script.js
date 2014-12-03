
/**
 * main.js
 *
 * Fichier JavaScript principal.
 */

var Application = {

	name: "DreamVids"

};
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

/*
 *  Marmottajax 1.0.3
 *  Envoyer et recevoir des informations simplement en JavaScript
 */

var marmottajax = function(options) {

    return marmottajax.get(options);

};

marmottajax.normalize = function(parameters) {

    return parameters ? (typeof parameters === "string" ? { url: parameters } : parameters) : false;

};

marmottajax.json = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.json = true;

        return new marmottajax.request(parameters);

    }

};

marmottajax.get = function(options) {

    return new marmottajax.request(options);

};

marmottajax.post = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.method = "POST";

        return new marmottajax.request(parameters);

    }

};

marmottajax.put = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.method = "PUT";

        return new marmottajax.request(parameters);

    }

};

marmottajax.delete = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.method = "DELETE";

        return new marmottajax.request(parameters);

    }

};

marmottajax.request = function(options) {

    if (!options) { return false; }

    if (typeof options == "string") {

        options = { url: options };

    }

    if (options.method === "POST" || options.method === "PUT" || options.method == "DELETE") {

        var post = "?";

        for (var key in options.options) {

            post += options.options.hasOwnProperty(key) ? "&" + key + "=" + options.options[key] : "";

        }

    }

    else {

        options.method = "GET";

        options.url += options.url.indexOf("?") < 0 ? "?" : "";

        for (var key in options.options) {

            options.url += options.options.hasOwnProperty(key) ? "&" + key + "=" + options.options[key] : "";

        }

    }

    this.xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

    this.xhr.options = options;

    this.xhr.callbacks = {

        then: [],
        error: []

    };

    this.then = function(callback) {

        this.xhr.callbacks.then.push(callback);

        return this;

    };

    this.error = function(callback) {

        this.xhr.callbacks.error.push(callback);

        return this;

    };

    this.xhr.call = function(categorie, result) {

        for (var i = 0; i < this.callbacks[categorie].length; i++) {

            if (typeof(this.callbacks[categorie][i]) === "function") {

                this.callbacks[categorie][i](result);

            }

        }

    }

    this.xhr.returnSuccess = function(result) {

        this.call("then", result);

    };

    this.xhr.returnError = function(message) {

        this.call("error", message);

    };

    this.xhr.onreadystatechange = function() {

        if (this.readyState === 4 && this.status == 200) {

            var result = this.responseText;

            if (this.options.json) {

                try {

                    result = JSON.parse(result);

                }

                catch (error) {

                    this.returnError("invalid json");

                    return false;

                }

            }

            this.returnSuccess(result);

        }

        else if (this.readyState === 4 && this.status == 404) {

            this.returnError("404");

        }

        else if (this.readyState === 4) {

            this.returnError("unknow");

        }

    };

    this.xhr.open(options.method, options.url, true);
    this.xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    this.xhr.send(typeof post != "undefined" ? post : null);

};

/**
 * core/$.js
 *
 * DOM Content Loaded function
 */

Application.dom_load_event_listeners = [];

function $(callback) {

	if (typeof callback === "function") {

		Application.dom_load_event_listeners.push(callback);

	}

}

Application.dom_content_loaded = false;

Application.on_dom_content_loaded = function(event) {

	if (!Application.dom_content_loaded) {

		Application.dom_content_loaded = true;

		for (var i = 0; i < Application.dom_load_event_listeners.length; i++) {

			var fn = Application.dom_load_event_listeners[i]

			if (typeof fn === "function") {

				fn();

			}
			
		}

	}

};

El(document).on("DOMContentLoaded", Application.on_dom_content_loaded);
El(window).on("load", Application.on_dom_content_loaded);

window.onload = function() {

    Application.on_dom_content_loaded();

};

/**
 * Core/isset.js
 *
 * Test if a variable is not `undefined`
 */

function isset(variable) {

	return typeof variable !== "undefined";

}

/**
 * core/request-animation-frame.js
 *
 * REQUEST ANIMATION FRAME
 */

window.requestAnimationFrame = (function() {

    return window.requestAnimationFrame       ||
           window.webkitRequestAnimationFrame ||
           window.mozRequestAnimationFrame    ||

        function(callback) {

            window.setTimeout(callback, 1000 / 60);

    	};

})();

/**
 * Core/scripts-launch.js
 *
 * SCRIPTS LAUNCH
 */

$(function() {

	for (var i = 0; i < Application.scripts.length; i++) {

		var can_call = false,
			script = Application.scripts[i];

		if (script.pages === "*" || script.pages === "all" || !script.pages) {

			can_call = true;

		}

		else {

			for (var p = 0; p < script.pages.length; p++) {
				
				if (script.pages[p] === _currentpage_) {

					can_call = true;

				}

			}
			
		}

		if (can_call) {

			script.call();

		}

	}

});

/**
 * Core/scripts.js
 *
 * MAIN SCRIPT SCRIPT
 */

Application.scripts = [];

var Script = function(script) {

	this.pages = script.pages;

	this.to_call = script.call;

	Application.scripts.push(this);

};

Script.prototype.call = function() {
	
	this.to_call();

};

/**
 * components/main.js
 *
 * Button component
 */

new Component({

	name: "btn",

	render: function($) {

		var type = $.type === "raised" ? "raised" : "flat",
			color = $.color ? ".btn--" + $.color : "",
			outline_color = $.outline ? ".btn--outline-" + $.outline : "",
			ripple_color = $.ripple ? ".btn--ripple-" + $.ripple : "",
			disabled = isset($.disable) ? ".disabled" : "";
	
		var btn = new Element("div.btn.btn--" + type + color + outline_color + ripple_color + disabled);
	
		if (!disabled) {
	
			btn.tabIndex = 0;
	
		}

		if (typeof $.click === "function") {

			El(btn).on("CLICK", $.click, btn);

		}
	
		if (!$["no-ripple"]) {
	
			El(btn).add(Co('<ripple parent="${parent}"/>', {
	
				parent: btn
	
			}));
	
		}

		return btn;
	
	}

});

/* TEMPLATE

<btn type="flat|raised" color? click? no-ripple?>@{inner}</btn> */

/**
 * Components/card.js
 *
 * Card component
 */

new Co({

	name: "card",

	render: function($) {

		var type = isset($.type) ? $.type : "video";
	
		if (type === "video") {
	
			var card = new El("div.card.video");
	
				var thumbnail = card.add(new El("div.thumbnail"));
				thumbnail.style.backgroundImage = "url(" + $.thumbnail + ")";
	
					var time = thumbnail.add(new El("div.time"));
					time.innerHTML = $.duration;
	
					var overlay = thumbnail.add(new El("a.overlay"));
					overlay.href = "watch/" + $["vid-id"];
	
				var description = card.add(new El("div.description"));
	
					var title = description.add(new El("a"));
					title.href = "watch/" + $["vid-id"];
	
						var title_inner = title.add(new El("h4"));
						title_inner.innerHTML = $.title;
	
					var div = description.add(new El("div"));
	
						var views = div.add(new El("div.view"));
						views.innerHTML = $.views;
	
						var channel = div.add(new El("a.channel"));
						channel.href = "channel/" + $.channel;
						channel.innerHTML = $["channel-name"];
	
		}
	
		else if (type == "plus") {
	
			var card = new El("div.card.plus");
	
				var a = card.add(new El("a"));
				a.href = "watch/" + $["vid-id"];
	
					var thumbnail = a.add(new El("div.thumbnail"));
					thumbnail.style.backgroundImage = "url(" + $.thumbnail + ")";
	
					var p = a.add(new El("p"));
	
						var channel_name = p.add(new El("b"));
						channel_name.innerHTML = $["channel-name"];
	
						p.innerHTML += " a aimé votre vidéo \"<b>" + $["vid-name"] + "</b>\"";
	
				var i = card.add(new El("i"));
				i.innerHTML = $["relative-time"];
	
		}
	
		else if (type == "comment") {
	
			var card = new El("div.card.comment");
	
				var a = card.add(new El("a"));
				a.href = "watch/" + $["vid-id"];
	
					var p = a.add(new El("p"));
	
						var channel_name = p.add(new El("b"));
						channel_name.innerHTML = $["channel-name"];
	
						p.innerHTML += " a commenté votre vidéo \"<b>" + $["vid-name"] + "</b>\"";
	
					var blockquote = a.add(new El("blockquote"));
					blockquote.innerHTML = $.comment
	
				var i = card.add(new El("i"));
				i.innerHTML = $["relative-time"];
	
		}
	
		else if (type == "channel") {
	
			var card = new El("div.card.channel");
	
				var a = card.add(new El("a"));
				a.href = "watch/" + $.channel;
	
					var avatar = a.add(new El("div.avatar"));
					avatar.style.backgroundImage = "url(" + $.avatar + ")";
	
					var p = a.add(new El("p"));
	
						var channel_name = p.add(new El("b"));
						channel_name.innerHTML = $["channel-name"];
		
						p.innerHTML += " s'est abonné à votre chaîne \"<b>" + $["my-channel-name"] + "</b>\"";
	
				var subscribers = card.add(new El("span.subscribers"));
				subscribers.innerHTML = "<b>" + $.subscribers + "</b> Abonnés";
	
				var i = card.add(new El("i"));
				i.innerHTML = $["relative-time"];
	
		}
	
		card.on( "CLICK", $.click, card);

		return card;
	
	}

});

/**
 * Components/channel-post.js
 *
 * Channel social post component
 */

new Co({

	name: "channel-post",

	render: function($) {

		var channel_post = new Element("div.channel-post");
	
			var avatar = channel_post.add(new Element("img"));
			avatar.src = $.avatar;
	
			var p = channel_post.add(new Element("p"));
	
				var channel_name = p.add(new Element("span.channel-name"));
				channel_name.innerHTML = $.channel;
	
			p.innerHTML += " a posté un message :";
	
			var message = channel_post.add(new Element("div.social-message"));
			message.innerHTML = $.message;
	
		return channel_post;
	
	}

});

/* TEMPLATE

<div class="channel-post">

	<img src="${avatar}">
	<p><span class="channel-name">${name}</span> a posté un message :</p>
	<div class="social-message">${message}</div>

</div> */

/**
 * components/comment.js
 *
 * Comment component
 */

new Co({

	name: "comment",

	render: function($) {

		if (!$.data) {

			return;

		}

		var comment = $.data;

		var commentDiv = new El("div.comment");

			var headDiv = commentDiv.add(new El("div.comment-head"));

				var userDiv = headDiv.add(new El("div.user"));

					var avatar = userDiv.add(new El("img"));
					avatar.src = _my_avatar_;

					var a = userDiv.add(new El("a"));
					a.href  = "../channel/" + comment.channelUrl;
					a.innerHTML = comment.author;

				var dateDiv = headDiv.add(new El("div.date"));

					var p = dateDiv.add(new El("p"));
					p.innerHTML = comment.date;

			var textDiv = commentDiv.add(new El("div.comment-text"));

				var p1 = textDiv.add(new El("p"));
				p1.innerHTML = comment.comment;

			var noteDiv = commentDiv.add(new El("div.comment-notation"));

				var ul = noteDiv.add(new El("ul"));

					var li1 = ul.add(new El("li.plus"));
					var li2 = ul.add(new El("li.moins"));

					li1.id = "plus-" + comment.id;
					li2.id = "moins-" + comment.id;

					li1.onclick = function(commentId) {

						return function() {

							likeComment(commentId);

						}

					}(comment.id);

					li2.onclick = function(commentId) {

						return function() {

							dislikeComment(commentId)

						}

					}(comment.id);

					li1.innerHTML = "+" + comment.plusNumber;
					li2.innerHTML = "-" + comment.moinsNumber;

		return commentDiv;
	
	}

});

/**
 * components/ripple.js
 *
 * Ripple component
 */

new Component({

	name: "ripple",

	render: function($) {

		var ripple = new Element("div.ripple");
	
		if ($.parent) {

			var event = "ontouchstart" in window ? "touchstart" : "mousedown";
	
			El($.parent).on(event, function(event, elements) {
	
				var ripple = elements.ripple,
					parent = elements.parent;

				if (!El(parent).hasClass("disabled")) {
	
					var circle = ripple.add(new El("div.ripple__circle.ripple__circle--animate"));
	
					var parentOffset = El(parent).offset();
	
					var clickX = event.changedTouches ? event.changedTouches[0].pageX : event.pageX,
						clickY = event.changedTouches ? event.changedTouches[0].pageY : event.pageY;
	
					circle.style.left = clickX - parentOffset.x + "px";
					circle.style.top = clickY - parentOffset.y + "px";
	
				}
	
			}, {
	
				ripple: ripple,
				parent: $.parent
	
			});
	
		}

		return ripple;
	
	}

});

/* TEMPLATE

<ripple parent="${parent-node}"/> */

/**
 * Scripts/add-playlist.js
 *
 * ADD VIDEO TO PLAYLIST
 */

function initPlaylistCheckbox(checkbox) {

	El(checkbox).on("change", function(checkbox) {
	
		return function() {
	
			if (checkbox.checked) {

				addVideoToPlaylist(checkbox.getAttribute("data-playlist-id"), _VIDEO_ID_);

			}

			else {

				removeVideoFromPlaylist(checkbox.getAttribute("data-playlist-id"), _VIDEO_ID_);

			}
	
		};
	
	}(checkbox));

}

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#add-playlist-icon")) {

			return false;

		}

		El("#add-playlist-icon").onclick = function() {

			var videoInfoDescription = El("#video-info-description");

			if (videoInfoDescription.hasClass("playlist")) {

				videoInfoDescription.removeClass("export");
				videoInfoDescription.removeClass("playlist");

			}

			else {

				videoInfoDescription.removeClass("export");
				videoInfoDescription.className += " playlist";

			}

		};

		var childs = El("#playlist-add-form-list").childNodes;

		for (child in childs) {
		
			if (childs.hasOwnProperty(child)) {
		
				if (childs[child].nodeName === "INPUT") {

					initPlaylistCheckbox(childs[child]);

				}

			}
			
		}

	}

});

/**
 * Scripts/bg-loader.js
 *
 * BACKGROUND LOADER
 */

function elementInViewport(el) {

	var top = el.offsetTop;
	var left = el.offsetLeft;
	var width = el.offsetWidth;
	var height = el.offsetHeight;

	while(el.offsetParent) {

		el = el.offsetParent;
		top += el.offsetTop;
		left += el.offsetLeft;

	}

	return (

		top >= window.pageYOffset &&
		left >= window.pageXOffset &&
		(top + height) <= (window.pageYOffset + window.innerHeight) &&
		(left + width) <= (window.pageXOffset + window.innerWidth)

	);

}

function BackgroundLoader(element) {

    this.element = El(element);
    this.src = this.element.getAttribute("data-background");
    this.element.style.backgroundImage = "url(" + this.src + ")";

    this.loadInView = typeof this.element.getAttribute("data-background-load-in-view") === "string" ? true : false;

    if (!this.loadInView || elementInViewport(this.element)) {

    	this.loadBackground();

	}

	else {

		BackgroundLoader.elementsToCheck.push(this);

	}

}

BackgroundLoader.elementsToCheck = [];

BackgroundLoader.prototype.loadBackground = function() {

	this.backgroundLoading = true;

	this.imgLoader = new Image();
	this.imgLoader.src = this.src;

	El(this.imgLoader).on("load", function(event, element) {

	    element.addClass("bg-loader-transition");
	    element.addClass("bg-loaded");

	    setTimeout(function(element) {

	        return function() {

	            element.removeClass("bg-loader-transition");

	        }

	    }(element), 400);

	}, this.element);

};

El(window).on("scroll", function() {

	for (var i = 0, length = BackgroundLoader.elementsToCheck.length; i < length; i++) {
		
		var bg = BackgroundLoader.elementsToCheck[i];

		if (elementInViewport(bg.element) && !bg.backgroundLoading) {

			bg.loadBackground();

		}
	
	}

});

new Script({

	call: function() {

		var elements = document.getElementsByClassName("bg-loader");

		if (elements && elements.length) {

		    for (var i = 0, length = elements.length; i < length; i++) {

		        new BackgroundLoader(elements[i]);

		    }

		}

	}

});

/**
 * Scripts/test.js
 *
 * TEST SCRIPT
 */

new Script({

	call: function() {

		/*console.log(El(document.body).add(Co('<card vid-id="${vid_id}" title="${title}" thumbnail="${thumbnail}" duration="${duration}" views="${views}" channel="${channel}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			title: "Très le titre",
			thumbnail: "//lorempicsum.com/up/255/200/2",
			duration: "12:18",
			views: "37",
			channel: "bla",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(Co('<card type="plus" vid-id="${vid_id}" thumbnail="${thumbnail}" relative-time="${relative_time}" vid-name="${vid_name}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			thumbnail: "//lorempicsum.com/up/255/200/2",
			relative_time: "il y a 2 minutes",
			vid_name: "Nom",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(Co('<card type="comment" vid-id="${vid_id}" comment="${comment}" relative-time="${relative_time}" vid-name="${vid_name}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			comment: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, laboriosam, nobis mollitia, autem similique atque repellendus beatae qui cum minima voluptas earum aliquid! Possimus aliquid delectus, illum laborum recusandae cum.",
			relative_time: "il y a 2 minutes",
			vid_name: "Nom",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(Co('<card type="channel" avatar="${avatar}" subscribers="${subscribers}" relative-time="${relative_time}" my-channel-name="${my_channel_name}" channel="${channel}" channel-name="${channel_name}"/>', {

			avatar: "//lorempicsum.com/up/255/200/2",
			relative_time: "il y a 2 minutes",
			subscribers: 13,
			my_channel_name: "Me",
			channel: "Bla",
			channel_name: "Bla"

		}))[0]);*/

	}

});

/**
 * Scripts/test.js
 *
 * TEST SCRIPT
 */

function postMessage() {

 	marmottajax.post({

 		url: _webroot_ + "posts",
 		json: true,

 		options: {

 			"post-message-submit": "lol",
 			channel: El("#channel-social-message-submit").getAttribute("data-channel-id"),
 			"post-content": El("#post-content").value

 		}

 	}).then(function(channel) {

 		return function(result) {
	
 			El("#channel-posts").addFirst(Co('<channel-post avatar="${avatar}" channel="${channel}" message="${message}"/>', {
	
 				avatar: _my_avatar_,
 				channel: _my_pseudo_,
 				message: result.content
	
 			}));

 		}

 	}(El("#channel-social-message-submit").getAttribute("data-channel-id")));

 	El("#post-content").value = "";

}

new Script({

	pages: ["channel"],

	call: function() {

		var channelSocialMessageSubmit = El("#channel-social-message-submit");

		if (channelSocialMessageSubmit) {

			channelSocialMessageSubmit.onclick = postMessage;

			El("#post-content").on("keydown", function(event) {

			    if (event.keyCode === 13 && event.ctrlKey) {

			        postMessage();

			    }

			});

		}

	}

});
/*
 * Live chat
 */

 window.requestAnimationFrame = (function() {
     return window.requestAnimationFrame ||
         window.webkitRequestAnimationFrame ||
         window.mozRequestAnimationFrame ||
         function(callback) {
             window.setTimeout(callback, 1000 / 60);
     };
 })();

function ChatMessage() {
	var that = this;

	this.data = '';
	this.sender = '';
	this.content = '';
	this.messageType = 'text';
	this.channel = Chat.channel;
	this.timestamp = Math.round(+new Date() / 1000);

	this.construct = function(sender, content, sessionId) {
		that.sender = sender;
		that.content = content;

		if(content.lastIndexOf('/', 0) == 0) {
			that.messageType = 'command';
		}

		var dataArray = {
			"sender_name": that.sender,
			"content": that.content,
			"messageType": that.messageType,
			"channel": that.channel,
			"timestamp": that.timestamp
		};

		if(typeof sessionId == 'undefined') {

		}
		else {
			if(sessionId.length > 0) {
				dataArray.sessionId = sessionId;
			}
		}

		that.data = JSON.stringify(dataArray);
	};

	this.parse = function(jsonData) {
		try {
			var json = JSON.parse(jsonData);

			that.sender = json.sender_name;
			that.content = json.content;
			that.messageType = json.messageType;
			that.timestamp = json.timestamp;
		}
		catch(e) { alert(e);  }
	};

};

var Screen = {
	pushMessage: function(message) {
		var panel = document.getElementById("messages-panel");

		var el = document.createElement("div");
		el.className = "live-chat__message";

		var username = document.createElement('span');
		username.className = "live-chat__message__pseudo " + (message.rank ? "live-chat__message__pseudo--" + message.rank : "");
		var text = document.createTextNode(message.sender);
		username.appendChild(text);

		var messageElem = document.createElement('p');
		var messageText = document.createTextNode(message.content);
		messageElem.appendChild(messageText);

		el.appendChild(username);
		el.appendChild(messageElem);

		panel.appendChild(el);

		Chat.scrollDown();

		var maxMessagesInList = 32;

		if (panel.childNodes.length > maxMessagesInList) {

			for (var i = 0; panel.childNodes.length > maxMessagesInList;) {
				
				panel.removeChild(panel.childNodes[i])
			
			}

		}

	},

	pushText: function(message, type) {
		var panel = document.getElementById('messages-panel');

		var el = document.createElement('div');
		el.className = 'live-chat__message ' + "live-chat__message--" + type;

		var messageElem = document.createElement('p');

		var typeText = {

			error: "Erreur",
			info: "Information"

		};

		var messageText = document.createElement('span');
		messageText.className = 'live-chat__message__pseudo';
		messageText.innerHTML = (typeText[type] || type) + ' : ' + message;

		messageElem.appendChild(messageText);

		el.appendChild(messageElem);

		panel.appendChild(el);
		panel.scrollTop = panel.scrollHeight;


	},


	clearFirst: function() {
		var panel = document.getElementById('messages-panel');
		panel.removeChild(panel.firstChild);
	}
};

var Chat = {

	connected: false,
	socket: null,
	address: '127.0.0.1',
	port: 8080,
	channel: '',
	username: 'Dreamer',
	sessionId: '',
	scrolling: false,
	isHover: false,
	scrollSpeed: 0,

	start: function() {
		this.socket = new WebSocket('ws://' + this.address + ':' + this.port + '/' + this.channel);

		this.socket.onopen = this.onConnect;
		this.socket.onclose = this.onDisconnect;
		this.socket.onmessage = this.onMessage;
		this.socket.onerror = this.onError;

	},

	onConnect: function(event) {
		// send an empty message to init the connection
		var msg = new ChatMessage();
		msg.construct(Chat.username, '', Chat.sessionId);
		Chat.socket.send(msg.data);

		Chat.connected = true;
		Screen.pushText('Connected maggle ! Welcome !', 'info');
	},

	onMessage: function(event) {
		try {
			var message = new ChatMessage();
			message.parse(event.data);

			Screen.pushMessage(message);
		}
		catch(e) {
			Screen.pushText(e.message, 'error');
		}
	},

	onDisconnect: function(event) {
		Chat.connected = false;
		Screen.pushText('Disconnected', 'info');
	},

	onError: function(event) {
		Screen.pushText("WebSocket error", 'error');
	},

	scrollDown: function() {

		if (!Chat.scrolling && !Chat.isHover) {

			Chat.scrollInterval();

		}

	},

	scrollInterval: function() {

		var panel = document.getElementById("messages-panel");

	    Chat.scrolling = true;
	    speed = Math.abs(panel.scrollTop + panel.offsetHeight - panel.scrollHeight) / 12 + 1;
	    Chat.scrollSpeed += Chat.scrollSpeed < speed ? speed / 5 : -speed / 8;

	    panel.scrollTop += !Chat.isHover ? Chat.scrollSpeed : 0;

	    if (panel.scrollTop + panel.offsetHeight < panel.scrollHeight) {

	        requestAnimationFrame(Chat.scrollInterval);

	    }

	    else {

	        Chat.scrollSpeed = 0;
	        Chat.scrolling = false;

	    }

	}

};

function initChat(opts) {

	Chat.address = opts.ip;
	Chat.port = opts.port;
	Chat.channel = opts.channel;
	Chat.username = opts.username ? opts.username : 'Dreamer';
	Chat.sessionId = opts.sessionId;

	window.onkeypress = keyPress;

	Chat.start();

	var panel = document.getElementById("messages-panel");

	panel.addEventListener("mouseover", function() {

	    Chat.isHover = true;

	});

	panel.addEventListener("mouseout", function() {

	    Chat.isHover = false;

	});

	panel.addEventListener("mousewheel", function(event) {

	    panel.scrollTop += event.wheelDelta > 0 || event.detail < 0 ? -30 : 30;

	});

}

function sendChatMessage() {
	if(Chat.connected) {
		var contentInput = document.getElementById('live-chat-input');
		var message = new ChatMessage();

		message.construct(Chat.username, contentInput.value, Chat.sessionId);

		Chat.socket.send(message.data);
		contentInput.value = '';
	}
}

function keyPress(event) {
	if(typeof event == 'undefined' && window.event)
		event = window.event;

	var contentInput = document.getElementById('live-chat-input');

	if(document.activeElement == contentInput && event.keyCode == 13) {
		sendChatMessage();
	}
}

new Script({

	pages: ["live"],

	call: function() {

		initChat(chatLiveOptions);

	}

});

/**
 * scripts/comment.js
 *
 * COMMENT
 */

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#post-comment-button")) {

			return false;

		}

		El("#post-comment-button").onclick = function() {

			postComment(El("#post-comment-button").getAttribute("data-vid-id"), El("#textarea-comment").value, El("#channel-selector").value, El("#parent-comment").value);

		};

	}

});

function postComment(vid, commentContent, fromChannel, parent) {

	marmottajax.post({

		url: _webroot_ + "comments/",

		options: {

			commentSubmit: "lol",
			"comment-content": commentContent,
			"from-channel": fromChannel,
			"video-id": vid,
			parent: parent

		}

	}).then(function(fromChannel) {

		return function(result) {

			var comment = JSON.parse(result);

			comment.channelUrl = fromChannel;
			comment.avatar = _my_avatar_;
			comment.plusNumber = 0;
			comment.moinsNumber = 0;
			comment.date = "À l'instant";

			El("#comments-best").addFirst(Co('<comment data="${data}"/>', { data: comment }));

		}

	}(fromChannel));

	El("#textarea-comment").value = "";

}

/**
 * Scripts/embed-video.js
 *
 * EMBED VIDEO
 */

function setExporterInputValue() {

	if (!El("#exporter-input")) {

		return false;

	}

	var exporterInput = El("#exporter-input"),

		exporterQuality = El("#exporter-quality"),
		exporterAutoplay = El("#exporter-autoplay"),
		exporterTimeCheckbox = El("#exporter-time-checkbox"),
		exporterTimeInput = El("#exporter-time-input");

	var url = "//dreamvids.fr/embed/video/" + _VIDEO_ID_;

	var quality = exporterQuality.options[exporterQuality.value].innerHTML || "640x360",
		qualitys = quality.split("x");
		width = qualitys[0],
		height = qualitys[1];

	var autoplay = exporterAutoplay.checked || false;

	if (autoplay) {

		url += "/autoplay";

	}

	var startAt = exporterTimeCheckbox.checked || false;

	if (startAt) {

		var timeUrlFormat = ["s", "m", "h"];

		var startTime = exporterTimeInput.value,
			times = startTime.split(":").reverse();

		for (var i = 0; i < times.length; i++) {

			/*url += i === 0 & !autoplay ? "?" : "&";

			url += timeUrlFormat[i] + "=" + times[i];*/

			url += times[i] + '/';

		}

	}

	exporterInput.value = "<iframe width=\"" + width + "\" height=\"" + height + "\" src=\"" + url + "\" allowfullscreen frameborder=\"0\"></iframe>";

}

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#embed-video-icon")) {

			return false;

		}

		El("#embed-video-icon").onclick = function() {

			var videoInfoDescription = El("#video-info-description");

			if (videoInfoDescription.hasClass("export")) {

				videoInfoDescription.removeClass("playlist");
				videoInfoDescription.removeClass("export");

			}

			else {

				videoInfoDescription.removeClass("playlist");
				videoInfoDescription.className += " export";

				El("#exporter-input").select();

			}

		};

		El("#exporter-quality").onchange = setExporterInputValue;
		El("#exporter-autoplay").onchange = setExporterInputValue;
		El("#exporter-time-checkbox").onchange = setExporterInputValue;
		El("#exporter-time-input").onchange = setExporterInputValue;

		setExporterInputValue();

	}

});

/**
 * Scripts/model.js
 *
 * EXAMPLE SCRIPT
 */

new Script({

	pages: ["default", "watch"], // Pages

	// OU // pages: "all", // OU ne pas spécifier

	call: function() { // Fonction appelée lorsque la page peut être manipulée

		// console.log("Il pleut!", "{example script}");

	}

});

/**
 * scripts/playlist-scroll.js
 *
 * PLAYLIST SCROLL BUTTONS
 */

function playListScroll(data) {

    El("#playlist-videos").scrollLeft += data;

}

new Script({

    pages: ["watch"],

	call: function() {

        if (!document.getElementById("playlist-button-scroll-left")) {

            return false;

        }

		var buttonLeft = El("#playlist-button-scroll-left"),
            buttonRight = El("#playlist-button-scroll-right");

        buttonLeft.onclick = function() {

            playListScroll(-300);

        };

        buttonRight.onclick = function() {

            playListScroll(200);

        };

	}

});

/**
 * scripts/redirect-at-end.js
 * 
 * Redirect at the end of the video
 */

function redirectOverlayUpdate() {

	var redirectAtEnd = document.getElementById("redirect-at-end");

	redirectAtEnd.innerHTML = redirectAtEnd.getAttribute("data-message").replace("{time}", Application.redirectOverlayTime) + "<br>";

	var cancel = document.createElement("div");
	cancel.className = "video__redirect-at-end__cancel";
	cancel.innerHTML = redirectAtEnd.getAttribute("data-cancel-message");

	cancel.onclick = cancelRedirectOverlay;

	redirectAtEnd.appendChild(cancel);

};

function cancelRedirectOverlay() {

	var redirectAtEnd = document.getElementById("redirect-at-end");

	clearInterval(Application.redirectOverlayInterval);

	Application.redirectOverlayTime = 5;
	Application.redirectOverlay = false;

	redirectAtEnd.className = redirectAtEnd.className.replace("video__redirect-at-end--show", "");

};

new Script({

    pages: ["watch"],

	call: function() {

		var video = document.getElementById("video-tag");

		if (!video) {

		    return false;

		}

		Application.redirectOverlay = false;

		video.addEventListener("ended", function(event) {

			if (!Application.redirectOverlay) {

				Application.redirectOverlay = true;
				
				if (typeof _redirectAtEnd !== "undefined" && _redirectAtEnd !== "") {

					var redirectAtEnd = document.getElementById("redirect-at-end");

					Application.redirectOverlayTime = 5;

					redirectOverlayUpdate();

					if (redirectAtEnd.className.indexOf("video__redirect-at-end--show") < 0) {

						redirectAtEnd.className += " video__redirect-at-end--show";

					}

					if (Application.redirectOverlayInterval) {

						clearInterval(Application.redirectOverlayInterval);

						Application.redirectOverlayInterval = null;

					}

					Application.redirectOverlayInterval = setInterval(function() {

						Application.redirectOverlayTime --;

						redirectOverlayUpdate();

						if (Application.redirectOverlayTime === 0) {

							document.location = _redirectAtEnd;

						}

					}, 1000);

				}

			}
		
		}, false);

	}

});

/**
 * Scripts/share-video.js
 *
 * SHARE
 */

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#share-video-icon")) {

			return false;

		}

		El("#share-video-icon").onclick = function() {

			var shareVideoBlock = El("#share-video-block"),
				videoInfoDescription = El("#video-info-description");

			if (videoInfoDescription.hasClass("little")) {

				videoInfoDescription.removeClass("little");

			}

			else {

				videoInfoDescription.className += " little";

			}

			if (shareVideoBlock.hasClass("show")) {

				shareVideoBlock.removeClass("show");

			}

			else {

				shareVideoBlock.className += " show";

			}

		};

	}

});

/**
 * Scripts/add-playlist.js
 *
 * ADD VIDEO TO PLAYLIST
 */

function initPlaylistCheckbox(checkbox) {

	El(checkbox).on("change", function(checkbox) {
	
		return function() {
	
			if (checkbox.checked) {

				addVideoToPlaylist(checkbox.getAttribute("data-playlist-id"), _VIDEO_ID_);

			}

			else {

				removeVideoFromPlaylist(checkbox.getAttribute("data-playlist-id"), _VIDEO_ID_);

			}
	
		};
	
	}(checkbox));

}

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#add-playlist-icon")) {

			return false;

		}

		El("#add-playlist-icon").onclick = function() {

			var videoInfoDescription = El("#video-info-description");

			if (videoInfoDescription.hasClass("playlist")) {

				videoInfoDescription.removeClass("export");
				videoInfoDescription.removeClass("playlist");

			}

			else {

				videoInfoDescription.removeClass("export");
				videoInfoDescription.className += " playlist";

			}

		};

		var childs = El("#playlist-add-form-list").childNodes;

		for (child in childs) {
		
			if (childs.hasOwnProperty(child)) {
		
				if (childs[child].nodeName === "INPUT") {

					initPlaylistCheckbox(childs[child]);

				}

			}
			
		}

	}

});

/**
 * Scripts/bg-loader.js
 *
 * BACKGROUND LOADER
 */

function elementInViewport(el) {

	var top = el.offsetTop;
	var left = el.offsetLeft;
	var width = el.offsetWidth;
	var height = el.offsetHeight;

	while(el.offsetParent) {

		el = el.offsetParent;
		top += el.offsetTop;
		left += el.offsetLeft;

	}

	return (

		top >= window.pageYOffset &&
		left >= window.pageXOffset &&
		(top + height) <= (window.pageYOffset + window.innerHeight) &&
		(left + width) <= (window.pageXOffset + window.innerWidth)

	);

}

function BackgroundLoader(element) {

    this.element = El(element);
    this.src = this.element.getAttribute("data-background");
    this.element.style.backgroundImage = "url(" + this.src + ")";

    this.loadInView = typeof this.element.getAttribute("data-background-load-in-view") === "string" ? true : false;

    if (!this.loadInView || elementInViewport(this.element)) {

    	this.loadBackground();

	}

	else {

		BackgroundLoader.elementsToCheck.push(this);

	}

}

BackgroundLoader.elementsToCheck = [];

BackgroundLoader.prototype.loadBackground = function() {

	this.backgroundLoading = true;

	this.imgLoader = new Image();
	this.imgLoader.src = this.src;

	El(this.imgLoader).on("load", function(event, element) {

	    element.addClass("bg-loader-transition");
	    element.addClass("bg-loaded");

	    setTimeout(function(element) {

	        return function() {

	            element.removeClass("bg-loader-transition");

	        }

	    }(element), 400);

	}, this.element);

};

El(window).on("scroll", function() {

	for (var i = 0, length = BackgroundLoader.elementsToCheck.length; i < length; i++) {
		
		var bg = BackgroundLoader.elementsToCheck[i];

		if (elementInViewport(bg.element) && !bg.backgroundLoading) {

			bg.loadBackground();

		}
	
	}

});

new Script({

	call: function() {

		var elements = document.getElementsByClassName("bg-loader");

		if (elements && elements.length) {

		    for (var i = 0, length = elements.length; i < length; i++) {

		        new BackgroundLoader(elements[i]);

		    }

		}

	}

});

/**
 * Scripts/test.js
 *
 * TEST SCRIPT
 */

new Script({

	call: function() {

		/*console.log(El(document.body).add(Co('<card vid-id="${vid_id}" title="${title}" thumbnail="${thumbnail}" duration="${duration}" views="${views}" channel="${channel}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			title: "Très le titre",
			thumbnail: "//lorempicsum.com/up/255/200/2",
			duration: "12:18",
			views: "37",
			channel: "bla",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(Co('<card type="plus" vid-id="${vid_id}" thumbnail="${thumbnail}" relative-time="${relative_time}" vid-name="${vid_name}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			thumbnail: "//lorempicsum.com/up/255/200/2",
			relative_time: "il y a 2 minutes",
			vid_name: "Nom",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(Co('<card type="comment" vid-id="${vid_id}" comment="${comment}" relative-time="${relative_time}" vid-name="${vid_name}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			comment: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, laboriosam, nobis mollitia, autem similique atque repellendus beatae qui cum minima voluptas earum aliquid! Possimus aliquid delectus, illum laborum recusandae cum.",
			relative_time: "il y a 2 minutes",
			vid_name: "Nom",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(Co('<card type="channel" avatar="${avatar}" subscribers="${subscribers}" relative-time="${relative_time}" my-channel-name="${my_channel_name}" channel="${channel}" channel-name="${channel_name}"/>', {

			avatar: "//lorempicsum.com/up/255/200/2",
			relative_time: "il y a 2 minutes",
			subscribers: 13,
			my_channel_name: "Me",
			channel: "Bla",
			channel_name: "Bla"

		}))[0]);*/

	}

});

/**
 * Scripts/test.js
 *
 * TEST SCRIPT
 */

function postMessage() {

 	marmottajax.post({

 		url: _webroot_ + "posts",
 		json: true,

 		options: {

 			"post-message-submit": "lol",
 			channel: El("#channel-social-message-submit").getAttribute("data-channel-id"),
 			"post-content": El("#post-content").value

 		}

 	}).then(function(channel) {

 		return function(result) {
	
 			El("#channel-posts").addFirst(Co('<channel-post avatar="${avatar}" channel="${channel}" message="${message}"/>', {
	
 				avatar: _my_avatar_,
 				channel: _my_pseudo_,
 				message: result.content
	
 			}));

 		}

 	}(El("#channel-social-message-submit").getAttribute("data-channel-id")));

 	El("#post-content").value = "";

}

new Script({

	pages: ["channel"],

	call: function() {

		var channelSocialMessageSubmit = El("#channel-social-message-submit");

		if (channelSocialMessageSubmit) {

			channelSocialMessageSubmit.onclick = postMessage;

			El("#post-content").on("keydown", function(event) {

			    if (event.keyCode === 13 && event.ctrlKey) {

			        postMessage();

			    }

			});

		}

	}

});
/*
 * Live chat
 */

 window.requestAnimationFrame = (function() {
     return window.requestAnimationFrame ||
         window.webkitRequestAnimationFrame ||
         window.mozRequestAnimationFrame ||
         function(callback) {
             window.setTimeout(callback, 1000 / 60);
     };
 })();

function ChatMessage() {
	var that = this;

	this.data = '';
	this.sender = '';
	this.content = '';
	this.messageType = 'text';
	this.channel = Chat.channel;
	this.timestamp = Math.round(+new Date() / 1000);

	this.construct = function(sender, content, sessionId) {
		that.sender = sender;
		that.content = content;

		if(content.lastIndexOf('/', 0) == 0) {
			that.messageType = 'command';
		}

		var dataArray = {
			"sender_name": that.sender,
			"content": that.content,
			"messageType": that.messageType,
			"channel": that.channel,
			"timestamp": that.timestamp
		};

		if(typeof sessionId == 'undefined') {

		}
		else {
			if(sessionId.length > 0) {
				dataArray.sessionId = sessionId;
			}
		}

		that.data = JSON.stringify(dataArray);
	};

	this.parse = function(jsonData) {
		try {
			var json = JSON.parse(jsonData);

			that.sender = json.sender_name;
			that.content = json.content;
			that.messageType = json.messageType;
			that.timestamp = json.timestamp;
		}
		catch(e) { alert(e);  }
	};

};

var Screen = {
	pushMessage: function(message) {
		var panel = document.getElementById("messages-panel");

		var el = document.createElement("div");
		el.className = "live-chat__message";

		var username = document.createElement('span');
		username.className = "live-chat__message__pseudo " + (message.rank ? "live-chat__message__pseudo--" + message.rank : "");
		var text = document.createTextNode(message.sender);
		username.appendChild(text);

		var messageElem = document.createElement('p');
		var messageText = document.createTextNode(message.content);
		messageElem.appendChild(messageText);

		el.appendChild(username);
		el.appendChild(messageElem);

		panel.appendChild(el);

		Chat.scrollDown();

		var maxMessagesInList = 32;

		if (panel.childNodes.length > maxMessagesInList) {

			for (var i = 0; panel.childNodes.length > maxMessagesInList;) {
				
				panel.removeChild(panel.childNodes[i])
			
			}

		}

	},

	pushText: function(message, type) {
		var panel = document.getElementById('messages-panel');

		var el = document.createElement('div');
		el.className = 'live-chat__message ' + "live-chat__message--" + type;

		var messageElem = document.createElement('p');

		var typeText = {

			error: "Erreur",
			info: "Information"

		};

		var messageText = document.createElement('span');
		messageText.className = 'live-chat__message__pseudo';
		messageText.innerHTML = (typeText[type] || type) + ' : ' + message;

		messageElem.appendChild(messageText);

		el.appendChild(messageElem);

		panel.appendChild(el);
		panel.scrollTop = panel.scrollHeight;


	},


	clearFirst: function() {
		var panel = document.getElementById('messages-panel');
		panel.removeChild(panel.firstChild);
	}
};

var Chat = {

	connected: false,
	socket: null,
	address: '127.0.0.1',
	port: 8080,
	channel: '',
	username: 'Dreamer',
	sessionId: '',
	scrolling: false,
	isHover: false,
	scrollSpeed: 0,

	start: function() {
		this.socket = new WebSocket('ws://' + this.address + ':' + this.port + '/' + this.channel);

		this.socket.onopen = this.onConnect;
		this.socket.onclose = this.onDisconnect;
		this.socket.onmessage = this.onMessage;
		this.socket.onerror = this.onError;

	},

	onConnect: function(event) {
		// send an empty message to init the connection
		var msg = new ChatMessage();
		msg.construct(Chat.username, '', Chat.sessionId);
		Chat.socket.send(msg.data);

		Chat.connected = true;
		Screen.pushText('Connected maggle ! Welcome !', 'info');
	},

	onMessage: function(event) {
		try {
			var message = new ChatMessage();
			message.parse(event.data);

			Screen.pushMessage(message);
		}
		catch(e) {
			Screen.pushText(e.message, 'error');
		}
	},

	onDisconnect: function(event) {
		Chat.connected = false;
		Screen.pushText('Disconnected', 'info');
	},

	onError: function(event) {
		Screen.pushText("WebSocket error", 'error');
	},

	scrollDown: function() {

		if (!Chat.scrolling && !Chat.isHover) {

			Chat.scrollInterval();

		}

	},

	scrollInterval: function() {

		var panel = document.getElementById("messages-panel");

	    Chat.scrolling = true;
	    speed = Math.abs(panel.scrollTop + panel.offsetHeight - panel.scrollHeight) / 12 + 1;
	    Chat.scrollSpeed += Chat.scrollSpeed < speed ? speed / 5 : -speed / 8;

	    panel.scrollTop += !Chat.isHover ? Chat.scrollSpeed : 0;

	    if (panel.scrollTop + panel.offsetHeight < panel.scrollHeight) {

	        requestAnimationFrame(Chat.scrollInterval);

	    }

	    else {

	        Chat.scrollSpeed = 0;
	        Chat.scrolling = false;

	    }

	}

};

function initChat(opts) {

	Chat.address = opts.ip;
	Chat.port = opts.port;
	Chat.channel = opts.channel;
	Chat.username = opts.username ? opts.username : 'Dreamer';
	Chat.sessionId = opts.sessionId;

	window.onkeypress = keyPress;

	Chat.start();

	var panel = document.getElementById("messages-panel");

	panel.addEventListener("mouseover", function() {

	    Chat.isHover = true;

	});

	panel.addEventListener("mouseout", function() {

	    Chat.isHover = false;

	});

	panel.addEventListener("mousewheel", function(event) {

	    panel.scrollTop += event.wheelDelta > 0 || event.detail < 0 ? -30 : 30;

	});

}

function sendChatMessage() {
	if(Chat.connected) {
		var contentInput = document.getElementById('live-chat-input');
		var message = new ChatMessage();

		message.construct(Chat.username, contentInput.value, Chat.sessionId);

		Chat.socket.send(message.data);
		contentInput.value = '';
	}
}

function keyPress(event) {
	if(typeof event == 'undefined' && window.event)
		event = window.event;

	var contentInput = document.getElementById('live-chat-input');

	if(document.activeElement == contentInput && event.keyCode == 13) {
		sendChatMessage();
	}
}

new Script({

	pages: ["live"],

	call: function() {

		initChat(chatLiveOptions);

	}

});

/**
 * scripts/comment.js
 *
 * COMMENT
 */

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#post-comment-button")) {

			return false;

		}

		El("#post-comment-button").onclick = function() {

			postComment(El("#post-comment-button").getAttribute("data-vid-id"), El("#textarea-comment").value, El("#channel-selector").value, El("#parent-comment").value);

		};

	}

});

function postComment(vid, commentContent, fromChannel, parent) {

	marmottajax.post({

		url: _webroot_ + "comments/",

		options: {

			commentSubmit: "lol",
			"comment-content": commentContent,
			"from-channel": fromChannel,
			"video-id": vid,
			parent: parent

		}

	}).then(function(fromChannel) {

		return function(result) {

			var comment = JSON.parse(result);

			comment.channelUrl = fromChannel;
			comment.avatar = _my_avatar_;
			comment.plusNumber = 0;
			comment.moinsNumber = 0;
			comment.date = "À l'instant";

			El("#comments-best").addFirst(Co('<comment data="${data}"/>', { data: comment }));

		}

	}(fromChannel));

	El("#textarea-comment").value = "";

}

/**
 * Scripts/embed-video.js
 *
 * EMBED VIDEO
 */

function setExporterInputValue() {

	if (!El("#exporter-input")) {

		return false;

	}

	var exporterInput = El("#exporter-input"),

		exporterQuality = El("#exporter-quality"),
		exporterAutoplay = El("#exporter-autoplay"),
		exporterTimeCheckbox = El("#exporter-time-checkbox"),
		exporterTimeInput = El("#exporter-time-input");

	var url = "//dreamvids.fr/embed/video/" + _VIDEO_ID_;

	var quality = exporterQuality.options[exporterQuality.value].innerHTML || "640x360",
		qualitys = quality.split("x");
		width = qualitys[0],
		height = qualitys[1];

	var autoplay = exporterAutoplay.checked || false;

	if (autoplay) {

		url += "/autoplay";

	}

	var startAt = exporterTimeCheckbox.checked || false;

	if (startAt) {

		var timeUrlFormat = ["s", "m", "h"];

		var startTime = exporterTimeInput.value,
			times = startTime.split(":").reverse();

		for (var i = 0; i < times.length; i++) {

			/*url += i === 0 & !autoplay ? "?" : "&";

			url += timeUrlFormat[i] + "=" + times[i];*/

			url += times[i] + '/';

		}

	}

	exporterInput.value = "<iframe width=\"" + width + "\" height=\"" + height + "\" src=\"" + url + "\" allowfullscreen frameborder=\"0\"></iframe>";

}

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#embed-video-icon")) {

			return false;

		}

		El("#embed-video-icon").onclick = function() {

			var videoInfoDescription = El("#video-info-description");

			if (videoInfoDescription.hasClass("export")) {

				videoInfoDescription.removeClass("playlist");
				videoInfoDescription.removeClass("export");

			}

			else {

				videoInfoDescription.removeClass("playlist");
				videoInfoDescription.className += " export";

				El("#exporter-input").select();

			}

		};

		El("#exporter-quality").onchange = setExporterInputValue;
		El("#exporter-autoplay").onchange = setExporterInputValue;
		El("#exporter-time-checkbox").onchange = setExporterInputValue;
		El("#exporter-time-input").onchange = setExporterInputValue;

		setExporterInputValue();

	}

});

/**
 * Scripts/model.js
 *
 * EXAMPLE SCRIPT
 */

new Script({

	pages: ["default", "watch"], // Pages

	// OU // pages: "all", // OU ne pas spécifier

	call: function() { // Fonction appelée lorsque la page peut être manipulée

		// console.log("Il pleut!", "{example script}");

	}

});

/**
 * scripts/playlist-scroll.js
 *
 * PLAYLIST SCROLL BUTTONS
 */

function playListScroll(data) {

    El("#playlist-videos").scrollLeft += data;

}

new Script({

    pages: ["watch"],

	call: function() {

        if (!document.getElementById("playlist-button-scroll-left")) {

            return false;

        }

		var buttonLeft = El("#playlist-button-scroll-left"),
            buttonRight = El("#playlist-button-scroll-right");

        buttonLeft.onclick = function() {

            playListScroll(-300);

        };

        buttonRight.onclick = function() {

            playListScroll(200);

        };

	}

});

/**
 * scripts/redirect-at-end.js
 * 
 * Redirect at the end of the video
 */

function redirectOverlayUpdate() {

	var redirectAtEnd = document.getElementById("redirect-at-end");

	redirectAtEnd.innerHTML = redirectAtEnd.getAttribute("data-message").replace("{time}", Application.redirectOverlayTime) + "<br>";

	var cancel = document.createElement("div");
	cancel.className = "video__redirect-at-end__cancel";
	cancel.innerHTML = redirectAtEnd.getAttribute("data-cancel-message");

	cancel.onclick = cancelRedirectOverlay;

	redirectAtEnd.appendChild(cancel);

};

function cancelRedirectOverlay() {

	var redirectAtEnd = document.getElementById("redirect-at-end");

	clearInterval(Application.redirectOverlayInterval);

	Application.redirectOverlayTime = 5;
	Application.redirectOverlay = false;

	redirectAtEnd.className = redirectAtEnd.className.replace("video__redirect-at-end--show", "");

};

new Script({

    pages: ["watch"],

	call: function() {

		var video = document.getElementById("video-tag");

		if (!video) {

		    return false;

		}

		Application.redirectOverlay = false;

		video.addEventListener("ended", function(event) {

			if (!Application.redirectOverlay) {

				Application.redirectOverlay = true;
				
				if (typeof _redirectAtEnd !== "undefined" && _redirectAtEnd !== "") {

					var redirectAtEnd = document.getElementById("redirect-at-end");

					Application.redirectOverlayTime = 5;

					redirectOverlayUpdate();

					if (redirectAtEnd.className.indexOf("video__redirect-at-end--show") < 0) {

						redirectAtEnd.className += " video__redirect-at-end--show";

					}

					if (Application.redirectOverlayInterval) {

						clearInterval(Application.redirectOverlayInterval);

						Application.redirectOverlayInterval = null;

					}

					Application.redirectOverlayInterval = setInterval(function() {

						Application.redirectOverlayTime --;

						redirectOverlayUpdate();

						if (Application.redirectOverlayTime === 0) {

							document.location = _redirectAtEnd;

						}

					}, 1000);

				}

			}
		
		}, false);

	}

});

/**
 * Scripts/share-video.js
 *
 * SHARE
 */

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#share-video-icon")) {

			return false;

		}

		El("#share-video-icon").onclick = function() {

			var shareVideoBlock = El("#share-video-block"),
				videoInfoDescription = El("#video-info-description");

			if (videoInfoDescription.hasClass("little")) {

				videoInfoDescription.removeClass("little");

			}

			else {

				videoInfoDescription.className += " little";

			}

			if (shareVideoBlock.hasClass("show")) {

				shareVideoBlock.removeClass("show");

			}

			else {

				shareVideoBlock.className += " show";

			}

		};

	}

});