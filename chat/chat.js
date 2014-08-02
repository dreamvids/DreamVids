function send(pseudo){
	$("input[type='text']").prop("disabled", true);
	$("input[type='text']").attr("placeholder", "Envoie en cours...");
	var msg = $("input[type='text']").val();
	$("input[type='text']").val('');
	$.ajax({
		type: "POST",
		url: "post.php",
		data: {
			message: msg
		}
	}).done(function(html){
		$('#chat').append(html);
		$("input[type='text']").attr("placeholder", "Entrez votre message");
		$("input[type='text']").prop("disabled", false);
		$("input[type='text']").focus();
		$("input[type='text']").select();
		var elem = document.getElementById("chat");
		elem.scrollTop = elem.scrollHeight;
	});
	
}

function getMsg(){
	$.ajax({
		type: "POST",
		url: "post.php",
		data: {
			getMsg: ''
		}
	}).done(function(html){
		$('#chat').append(html);
		var elem = document.getElementById("chat");
		elem.scrollTop = elem.scrollHeight

		$(".message").each(function(i){
			$(".pseudo").eq(i).mouseenter(function(){
				$(".admin").eq(i).show();
			});
			$(".pseudo").mouseenter(function(){
				var index = $(".pseudo").index(this);
				// alert(index);
				if(index != i){
					$(".admin").eq(i).hide();
				}
			});
			$(".admin").eq(i).mouseleave(function(){
				$(".admin").eq(i).hide();
			});
		});
	});
}

function ban(user_id, user_name, ip, type){
	$.ajax({
		type: "POST",
		url: "post.php",
		data: {
			user_id: user_id,
			user_name: user_name,
			ip: ip,
			type: type
		}
	}).done(function(html){
		$('#chat').append(html);
	});
}

$(document).ready(function(){
	$("input[type='text']").focus();
	$("input[type='text']").select();

	getMsg();
	setInterval(getMsg, 5000);
});