
/**
 * scripts/comment.js
 *
 * COMMENT
 */

new Script({

	pages: ["watch"],

	call: function() {

		DEBUG(["comment Script called", 'El("#post-comment-button") :', El("#post-comment-button").nodeName]);

		if (!El("#post-comment-button")) {

			return false;

		}

		var postCommentButton = El("#post-comment-button");

		postCommentButton.on("CLICK", function(event, postCommentButton) {

			DEBUG(["postCommentButton clicked", event, postCommentButton]);
			DEBUG(["postComment", postComment]);
			DEBUG([postCommentButton.getAttribute("data-vid-id"), El("#textarea-comment").value, El("#channel-selector").value, El("#parent-comment").value]);

			postComment(postCommentButton.getAttribute("data-vid-id"), El("#textarea-comment").value, El("#channel-selector").value, El("#parent-comment").value);

		}, postCommentButton);

	}

});

function postComment(vid, commentContent, fromChannel, parent) {

	DEBUG(["postComment called", {

		vid: vid,
		commentContent: commentContent,
		fromChannel: fromChannel,
		parent: parent

	}]);

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