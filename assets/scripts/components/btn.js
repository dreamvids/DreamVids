
/**
 * components/main.js
 *
 * Button component
 */

new Component({

	name: "btn",

	render: function($) {

		var type = $.type === "raised" ? "raised" : "flat",
			color = $.color ? ".btn--" + $.color : "",
			outline_color = $.outline ? ".btn--outline-" + $.outline : "",
			ripple_color = $.ripple ? ".btn--ripple-" + $.ripple : "",
			disabled = isset($.disable) ? ".disabled" : "";
	
		var btn = new Element("div.btn.btn--" + type + color + outline_color + ripple_color + disabled);
	
		if (!disabled) {
	
			btn.tabIndex = 0;
	
		}

		if (typeof $.click === "function") {

			El(btn).on("CLICK", $.click, btn);

		}
	
		if (!$["no-ripple"]) {
	
			El(btn).add(Co('<ripple parent="${parent}"/>', {
	
				parent: btn
	
			}));
	
		}

		return btn;
	
	}

});

/* TEMPLATE

<btn type="flat|raised" color? click? no-ripple?>@{inner}</btn> */