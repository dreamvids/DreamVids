function plus(vid) {
    votePlus = document.getElementById('votePlus');
    voteMoins = document.getElementById('voteMoins');

    if (votePlus.className == 'active') {
        votePlus.className = '';
        votePlus.innerHTML = parseInt(votePlus.innerHTML) - 1;
        unlikeRequest(vid);
        
    } else {
        votePlus.className = 'active';
        votePlus.innerHTML = parseInt(votePlus.innerHTML) + 1;

        /*ajax.post({
            action: 'like',
            vid: vid
        });*/

        likeRequest(vid);

        if (voteMoins.className == 'active') {
            voteMoins.className = '';
            voteMoins.innerHTML = parseInt(voteMoins.innerHTML) - 1;
        }
    }
}

function moins(vid) {
    votePlus = document.getElementById('votePlus');
    voteMoins = document.getElementById('voteMoins');

    if (voteMoins.className == 'active') {
        voteMoins.className = '';
        voteMoins.innerHTML = parseInt(voteMoins.innerHTML) - 1;
        undislikeRequest(vid);

    } else {
        voteMoins.className = 'active';
        voteMoins.innerHTML = parseInt(voteMoins.innerHTML) + 1;
        
        /*ajax.post({
            action: 'dislike',
            vid: vid
        });*/
    
        dislikeRequest(vid);

        if (votePlus.className == 'active') {
            votePlus.className = '';
            votePlus.innerHTML = parseInt(votePlus.innerHTML) - 1;
        }
    }
}