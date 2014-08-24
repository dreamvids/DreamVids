
/**
 * Components/ripple/main.js
 *
 * Ripple component
 */

var c_ripple = new Component("ripple");

c_ripple.render = function(component, $) {

	var ripple = component.add(new Element("div.ripple"));

	component.inner(ripple);

	if ($.parent) {

		on($.parent, "mousedown", function(event, elements) {

			var ripple = elements.ripple,
				parent = elements.parent;

			if (El(parent).is_not_disabled()) {

				var circle = ripple.add(new El("div.ripple__circle.ripple__circle--animate"));

				var parent_offset = El(parent).offset();

				var click_x = event.changedTouches ? event.changedTouches[0].pageX : event.pageX,
					click_y = event.changedTouches ? event.changedTouches[0].pageY : event.pageY;

				circle.style.left = click_x - parent_offset.x + "px";
				circle.style.top = click_y - parent_offset.y + "px";

			}

		}, {

			ripple: ripple,
			parent: $.parent

		});

	}

};

/* TEMPLATE

<ripple parent="${parent-node}"/> */