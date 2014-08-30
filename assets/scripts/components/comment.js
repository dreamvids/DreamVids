
/**
 * components/comment.js
 *
 * Comment component
 */

new Co({

	name: "comment",

	render: function($) {

		if (!$.data) {

			return;

		}

		var comment = $.data;

		var commentDiv = new El("div.comment");

			var headDiv = commentDiv.add(new El("div.comment-head"));

				var userDiv = headDiv.add(new El("div.user"));

					var avatar = userDiv.add(new El("img"));
					avatar.src = _my_avatar_;

					var a = userDiv.add(new El("a"));
					a.href  = "../channel/" + comment.channelUrl;
					a.innerHTML = comment.author;

				var dateDiv = headDiv.add(new El("div.date"));

					var p = dateDiv.add(new El("p"));
					p.innerHTML = comment.date;

			var textDiv = commentDiv.add(new El("div.comment-text"));

				var p1 = textDiv.add(new El("p"));
				p1.innerHTML = comment.comment;

			var noteDiv = commentDiv.add(new El("div.comment-notation"));

				var ul = noteDiv.add(new El("ul"));

					var li1 = ul.add(new El("li.plus"));
					var li2 = ul.add(new El("li.moins"));

					li1.id = "plus-" + comment.id;
					li2.id = "moins-" + comment.id;

					new Hammer(li1).on("tap", function(commentId) {

						return function() {

							likeComment(commentId);

						}

					}(comment.id));

					new Hammer(li2).on("tap", function(commentId) {

						return function() {

							dislikeComment(commentId)

						}

					}(comment.id));

					li1.innerHTML = "+" + comment.plusNumber;
					li2.innerHTML = "-" + comment.moinsNumber;

		return commentDiv;
	
	}

});