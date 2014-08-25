
/**
 * Scripts/test.js
 *
 * TEST SCRIPT
 */

new Script({

	pages: ["channel"],

	call: function() {

		console.log('test');

	}

});

function postMessage() {

	marmottajax.post({

		url: "../../../posts",

		options: {

			"post-message-submit": "lol",
			channel: El("#channel-social-message-submit").getAttribute("data-channel-id"),
			"post-content": El("#post-content").value

		}

	}).then(function(result) {

		try {

			var json = JSON.parse(result);
			
			var postDiv = document.createElement('div');
			postDiv.className = 'channel-post';
			postDiv.setAttribute('style', 'background-color: #40a6e0; width: 50%; padding: 10px; margin-bottom: 1%;');

			var content = document.createTextNode(json.content);
			postDiv.appendChild(content);

			El("#channel-posts").add_first(postDiv);

		}

		catch(e) {}

	});

	document.getElementById("post-content").value = '';

}

El("#channel-social-message-submit").on("click", postMessage);

El("#post-content").on("keydown", function(event) {

    if (event.keyCode === 13 && event.ctrlKey) {

        postMessage();

    }

});