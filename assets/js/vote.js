function plus(vid) {
    votePlus = document.getElementById('votePlus');
    voteMoins = document.getElementById('voteMoins');

    if (votePlus.className == 'active') {
        votePlus.className = '';
        votePlus.innerHTML = parseInt(votePlus.innerHTML) - 1;

        ajax.get('unlike/' + vid, {});
    } else {
        votePlus.className = 'active';
        votePlus.innerHTML = parseInt(votePlus.innerHTML) + 1;

        ajax.get('like/' + vid, {});

        if (voteMoins.className == 'active') {
            voteMoins.className = '';
            voteMoins.innerHTML = parseInt(voteMoins.innerHTML) - 1;
            ajax.get('undislike/' + vid, {});
        }
    }
}

function moins(vid) {
    votePlus = document.getElementById('votePlus');
    voteMoins = document.getElementById('voteMoins');

    if (voteMoins.className == 'active') {
        voteMoins.className = '';
        voteMoins.innerHTML = parseInt(voteMoins.innerHTML) - 1;

        ajax.get('undislike/' + vid, {});
    } else {
        voteMoins.className = 'active';
        voteMoins.innerHTML = parseInt(voteMoins.innerHTML) + 1;

        ajax.get('dislike/' + vid, {});

        if (votePlus.className == 'active') {
            votePlus.className = '';
            votePlus.innerHTML = parseInt(votePlus.innerHTML) - 1;
            
             ajax.get('unlike/' + vid, {});
        }
    }
}