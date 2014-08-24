
/**
 * Components/card/main.js
 *
 * Card component
 */

var c_card = new Component("card");

c_card.render = function(component, $) {

	var type = $.type === "raised" ? "raised" : "flat",
		color = $.color ? ".btn--" + $.color : "",
		outline_color = $.outline ? ".btn--outline-" + $.outline : "",
		ripple_color = $.ripple ? ".btn--ripple-" + $.ripple : "",
		disabled = isset($.disable) ? ".disabled" : "";

	var btn = component.add(new Element("div.btn.btn--" + type + color + outline_color + ripple_color + disabled));

	if (!disabled) {

		btn.tabIndex = 0;

	}

	component.inner(btn);

	if ($.click) {

		on(btn, "CLICK", $.click, btn);

	}

};

/* TEMPLATE

 */