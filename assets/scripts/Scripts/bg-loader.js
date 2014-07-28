
/**
 * Scripts/bg-loader.js
 *
 * BACKGROUND LOADER
 */

function background_loader(element) {

     this.element = element;
     this.src = this.element.getAttribute("data-background");;
     this.element.style.backgroundImage = "url(" + this.src + ")";

     this.imgLoader = new Image();
     this.imgLoader.src = this.src;

     this.imgLoader.addEventListener("load", function(event) {

         element.className = element.className.replace("bgLoader", "");
         element.className = element.className.replace("bg-loader", "");

         element.className += " bgLoaderTransition bgLoaded";
         element.className += " bg-loader-transition bg-loaded";

         setTimeout(function(element) {

             return function() {

                 element.className = element.className.replace("bg-loader-transition", "");

             }

         }(element), 300);

     }, false);

 }

var bg_loader = new Script({

	call: function() {

		var elements = document.getElementsByClassName("bgLoader");

		if (elements.length) {

			console.error(elements.length + " éléments possedent la classe bgLoader qui n'est plus utilisée.");

		}

		var new_class_elements = document.getElementsByClassName("bg-loader");

		for (var i = 0; i < new_class_elements.length; i++) {

			elements.push(new_class_elements[i]);
			
		}

		if (elements && elements.length) {

		    for (var i = 0, length = elements.length; i < length; i++) {

		        new background_loader(elements[i]);

		    }

		}

	}

});