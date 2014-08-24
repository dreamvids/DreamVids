
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