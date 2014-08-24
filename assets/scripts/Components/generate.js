
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

	html = html.replace(/<(\w*)( (.+?))?\/>/g,'<$1$2></$1>');

	html = html.replace(/<(\w*)( (.+?))?>/g,'<div tag-name="$1"$2>').replace(/<\/(.+?)>/g,'</div>');

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