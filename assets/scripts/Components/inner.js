
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