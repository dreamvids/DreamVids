/**
 * ATTENTION ! IL EST INUTILE DE MODIFIER CE FICHIER
 * CAR  VOS  MODIFICATIONS SERONT  ECRASÉES  PAR  LE
 * PROCHAIN COMMIT
 *
 * Pour modifier le contenu de ce fichier, il faut
 * modifier ses sources qui se situent soit dans
 * le dossier `style`, le dossier `scripts` selon
 * vos besoin. Il faut ensuite compiler à l'aide du
 * lanceur de taches Grunt. Pour plus d'infos,
 * rendez-vous dans le README du dossier `assets`
 */
/*(function(win, doc){

var window = win,
	document = doc;*/

/**
 * main.js
 *
 * Fichier JavaScript principal.
 */

var Application = {

	name: "MarmWork"

};

/**
 * Events/main.js
 *
 * Add event to an element
 */

Application.Events = {

	list: {}

};

Application.Events.add = function(name, fn) {

	Application.Events.list[name] = fn;

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

	if (typeof Application.Events.list[event] === "function") {

		Application.Events.list[event](element, function() {

			return function(event) {

				callback(event, binding);

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

Application.Events.on_tap_events_list = [];

Application.Events.add("CLICK", function(element, callback) {

	var event_listener = new Application.Events.on_tap_object(element, callback);

	Application.Events.on_tap_events_list.push(event_listener);

});

Application.Events.on_tap_object = function(element, callback) {

	this.callback = callback;
	this.element = element;

	this.touchstart = function(event_listener) {

		return function(event) {

			event_listener.moved = false;

			event_listener.startX = event.touches[0].clientX;
			event_listener.startY = event.touches[0].clientY;

		}

	}(this);

	this.touchmove = function(event_listener) {

		return function(event) {

			if (Math.abs(event.touches[0].clientX - event_listener.startX) > 10 || Math.abs(event.touches[0].clientY - event_listener.startY) > 10) {
			    
			    event_listener.moved = true;

			}

		}

	}(this);

	this.touchend = function(event_listener) {

		return function(event) {

			if (!event_listener.moved) {

				event_listener.callback(event);

			}

		}

	}(this);

	on(this.element, "touchstart", this.touchstart);
	on(this.element, "touchmove", this.touchmove);
	on(this.element, "touchend", this.touchend);
	on(this.element, "touchcancel", this.touchend);

	on(this.element, "click", function(event, event_listener) {

	    if (!("ontouchstart" in window)) {

	        event_listener.callback(event);

	    }

	}, this);

};

/**
 * Core/$.js
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

on(document, "DOMContentLoaded", Application.on_dom_content_loaded);
on(window, "load", Application.on_dom_content_loaded);

window.onload = function() {

    Application.on_dom_content_loaded();

};

/**
 * Core/child-node-list.js
 *
 * Generate a list of childs of an element
 */

function child_node_list(element) {

	var array = [];

	for (var i = 0; i < element.childNodes.length; i++) {

		array.push(element.childNodes[i]);

		if (element.childNodes[i].childNodes) {

			var sub_childs = child_node_list(element.childNodes[i]);

			for (var c = 0; c < sub_childs.length; c++) {

				array.push(sub_childs[c]);

			}

		}

	}

	return array;

}

/**
 * Core/complete-vars.js
 *
 * Completer une chaine de caractère avec une variable objet
 */

function complete_vars(query, object, path) {

    add = path ? path + '.' : '';

    if (object instanceof Array) {

        for (var id = 0, length = object.length; id < length; id++) {

            query = object[id] instanceof Object ? query.complete(object[id], add + id) : query.replace('${' + add + id + '}', object[id]);

        }

    }

    else if (object instanceof Object) {

        for (var id in object) {

            query = object.hasOwnProperty(id) && object[id] instanceof Object ? query.complete(object[id], add + id) : query.replace('${' + add + id + '}', object[id]);

        }

    }

    return query;

}

/**
 * Core/isset.js
 *
 * Test if a variable is not `undefined`
 */

function isset(variable) {

	return typeof variable !== "undefined";

}

/*
 *  Marmottajax 1.0.4
 *  Envoyer et recevoir des informations simplement en JavaScript
 */

var marmottajax = function(options) {

    return marmottajax.get(options);

};

marmottajax.normalize = function(parameters) {

    return parameters ? typeof parameters === "string" ? { url: parameters } : parameters : null;

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

marmottajax.destroy = marmottajax.remove = marmottajax.delete_ = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.method = "DELETE";

        return new marmottajax.request(parameters);

    }

};

marmottajax.request = function(options) {

    if (!options) { return false; }

    if (typeof options === "string") {

        options = { url: options };

    }

    if (options.method === "POST" || options.method === "PUT" || options.method === "DELETE") {

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

    };

    this.xhr.onreadystatechange = function() {

        if (this.readyState === 4 && this.status == 200) {

            var result = this.responseText;

            if (this.options.json) {

                try {

                    result = JSON.parse(result);

                }

                catch (error) {

                    this.call("error", "invalid json");

                    return false;

                }

            }

            this.call("then", result);

        }

        else if (this.readyState === 4 && this.status == 404) {

            this.call("error", "404");

        }

        else if (this.readyState === 4) {

            this.call("error", "unknow");

        }

    };

    this.xhr.open(options.method, options.url, true);
    this.xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    this.xhr.send(typeof post != "undefined" ? post : null);

};

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
 * Element/main.js
 *
 * Element model
 */

function Element(name, settings) {

	if (this !== window) {

		var element = Element.create(name, settings);

	}

	else {

		var element = Element.select(name, settings);

	}

	element.childs = element.childNodes;
	element.parent = element.parentNode;
	element.clone = element.cloneNode;

	element.add = function(element) {

		return function(child) {

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
			
		}

	}(element);

	element.add_first = function(element) {

		return function(child) {

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
			
		}

	}(element);

	element.on = function(element) {

		return function(event, callback, binding) {

			on(element, event, callback, binding);

		}

	}(element);

	element.offset = function(element) {

		return function() {

			var offsets = {

				x: 0,
				y: 0

			}

			while (element) {

			    offsets.x += (element.offsetLeft - (element == document.body ? 0 : element.scrollLeft) + element.clientLeft);
			    offsets.y += (element.offsetTop - (element == document.body ? 0 : element.scrollTop) + element.clientTop);
			    element = element.offsetParent;

			}

			return offsets;

		}

	}(element);

	element.has_class = function(element) {

		return function(name) {

			return (" " + element.className + " ").indexOf(" " + name + " ") > -1;

		}

	}(element);

	element.add_class = function(element) {

		return function(name) {

			if (!El(element).has_class(name)) {

				element.className += " " + name;

			}

			return El(element);

		}

	}(element);

	element.remove_class = function(element) {

		return function(name) {

			element.className = (" " + element.className + " ").replace(" " + name + " ", " ");

			return El(element);

		}

	}(element);

	element.toogle_class = function(element) {

		return function(name) {

			if (El(element).has_class(name)) {

				El(element).remove_class(name);

			}

			else {

				El(element).add_class(name);

			}

			return El(element);

		}

	}(element);

	element.is_disabled = function(element) {

		return function() {

			return El(element).has_class("disabled");

		}

	}(element);

	element.is_not_disabled = function(element) {

		return function() {

			return !El(element).has_class("disabled");

		}

	}(element);

	element.disable = function(element) {

		return function() {

			element.tabIndex = 0;

			return El(element).add_class("disabled");

		}

	}(element);

	element.undisable = function(element) {

		return function() {

			element.tabIndex = 0;

			return El(element).remove_class("disabled");

		}

	}(element);

	element.inner = function(element) {

		var inner_element = document.createElement("div");

		inner_element.setAttribute("tag-name", "_inner_");

		element.appendChild(inner_element);

		return element;

	};

	return element;

};

Application.Element = Element;

var El = Element;

/**
 * Element/create.js
 *
 * Element create
 */

Element.create = function(name, settings) {

	var element,
		tag_name = /\w+/.exec(name)[0];

	if (Application.components[tag_name]) {

		var attributes = typeof settings === "object" ? settings : {};

		var component = Application.components[tag_name].create(attributes);

		child.parentNode.insertBefore(component, child);
		child.parentNode.removeChild(child);

	}

	else {

		element = document.createElement(tag_name);

	}

	var class_names = name.replace(/#([a-z-_]+)/i, "").replace(/\w+/, "").split(".");

	if (class_names.length > 1) {

		element.className = "";

		for (var i = 1; i < class_names.length; i++) {

			element.className += " " + class_names[i];

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

		element = document.getElementById(name.substring(1)) || new El("div");

	}
	
	return element;

};

/**
 * Components/main.js
 *
 * Component model
 */

Application.components = {};

function Component(name) {

	this.name = name;

	Application.components[name] = this;

};

var Co = Component;

Application.Component = Component;

/**
 * Components/attributes.js
 *
 * Transform attributes in an object
 */

Component.attributes_parser = function(attributes, parameters) {

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
 * Components/create.js
 *
 * Création d'un componenent
 */

Component.prototype.create = function(values) {

	var componenent = Element(document.createDocumentFragment());

	this.render(componenent, values);

	var DOM = document.createElement("div");
	DOM.appendChild(componenent);

	var childs = child_node_list(DOM);

	if (values._CHILDNODES_.length) {

		var inner_set = false;

		for (var i = 0; i < childs.length; i++) {

			var child = childs[i];

			if (child.getAttribute("tag-name") === "_inner_") {

				var length = values._CHILDNODES_.length;

				for (var i = 0; i < length; i++) {

					child.parentNode.insertBefore(values._CHILDNODES_[0], child);
					
				}

				child.parentNode.removeChild(child);

				inner_set = true;

				break;

			}

		}

		if (!inner_set) {

			console.error("L'intérieur du Component \"" + this.name + "\" n'est pas défini.");

			for (var i = 0; i < values._CHILDNODES_.length; i++) {

				DOM.firstChild.appendChild(values._CHILDNODES_[i]);
				
			}

		}

	}

	var fragment = document.createDocumentFragment();

	while (DOM.childNodes.length) {

		fragment.appendChild(DOM.childNodes[0]);

	}

	return fragment;

};

/**
 * Components/generate.js
 *
 * Components fragment generation
 */

var DOM = Component.generate = Component.gen = function(html, parameters) {

	if ("string" != typeof html) {

		return document.createElement("div");

	}

	html = html.replace(/^\s+|\s+$/g, "");

	html = html.replace(/<([-\w]*)( (.+?))?\/>/g,'<$1$2></$1>');

	html = html.replace(/<([-\w]*)( (.+?))?>/g,'<div tag-name="$1"$2>').replace(/<\/(.+?)>/g,'</div>');

	console.log(html);

	var element = document.createElement("div");
	element.innerHTML = html;

	var no_more_conponent = false,
		element_generated = false;
		loops = 0;

	while (!no_more_conponent) {

		element_generated = false;

		loops ++;

		if (loops > 10) {

			console.error("Une boucle de création de component a été détéctée");

			no_more_conponent = true;

		}
		
		var childs = child_node_list(element);

		for (var i = 0; i < childs.length; i++) {

			var child = childs[i];

			var tag_name = "";
			
			if (child.getAttribute) {

				tag_name = child.getAttribute("tag-name") || "";

			}

			if (Application.components[tag_name]) {

				var attributes = Component.attributes_parser(child.attributes, parameters);
				attributes._CHILDNODES_ = child.childNodes;

				var component = Application.components[tag_name].create(attributes);

				var element_created = component.firstChild;

				for (attribute in attributes) {

					if (attributes.hasOwnProperty(attribute) && element_created.getAttribute(attribute) === null && typeof attributes[attribute] === "string") {

						element_created.setAttribute(attribute, attributes[attribute]);

					}

				}

				element_created.removeAttribute("tag-name");

				child.parentNode.insertBefore(component, child);
				child.parentNode.removeChild(child);

				element_generated = true;

				break;

			}

		}

		if (!element_generated) {

			no_more_conponent = true;

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

	var inner_element = document.createElement("div");

	inner_element.setAttribute("tag-name", "_inner_")

	element.appendChild(inner_element);

	return element;

};

/**
 * Components/btn/main.js
 *
 * Button component
 */

var c_btn = new Component("btn");

c_btn.render = function(component, $) {

	var type = $.type === "raised" ? "raised" : "flat",
		color = $.color ? ".btn--" + $.color : "",
		outline_color = $.outline ? ".btn--outline-" + $.outline : "",
		ripple_color = $.ripple ? ".btn--ripple-" + $.ripple : "",
		disabled = isset($.disable) ? ".disabled" : "";

	var btn = component.add(new Element("div.btn.btn--" + type + color + outline_color + ripple_color + disabled));

	if (!disabled) {

		btn.tabIndex = 0;

	}

	component.inner(btn);

	if ($.click) {

		on(btn, "CLICK", $.click, btn);

	}

	if (!$["no-ripple"]) {

		El(btn).add(DOM('<ripple parent="${parent}"/>', {

			parent: btn

		}));

	}

};

/* TEMPLATE

<btn type="flat|raised" color? click? no-ripple?>@{inner}</btn> */

/**
 * Components/card/main.js
 *
 * Card component
 */

var c_card = new Component("card");

c_card.render = function(component, $) {

	var type = isset($.type) ? $.type : "video";

	if (type === "video") {

		var card = component.add(new El("div.card.video"));

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

		var card = component.add(new El("div.card.plus"));

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

		var card = component.add(new El("div.card.comment"));

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

		var card = component.add(new El("div.card.channel"));

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

	component.inner(card);

	if ($.click) {

		on(btn, "CLICK", $.click, btn);

	}

};

/**
 * Components/channel-post/main.js
 *
 * Channel social post component
 */

var c_channel_post = new Component("channel-post");

c_channel_post.render = function(component, $) {

	var channel_post = component.add(new Element("div.channel-post"));

		var avatar = channel_post.add(new Element("img"));
		avatar.src = $.avatar;

		var p = channel_post.add(new Element("p"));

			var channel_name = p.add(new Element("span.channel-name"));
			channel_name.innerHTML = $.channel;

		p.innerHTML += " a posté un message :";

		var message = channel_post.add(new Element("div.social-message"));
		message.innerHTML = $.message;

	component.inner(channel_post);

};

/* TEMPLATE

<div class="channel-post">

	<img src="${avatar}">
	<p><span class="channel-name">${name}</span> a posté un message :</p>
	<div class="social-message">${message}</div>

</div> */

/**
 * Components/ripple/main.js
 *
 * Ripple component
 */

var c_ripple = new Component("ripple");

c_ripple.render = function(component, $) {

	var ripple = component.add(new Element("div.ripple"));

	component.inner(ripple);

	if ($.parent) {

		on($.parent, "mousedown", function(event, elements) {

			var ripple = elements.ripple,
				parent = elements.parent;

			if (El(parent).is_not_disabled()) {

				var circle = ripple.add(new El("div.ripple__circle.ripple__circle--animate"));

				var parent_offset = El(parent).offset();

				var click_x = event.changedTouches ? event.changedTouches[0].pageX : event.pageX,
					click_y = event.changedTouches ? event.changedTouches[0].pageY : event.pageY;

				circle.style.left = click_x - parent_offset.x + "px";
				circle.style.top = click_y - parent_offset.y + "px";

			}

		}, {

			ripple: ripple,
			parent: $.parent

		});

	}

};

/* TEMPLATE

<ripple parent="${parent-node}"/> */

/**
 * Scripts/bg-loader.js
 *
 * BACKGROUND LOADER
 */

function background_loader(element) {

    this.element = El(element);
    this.src = this.element.getAttribute("data-background");;
    this.element.style.backgroundImage = "url(" + this.src + ")";

    this.imgLoader = new Image();
    this.imgLoader.src = this.src;

    on(this.imgLoader, "load", function(event, element) {

        element.remove_class("bg-loader");

        element.add_class("bg-loader-transition");
        element.add_class("bg-loaded");

        setTimeout(function(element) {

            return function() {

                element.remove_class("bg-loader-transition");

            }

        }(element), 300);

    }, element);

 }

new Script({

	call: function() {

		var elements = document.getElementsByClassName("bg-loader");

		if (elements && elements.length) {

		    for (var i = 0, length = elements.length; i < length; i++) {

		        new background_loader(elements[i]);

		    }

		}

	}

});

/**
 * Scripts/test.js
 *
 * TEST SCRIPT
 */

function postMessage() {

 	marmottajax.post({

 		url: "../../../posts",
 		json: true,

 		options: {

 			"post-message-submit": "lol",
 			channel: El("#channel-social-message-submit").getAttribute("data-channel-id"),
 			"post-content": El("#post-content").value

 		}

 	}).then(function(channel) {

 		return function(result) {
	
 			El("#channel-posts").add_first(DOM('<channel-post avatar="${avatar}" channel="${channel}" message="${message}"/>', {
	
 				avatar: _my_avatar_,
 				channel: channel,
 				message: result.content
	
 			}));

 		}

 	}(El("#channel-social-message-submit").getAttribute("data-channel-id")));

 	El("#post-content").value = "";

}

new Script({

	pages: ["channel"],

	call: function() {

		El("#channel-social-message-submit").on("click", postMessage);

		El("#post-content").on("keydown", function(event) {

		    if (event.keyCode === 13 && event.ctrlKey) {

		        postMessage();

		    }

		});

	}

});

/**
 * Scripts/embed-video.js
 *
 * SHARE
 */

function set_exporter_input_value() {

	if (!document.getElementById("exporter-input")) {

		return false;

	}

	var exporter_input = El("#exporter-input"),

		exporter_quality = El("#exporter-quality"),
		exporter_autoplay = El("#exporter-autoplay"),
		exporter_time_checkbox = El("#exporter-time-checkbox"),
		exporter_time_input = El("#exporter-time-input");

	var url = "//dreamvids.fr/embed/" + _VIDEO_ID_;

	var quality = exporter_quality.options[exporter_quality.value].innerHTML || "640x360",
		qualitys = quality.split("x");
		width = qualitys[0],
		height = qualitys[1];

	var autoplay = exporter_autoplay.checked || false;

	if (autoplay) {

		url += "/autoplay";

	}

	var start_at = exporter_time_checkbox.checked || false;

	if (start_at) {

		var time_url_format = ["s", "m", "h"];

		var start_time = exporter_time_input.value,
			times = start_time.split(":").reverse();

		for (var i = 0; i < times.length; i++) {

			/*url += i === 0 & !autoplay ? "?" : "&";

			url += time_url_format[i] + "=" + times[i];*/

			url += times[i] + '/';

		}

	}

	exporter_input.value = "<iframe width=\"" + width + "\" height=\"" + height + "\" src=\"" + url + "\" allowfullscreen frameborder=\"0\"></iframe>";

}

new Script({

	pages: ["watch"],

	call: function() {

		if (!document.getElementById("embed-video-icon")) {

			return false;

		}

		var embed_video_icon = El("#embed-video-icon");

		on(embed_video_icon, "CLICK", function() {

			var video_info_description = El("#video-info-description");

			if (video_info_description.has_class("export")) {

				video_info_description.remove_class("export");

			}

			else {

				video_info_description.add_class("export");

				El("#exporter-input").select();

			}

		});

		El("#exporter-quality").on("change", set_exporter_input_value),
		El("#exporter-autoplay").on("change", set_exporter_input_value),
		El("#exporter-time-checkbox").on("change", set_exporter_input_value),
		El("#exporter-time-input").on("change", set_exporter_input_value);

		set_exporter_input_value();

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
 * Scripts/share-video.js
 *
 * SHARE
 */

new Script({

	pages: ["watch"],

	call: function() {

		if (!document.getElementById("share-video-icon")) {

			return false;

		}

		var share_video_icon = El("#share-video-icon");

		share_video_icon.on("CLICK", function() {

			var share_video_block = El("#share-video-block"),
				video_info_description = El("#video-info-description");

			share_video_block.toogle_class("show");
			video_info_description.toogle_class("little");

		});

	}

});

/**
 * Scripts/test.js
 *
 * TEST SCRIPT
 */

new Script({

	call: function() {

		/*console.log(El(document.body).add(DOM('<card vid-id="${vid_id}" title="${title}" thumbnail="${thumbnail}" duration="${duration}" views="${views}" channel="${channel}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			title: "Très le titre",
			thumbnail: "//lorempicsum.com/up/255/200/2",
			duration: "12:18",
			views: "37",
			channel: "bla",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(DOM('<card type="plus" vid-id="${vid_id}" thumbnail="${thumbnail}" relative-time="${relative_time}" vid-name="${vid_name}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			thumbnail: "//lorempicsum.com/up/255/200/2",
			relative_time: "il y a 2 minutes",
			vid_name: "Nom",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(DOM('<card type="comment" vid-id="${vid_id}" comment="${comment}" relative-time="${relative_time}" vid-name="${vid_name}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			comment: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, laboriosam, nobis mollitia, autem similique atque repellendus beatae qui cum minima voluptas earum aliquid! Possimus aliquid delectus, illum laborum recusandae cum.",
			relative_time: "il y a 2 minutes",
			vid_name: "Nom",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(DOM('<card type="channel" avatar="${avatar}" subscribers="${subscribers}" relative-time="${relative_time}" my-channel-name="${my_channel_name}" channel="${channel}" channel-name="${channel_name}"/>', {

			avatar: "//lorempicsum.com/up/255/200/2",
			relative_time: "il y a 2 minutes",
			subscribers: 13,
			my_channel_name: "Me",
			channel: "Bla",
			channel_name: "Bla"

		}))[0]);*/

	}

});
/*
window.Application = Application;

})(window, document);*/