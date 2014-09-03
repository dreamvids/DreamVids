
/**
 * scripts/comment.js
 *
 * COMMENT
 */

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#post-comment-button")) {

			return false;

		}

		El("#post-comment-button").onclick = function() {

			postComment(El("#post-comment-button").getAttribute("data-vid-id"), El("#textarea-comment").value, El("#channel-selector").value, El("#parent-comment").value);

		};

	}

});

function postComment(vid, commentContent, fromChannel, parent) {

	marmottajax.post({

		url: "../comments/",

		options: {

			commentSubmit: "lol",
			"comment-content": commentContent,
			"from-channel": fromChannel,
			"video-id": vid,
			parent: parent

		}

	}).then(function(fromChannel) {

		return function(result) {

			var comment = JSON.parse(result);

			comment.channelUrl = fromChannel;
			comment.avatar = _my_avatar_;
			comment.plusNumber = 0;
			comment.moinsNumber = 0;
			comment.date = "À l'instant";

			El("#comments-best").addFirst(Co('<comment data="${data}"/>', { data: comment }));

		}

	}(fromChannel));

	El("#textarea-comment").value = "";

}