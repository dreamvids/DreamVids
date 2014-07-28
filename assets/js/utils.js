function hasClass(element, theClass) {
<<<<<<< HEAD
    return (' ' + element.className + ' ').indexOf(' ' + theClass + ' ') > -1;
=======
	return (' ' + element.className + ' ').indexOf(' ' + theClass + ' ') > -1;
}

function removeAllChilds(element) {
	while(element.firstChild) {
		element.removeChild(element.firstChild);
	}
>>>>>>> dreamvids-2.0-dev
}