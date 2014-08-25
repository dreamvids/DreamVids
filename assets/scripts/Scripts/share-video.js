
/**
 * Scripts/share-video.js
 *
 * SHARE
 */

new Script({

	pages: ["watch"],

	call: function() {

		if (!document.getElementById("share-video-icon")) {

			return false;

		}

		var share_video_icon = El("#share-video-icon");

		share_video_icon.on("CLICK", function() {

			var share_video_block = El("#share-video-block"),
				video_info_description = El("#video-info-description");

			share_video_block.toogle_class("show");
			video_info_description.toogle_class("little");

		});

	}

});