
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