
/**
 * scripts/playlist-scroll.js
 *
 * PLAYLIST SCROLL BUTTONS
 */

function playListScroll(data) {

    El("#playlist-videos").scrollLeft += data;

}

new Script({

    pages: ["watch"],

	call: function() {

        if (!document.getElementById("playlist-button-scroll-left")) {

            return false;

        }

		var buttonLeft = El("#playlist-button-scroll-left"),
            buttonRight = El("#playlist-button-scroll-right");

        new Hammer(buttonLeft).on("tap", function() {

            playListScroll(-300);

        });

        new Hammer(buttonRight).on("tap", function() {

            playListScroll(200);

        });

	}

});