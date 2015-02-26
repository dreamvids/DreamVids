# DreamVids - Assets

Le développement du style et des scripts nécessite des dépendances, pour les installer, veuillez suivre la démarche :

###NodeJs

Si NodeJs n'est pas déjà installé sur votre ordinateur sous Windows et Mac : [nodejs.org](http://nodejs.org/)

Pour GNU/Linux on installe NodeJs comme ceci : 

```shell
apt-get install nodejs
```

###Gulp et ses modules

Pour installer Gulp et ses modules, il suffit de lancer ces deux commandes à la racine du projet :

```shell
npm i -g gulp
```

```shell
npm install
```

##Lancer les processus de compilations lors du développement

Vous pourrez désormais développer le style et les scripts du projet.

Pour lancer les processus de compilation du scss et du js, vous devez lancer cette commande dans la racine du projet :

```shell
gulp
```

Cela va également lancer un serveur proxy Browser Sync, vous pouvez définir votre adresse de développement local dans le fichier `dev.json`.