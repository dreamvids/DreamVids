
/**
 * Scripts/bg-loader.js
 *
 * BACKGROUND LOADER
 */

function background_loader(element) {

    this.element = El(element);
    this.src = this.element.getAttribute("data-background");;
    this.element.style.backgroundImage = "url(" + this.src + ")";

    this.imgLoader = new Image();
    this.imgLoader.src = this.src;

    on(this.imgLoader, "load", function(event, element) {

        element.remove_class("bg-loader");

        element.add_class("bg-loader-transition");
        element.add_class("bg-loaded");

        setTimeout(function(element) {

            return function() {

                element.remove_class("bg-loader-transition");

            }

        }(element), 300);

    }, element);

 }

new Script({

	call: function() {

		var elements = document.getElementsByClassName("bg-loader");

		if (elements && elements.length) {

		    for (var i = 0, length = elements.length; i < length; i++) {

		        new background_loader(elements[i]);

		    }

		}

	}

});