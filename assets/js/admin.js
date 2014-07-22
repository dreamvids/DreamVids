function unFlag(vidId) {
	marmottajax.put({
		url: '../videos/' + vidId,
		options: { flag: false }
	}).then(function(result) {
		window.location.reload();
	});
}

function suspend(vidId) {
	marmottajax.put({
		url: '../videos/' + vidId,
		options: { suspend: true }
	}).then(function(result) {
		window.location.reload();
	});
}

function unSuspend(vidId) {
	marmottajax.put({
		url: '../videos/' + vidId,
		options: { suspend: false }
	}).then(function(result) {
		window.location.reload();
	});
}

function erase(vidId) {
	marmottajax.delete({
		url: '../videos/' + vidId,
		options: {}
	}).then(function(result) {
		window.location.reload();
	});
}