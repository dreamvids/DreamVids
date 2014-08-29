
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

		buttonLeft.on("CLICK", function(event, elements) {

            var buttonLeft = El("#playlist-button-scroll-left"),
                buttonRight = El("#playlist-button-scroll-right"),
                playlistVideos = El("#playlist-videos");

            playListScroll(-300);

        });

        buttonRight.on("CLICK", function(event, elements) {

            var buttonLeft = El("#playlist-button-scroll-left"),
                buttonRight = El("#playlist-button-scroll-right"),
                playlistVideos = El("#playlist-videos");

            playListScroll(200);

        });

	}

});