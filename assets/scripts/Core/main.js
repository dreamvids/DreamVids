
/**
 * Core/main.js
 *
 * MAIN CORE FILE
 */

var _scripts_ = [];

var Script = function(script) {

	this.pages = script.pages;

	this.to_call = script.call;

	_scripts_.push(this);

};

Script.prototype.call = function() {
	
	this.to_call();

};