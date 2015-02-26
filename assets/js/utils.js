function hasClass(element, theClass) {
	return (' ' + element.className + ' ').indexOf(' ' + theClass + ' ') > -1;
}

function removeAllChilds(element) {
	while(element.firstChild) {
		element.removeChild(element.firstChild);
	}
}