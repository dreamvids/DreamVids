
/**
 * Events/CLICK.js
 *
 * CLICK event
 */

Application.Events.on_tap_events_list = [];

Application.Events.add("CLICK", function(element, callback) {

	var event_listener = new Application.Events.on_tap_object(element, callback);

	Application.Events.on_tap_events_list.push(event_listener);

});

Application.Events.on_tap_object = function(element, callback) {

	this.callback = callback;
	this.element = element;

	this.touchstart = function(event_listener) {

		return function(event) {

			event_listener.moved = false;

			event_listener.startX = event.touches[0].clientX;
			event_listener.startY = event.touches[0].clientY;

		}

	}(this);

	this.touchmove = function(event_listener) {

		return function(event) {

			if (Math.abs(event.touches[0].clientX - event_listener.startX) > 10 || Math.abs(event.touches[0].clientY - event_listener.startY) > 10) {
			    
			    event_listener.moved = true;

			}

		}

	}(this);

	this.touchend = function(event_listener) {

		return function(event) {

			if (!event_listener.moved) {

				event_listener.callback(event);

			}

		}

	}(this);

	on(this.element, "touchstart", this.touchstart);
	on(this.element, "touchmove", this.touchmove);
	on(this.element, "touchend", this.touchend);
	on(this.element, "touchcancel", this.touchend);

	on(this.element, "click", function(event, event_listener) {

	    if (!("ontouchstart" in window)) {

	        event_listener.callback(event);

	    }

	}, this);

};