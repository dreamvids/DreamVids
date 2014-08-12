
/**
 * Scripts/share.js
 *
 * SHARE
 */

new Script({

	pages: ["watch"],

	call: function() {

		var share_video_icon = document.getElementById("share-video-icon") || document.createElement("div");

		on(share_video_icon, "CLICK", function() {

			var share_video_block = document.getElementById("share-video-block") || document.createElement("div"),
				video_info_description = document.getElementById("video-info-description") || document.createElement("div");

			if (share_video_block.className.search("show") > -1) {

				share_video_block.className = share_video_block.className.replace("show", "");
				video_info_description.className = video_info_description.className.replace("little", "");

			}

			else {

				share_video_block.className += " show";
				video_info_description.className += " little";

			}

		});

	}

});