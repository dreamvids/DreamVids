
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