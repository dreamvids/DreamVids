
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