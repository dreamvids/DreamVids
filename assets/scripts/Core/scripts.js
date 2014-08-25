
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