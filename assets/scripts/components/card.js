
/**
 * Components/card.js
 *
 * Card component
 */

new Co({

	name: "card",

	render: function($) {

		var type = isset($.type) ? $.type : "video";
	
		if (type === "video") {
	
			var card = new El("div.card.video");
	
				var thumbnail = card.add(new El("div.thumbnail"));
				thumbnail.style.backgroundImage = "url(" + $.thumbnail + ")";
	
					var time = thumbnail.add(new El("div.time"));
					time.innerHTML = $.duration;
	
					var overlay = thumbnail.add(new El("a.overlay"));
					overlay.href = "watch/" + $["vid-id"];
	
				var description = card.add(new El("div.description"));
	
					var title = description.add(new El("a"));
					title.href = "watch/" + $["vid-id"];
	
						var title_inner = title.add(new El("h4"));
						title_inner.innerHTML = $.title;
	
					var div = description.add(new El("div"));
	
						var views = div.add(new El("div.view"));
						views.innerHTML = $.views;
	
						var channel = div.add(new El("a.channel"));
						channel.href = "channel/" + $.channel;
						channel.innerHTML = $["channel-name"];
	
		}
	
		else if (type == "plus") {
	
			var card = new El("div.card.plus");
	
				var a = card.add(new El("a"));
				a.href = "watch/" + $["vid-id"];
	
					var thumbnail = a.add(new El("div.thumbnail"));
					thumbnail.style.backgroundImage = "url(" + $.thumbnail + ")";
	
					var p = a.add(new El("p"));
	
						var channel_name = p.add(new El("b"));
						channel_name.innerHTML = $["channel-name"];
	
						p.innerHTML += " a aimé votre vidéo \"<b>" + $["vid-name"] + "</b>\"";
	
				var i = card.add(new El("i"));
				i.innerHTML = $["relative-time"];
	
		}
	
		else if (type == "comment") {
	
			var card = new El("div.card.comment");
	
				var a = card.add(new El("a"));
				a.href = "watch/" + $["vid-id"];
	
					var p = a.add(new El("p"));
	
						var channel_name = p.add(new El("b"));
						channel_name.innerHTML = $["channel-name"];
	
						p.innerHTML += " a commenté votre vidéo \"<b>" + $["vid-name"] + "</b>\"";
	
					var blockquote = a.add(new El("blockquote"));
					blockquote.innerHTML = $.comment
	
				var i = card.add(new El("i"));
				i.innerHTML = $["relative-time"];
	
		}
	
		else if (type == "channel") {
	
			var card = new El("div.card.channel");
	
				var a = card.add(new El("a"));
				a.href = "watch/" + $.channel;
	
					var avatar = a.add(new El("div.avatar"));
					avatar.style.backgroundImage = "url(" + $.avatar + ")";
	
					var p = a.add(new El("p"));
	
						var channel_name = p.add(new El("b"));
						channel_name.innerHTML = $["channel-name"];
		
						p.innerHTML += " s'est abonné à votre chaîne \"<b>" + $["my-channel-name"] + "</b>\"";
	
				var subscribers = card.add(new El("span.subscribers"));
				subscribers.innerHTML = "<b>" + $.subscribers + "</b> Abonnés";
	
				var i = card.add(new El("i"));
				i.innerHTML = $["relative-time"];
	
		}
	
		card.on( "CLICK", $.click, card);

		return card;
	
	}

});