
/**
 * Components/btn/main.js
 *
 * Button component
 */

var c_btn = new Component("btn");

c_btn.render = function(component, $) {

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

	if (!$["no-ripple"]) {

		El(btn).add(DOM('<ripple parent="${parent}"/>', {

			parent: btn

		}));

	}

};

/* TEMPLATE

<btn type="flat|raised" color? click? no-ripple?>@{inner}</btn> */