function toggleContainer(name) {
	var e = document.getElementById(name);// MooTools might not be available
											// ;)
	e.style.display = (e.style.display == 'none') ? 'block' : 'none';
}