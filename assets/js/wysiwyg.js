function wysiwyg(editor) {
    var buttons_container = document.getElementById('wysiwyg');

    buttons_container.style.textAlign = 'center';
    buttons_container.style.marginTop = '5px';

    var buttons = buttons_container.querySelectorAll('span[data-tag], img[data-tag]');

    for (var i = 0, l = buttons.length; i < l; i++) {
        buttons[i].addEventListener('mousedown', function(event) {
            var tag = this.getAttribute('data-tag');
            switch (tag) {
                case 'createLink':
                    var link = prompt("Adresse du lien :");
                    if (link)
                        document.execCommand('createLink', true, link);
                    else {
                        document.getElementById('editor').focus();
                        document.execCommand('unLink', true, link);
                    }
                    break;

                case 'color':
                    var color = prompt("Couleur :");
                    if (color)
                        document.execCommand('foreColor', true, color);
                    break;

                case 'smiley':
                    document.getElementById('editor').focus();
                    document.execCommand("insertImage", false, 'img/smiley/' + this.getAttribute('data-value') + '');
                    fermer();
                    break;

                default:
                    document.getElementById('editor').focus();
                    document.execCommand(tag, false, this.getAttribute('data-value'));
            }
            event.preventDefault();
        });
    }
}

function addImage() {
    var src = prompt("Adresse de l'image : ");
    if (src) {
        var img = new Image();
        img.src = src;
        img.onload = function() {
            var width = prompt('Largeur :', this.width);
            if (width) {
                var height = prompt('Largeur :', (width != this.width) ? Math.round(width / this.width * this.height) : this.height);
                if (height) {
                    document.getElementById('editor').focus();
                    document.execCommand("insertImage", false, 'img.php?s=' + img.src + '&w=' + img.width + '&h=' + img.height + '');
                }
            }
        }
    }
}

window.onload = function() {
    wysiwyg(document.getElementById('editor'));
};

function ouvrir() {
    document.getElementById('modal').style.display = 'block';
    document.getElementById('modal').className = 'view';
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('overlay').className = 'view';
}

function fermer() {
    document.getElementById('modal').className = '';
    document.getElementById('overlay').className = '';
    setTimeout(function() {
        document.getElementById('modal').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }, 200);
}