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

###Back

- Algo "Meilleures vidéos" sur l'accueil (Sondage en cours: [strawpoll.me/2218320/r](http://strawpoll.me/2218320/r))

- Algo "Découvrir" (Sondage en cours: [strawpoll.me/2218416/r](http://strawpoll.me/2218416/r))

- Upload

- Boutons de partage/dl/intégration non codés (Partage/intégration: need du front end. Téléchargement: terminé.)

- Arrêter une date pour la bêta fermée (~15 aout)

- La vidéo qui se lit est statique (Vu avec brezh: on garde le système de la V1)

- Clarifier DRASTIQUEMENT l'approche chaine, bcp trop confus actuellement: FAUTE A PETER !

- L'inscription en deux étapes: user puis chaine serait un plus non négligeable

- Les messages n'ont pas l'air de fonctionner

- Pouvoir supprimer une chaine

- Utiliser la base 64 pour images au lieu de les stocker

- L'avatar ne s'affiche pas sur les chaines

- Faire la recherche

- Ajouter les playlists

- Notifications (Colonne "read" dans users_actions, ya juste à comtper le nombre d'unread et à l'afficher par dessus l'item flux du menu, et afficher d'un autre style/couleur des actions unread dans le flux)

- LiveStream

- Mot de passe oublié

- Footer

- Trouver un moyen d'avoir la durée de la vidéo !!!!!!!!

- Les messages sociaux ne se postent plus...

###Admin

- Instaurer une licence pour les vidéos

- Page "qui sommes-nous", "Contributeurs", "Equipe"

###Front

- Faire un player à intégrer "maison" (pour ne plus être dépendants de Stornitz)

- Système de code d'éxportation

- Video card pour les réseaux au lieu d'images

- Interface pour le live