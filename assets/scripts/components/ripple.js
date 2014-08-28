
/**
 * components/ripple.js
 *
 * Ripple component
 */

new Component({

	name: "ripple",

	render: function($) {

		var ripple = new Element("div.ripple");
	
		if ($.parent) {

			var event = "ontouchstart" in window ? "touchstart" : "mousedown";
	
			El($.parent).on(event, function(event, elements) {
	
				var ripple = elements.ripple,
					parent = elements.parent;

				if (!El(parent).hasClass("disabled")) {
	
					var circle = ripple.add(new El("div.ripple__circle.ripple__circle--animate"));
	
					var parentOffset = El(parent).offset();
	
					var clickX = event.changedTouches ? event.changedTouches[0].pageX : event.pageX,
						clickY = event.changedTouches ? event.changedTouches[0].pageY : event.pageY;
	
					circle.style.left = clickX - parentOffset.x + "px";
					circle.style.top = clickY - parentOffset.y + "px";
	
				}
	
			}, {
	
				ripple: ripple,
				parent: $.parent
	
			});
	
		}

		return ripple;
	
	}

});

/* TEMPLATE

<ripple parent="${parent-node}"/> */