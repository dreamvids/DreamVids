
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