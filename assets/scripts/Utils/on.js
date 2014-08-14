
/**
 * Utils/on.js
 *
 * EVENT LISTENER
 */

function on(element, event, callback) {

	if (event === "CLICK") {

		Application.onTap(element, callback);

	}

	else {

		if (element.addEventListener) {

			element.addEventListener(event, callback, false);

		}

		else {

			element.attachEvent(event, callback);
			
		}

	}

	return element;

}