
/**
 * Scripts/embed-video.js
 *
 * EMBED VIDEO
 */

function setExporterInputValue() {

	if (!document.getElementById("exporter-input")) {

		return false;

	}

	var exporterInput = El("#exporter-input"),

		exporterQuality = El("#exporter-quality"),
		exporterAutoplay = El("#exporter-autoplay"),
		exporterTimeCheckbox = El("#exporter-time-checkbox"),
		exporterTimeInput = El("#exporter-time-input");

	var url = "//dreamvids.fr/embed/" + _VIDEO_ID_;

	var quality = exporterQuality.options[exporterQuality.value].innerHTML || "640x360",
		qualitys = quality.split("x");
		width = qualitys[0],
		height = qualitys[1];

	var autoplay = exporterAutoplay.checked || false;

	if (autoplay) {

		url += "/autoplay";

	}

	var startAt = exporterTimeCheckbox.checked || false;

	if (startAt) {

		var timeUrlFormat = ["s", "m", "h"];

		var startTime = exporterTimeInput.value,
			times = startTime.split(":").reverse();

		for (var i = 0; i < times.length; i++) {

			/*url += i === 0 & !autoplay ? "?" : "&";

			url += timeUrlFormat[i] + "=" + times[i];*/

			url += times[i] + '/';

		}

	}

	exporterInput.value = "<iframe width=\"" + width + "\" height=\"" + height + "\" src=\"" + url + "\" allowfullscreen frameborder=\"0\"></iframe>";

}

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#embed-video-icon")) {

			return false;

		}

		El("#embed-video-icon").onclick = function() {

			var videoInfoDescription = El("#video-info-description");

			if (videoInfoDescription.hasClass("export")) {

				videoInfoDescription.removeClass("playlist");
				videoInfoDescription.removeClass("export");

			}

			else {

				videoInfoDescription.removeClass("playlist");
				videoInfoDescription.addClass("export");

				El("#exporter-input").select();

			}

		};

		El("#exporter-quality").on("change", setExporterInputValue),
		El("#exporter-autoplay").on("change", setExporterInputValue),
		El("#exporter-time-checkbox").on("change", setExporterInputValue),
		El("#exporter-time-input").on("change", setExporterInputValue);

		setExporterInputValue();

	}

});