
/**
 * Scripts/bg-loader.js
 *
 * BACKGROUND LOADER
 */

function backgroundLoader(element) {

    this.element = El(element);
    this.src = this.element.getAttribute("data-background");;
    this.element.style.backgroundImage = "url(" + this.src + ")";

    this.imgLoader = new Image();
    this.imgLoader.src = this.src;

    El(this.imgLoader).on("load", function(event, element) {

        element.removeClass("bg-loader");

        element.addClass("bg-loader-transition");
        element.addClass("bg-loaded");

        setTimeout(function(element) {

            return function() {

                element.removeClass("bg-loader-transition");

            }

        }(element), 300);

    }, this.element);

 }

new Script({

	call: function() {

		var elements = document.getElementsByClassName("bg-loader");

		if (elements && elements.length) {

		    for (var i = 0, length = elements.length; i < length; i++) {

		        new backgroundLoader(elements[i]);

		    }

		}

	}

});