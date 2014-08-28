
/**
 * Components/channel-post.js
 *
 * Channel social post component
 */

new Co({

	name: "channel-post",

	render: function($) {

		var channel_post = new Element("div.channel-post");
	
			var avatar = channel_post.add(new Element("img"));
			avatar.src = $.avatar;
	
			var p = channel_post.add(new Element("p"));
	
				var channel_name = p.add(new Element("span.channel-name"));
				channel_name.innerHTML = $.channel;
	
			p.innerHTML += " a posté un message :";
	
			var message = channel_post.add(new Element("div.social-message"));
			message.innerHTML = $.message;
	
		return channel_post;
	
	}

});

/* TEMPLATE

<div class="channel-post">

	<img src="${avatar}">
	<p><span class="channel-name">${name}</span> a posté un message :</p>
	<div class="social-message">${message}</div>

</div> */