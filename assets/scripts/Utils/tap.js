
/**
 * Utils/tap.js
 *
 * TAP EVENT
 */

Application.onTapEventsList = [];

Application.onTap = function(element, callback) {

	var eventListener = new Application.onTapObject(element, callback);
	
	Application.onTapEventsList.push(eventListener);

};

Application.onTapObject = function(element, callback) {

	this.callback = callback;
	this.element = element;

	this.touchstart = function(eventListener) {

		return function(event) {

			eventListener.moved = false;

			eventListener.startX = event.touches[0].clientX;
			eventListener.startY = event.touches[0].clientY;

		}

	}(this);

	this.touchmove = function(eventListener) {

		return function(event) {

			if (Math.abs(event.touches[0].clientX - eventListener.startX) > 10 || Math.abs(event.touches[0].clientY - eventListener.startY) > 10) {
			    
			    eventListener.moved = true;

			}

		}

	}(this);

	this.touchend = function(eventListener) {

		return function(event) {

			if (!eventListener.moved) {

				eventListener.callback(event);

			}

		}

	}(this);

	on(this.element, "touchstart", this.touchstart);
	on(this.element, "touchmove", this.touchmove);
	on(this.element, "touchend", this.touchend);
	on(this.element, "touchcancel", this.touchend);

	on(this.element, "click", function(eventListener) {

		return function(event) {

	        if (!("ontouchstart" in window)) {

	            eventListener.callback(event);

	        }

	    };

	}(this));

};