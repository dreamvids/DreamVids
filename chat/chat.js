function send(pseudo){
	$("input[type='text']").prop("disabled", true);
	var msg = $("input[type='text']").val();
	$.ajax({
		type: "POST",
		url: "post.php",
		data: {
			message: msg
		}
	}).then(function(html){
		$('#chat').append(html);
		$("input[type='text']").val('');
		$("input[type='text']").prop("disabled", false);
		$("input[type='text']").focus();
		$("input[type='text']").select();
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
	});
}

$(document).ready(function(){
	$("input[type='text']").focus();
	$("input[type='text']").select();
	getMsg();
	setInterval(getMsg, 10000);
});