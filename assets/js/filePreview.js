var filePreview = function(element) {
    this.element = element;
    this.input = document.getElementById(this.element.getAttribute('data-input'));

    this.input.addEventListener('change', function(event) {
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(event) {
                this.cible.className = this.cible.className.replace(" none", "");
                this.cible.src = event.target.result;
            }

            reader.cible = document.getElementById(this.getAttribute('data-preview'));
            reader.readAsDataURL(this.files[0]);
        }
    }, false);
}

var elements = document.getElementsByClassName('filePreview');
if (elements && elements.length) {
    for (var i = 0, length = elements.length; i < length; i++) {
        filePreview(elements[i]);
    }
}