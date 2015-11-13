function dlDropdown(links) {

	var overlay = document.createElement("div");
	overlay.className= "dl-dropdown-overlay";
	document.body.appendChild(overlay);

	var dropdown = document.createElement("div");
	dropdown.className = "dl-dropdown";

	var closeDlDropdown = function() {

		dropdown.parentNode.removeChild(dropdown);
		overlay.parentNode.removeChild(overlay);

	}

	overlay.onclick = closeDlDropdown;

	for (var q in links) {

		var link = document.createElement("a");
		link.innerHTML = q;
		link.href = links[q];
		link.target = "_blank";

		link.onclick = closeDlDropdown;

		dropdown.appendChild(link);

	}

	document.body.appendChild(dropdown);

}