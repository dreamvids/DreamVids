<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="style/chat.css">
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	</head>
	<body onKeyPress="if (event.keyCode == 13) send()">
		<div id="chat">
			
		</div>
		<div id="send">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-8">
						<input type="text" placeholder="Entrez votre message">
					</div>
					<div class="col-xs-4">
						<input type="submit" onclick="send()" class="btn btn-sm btn-default" value="Envoyer">
					</div>
				</div>
			</div>
		</div>
		<!-- SCRIPT -->
			<script src="chat.js"></script>			
		<!-- END SCRIPT -->
	</body>
</html>