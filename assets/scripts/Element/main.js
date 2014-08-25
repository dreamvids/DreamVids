
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

			element.className = (" " + element.className + " ").replace( " " + name + " ", "");;

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