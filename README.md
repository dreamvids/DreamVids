![DreamVids](/assets/img/blue_logo.png "DreamVids - 2.0")
========

Core rework & new design for the DreamVids video sharing platform
This project is using [SysDream2](https://github.com/Quadrifoglio/SysDream-2) as a base.


Dependencies
========

###Back
This project is using php-activerecord as an ORM library for accessing the database.
To install all required dependencies, just install composer and type "composer install" in a command prompt.

###Front
Le développement front-end necessite des [dépendances à installer](https://github.com/DreamVids/DreamVids/blob/dreamvids-2.0/assets/README.md).

Authors
========
Back-end development: Peter Cauty, Quadrifoglio

Design: DarkWos, LowiSky

Front-end development: Dimou, LowiSky

To Do
========

##Back

Upload :

- [ ] Système d'upload + convertion sur le front puis déplacement (scp) sur le store

- [ ] Réintégrer le système de lecture de la V1

- [ ] Durée de la vidéo: [www.posteet.com/view/2052](http://www.posteet.com/view/2052) (ffmpeg -i {filepath} 2>&1)

- [ ] Utiliser la base 64 en base pour images au lieu de les stocker

- [ ] Ne pas ajouter de notif d'upload si vidéo non publique: l'ajouter lors de la mise en publique: Vérifier si une notif a déjà été publiée: NON: onajoute la notif; OUI: on se contente de passer la vidéo en public sans aucune autre action.

Autres :

- [ ] Boutons de partage/téléchargement/intégration non codés

- [ ] Ajouter les playlists

- [ ] Mot de passe oublié

- [ ] Pouvoir répondre aux commentaires

- [ ] Faire les "settings"

- [ ] Impossible de quitter un conversation privée

- [ ] Footer

##Admin

- [ ] Instaurer une licence pour les vidéos

- [ ] Page "qui sommes-nous", "Contributeurs", "Equipe"

##Front

- [ ] Interface pour le live

- [ ] Debug firefox des boutons partage et intégration **Wtf is this shit** Si je pouvais avoir plus d'infos ce serait cool, car chez moi tout fonctionne :s
