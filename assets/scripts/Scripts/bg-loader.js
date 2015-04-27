
/**
 * Scripts/bg-loader.js
 *
 * BACKGROUND LOADER
 */

function elementInViewport(el) {

	var top = el.offsetTop;
	var height = el.offsetHeight;

	while(el.offsetParent) {

		el = el.offsetParent;
		top += el.offsetTop;

	}

	return (

		   top >= window.pageYOffset && top <= (window.pageYOffset + window.innerHeight)

		|| top + height >= window.pageYOffset && top + height <= (window.pageYOffset + window.innerHeight)

	);

}

function BackgroundLoader(element) {

    this.element = El(element);
    this.src = this.element.getAttribute("data-background");
    this.element.style.backgroundImage = "url(" + this.src + ")";

    this.loadInView = typeof this.element.getAttribute("data-background-load-in-view") === "string" ? true : false;

    if (!this.loadInView || elementInViewport(this.element)) {

    	this.loadBackground();

	}

	else {

		BackgroundLoader.elementsToCheck.push(this);

	}

}

BackgroundLoader.elementsToCheck = [];

BackgroundLoader.prototype.loadBackground = function() {

	this.backgroundLoading = true;

	this.imgLoader = new Image();
	this.imgLoader.src = this.src;

	El(this.imgLoader).on("load", function(event, element) {

	    element.addClass("bg-loader-transition");
	    element.addClass("bg-loaded");

	    setTimeout(function(element) {

	        return function() {

	            element.removeClass("bg-loader-transition");

	        }

	    }(element), 400);

	}, this.element);

};

function reviewBackgroundLoaders() {

	for (var i = 0, length = BackgroundLoader.elementsToCheck.length; i < length; i++) {
		
		var bg = BackgroundLoader.elementsToCheck[i];

		if (elementInViewport(bg.element) && !bg.backgroundLoading) {

			bg.loadBackground();

		}
	
	}

}

El(window).on("scroll", reviewBackgroundLoaders);
El(window).on("resize", reviewBackgroundLoaders);

new Script({

	call: function() {

		var elements = document.getElementsByClassName("bg-loader");

		if (elements && elements.length) {

		    for (var i = 0, length = elements.length; i < length; i++) {

		        new BackgroundLoader(elements[i]);

		    }

		}

	}

});