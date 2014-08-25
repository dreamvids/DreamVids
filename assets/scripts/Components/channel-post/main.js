
/**
 * Components/channel-post/main.js
 *
 * Channel social post component
 */

var c_channel_post = new Component("channel-post");

c_channel_post.render = function(component, $) {

	var channel_post = component.add(new Element("div.channel-post"));

		var avatar = channel_post.add(new Element("img"));
		avatar.src = $.avatar;

		var p = channel_post.add(new Element("p"));

			var channel_name = p.add(new Element("span.channel-name"));
			channel_name.innerHTML = $.channel;

		p.innerHTML += " a posté un message :";

		var message = channel_post.add(new Element("div.social-message"));
		message.innerHTML = $.message;

	component.inner(channel_post);

};

/* TEMPLATE

<div class="channel-post">

	<img src="${avatar}">
	<p><span class="channel-name">${name}</span> a posté un message :</p>
	<div class="social-message">${message}</div>

</div> */