# DreamVids - Assets

Le développement du style et des scripts nécessite des dépendances, pour les installer, veuillez suivre la démarche :

###NodeJs

Si NodeJs n'est pas déjà installé sur votre ordinateur sous Windows et Mac : [nodejs.org](http://nodejs.org/)

Pour GNU/Linux on installe NodeJs comme ceci : 

```shell
apt-get install nodejs
```

###Grunt et ses plugins

Pour installer Grunt et ses plugins, il faut lancer ces commande à la racine du projet :

```shell
npm install -g grunt
```

```shell
npm install -g browser-sync
```

```shell
npm install
```

##Lancer les processus de compilations lors du développement

Vous pourrez désormais développer le style et les scripts du projet.

Pour lancer les processus de compilation du scss et du js, il suffit de lancer cette commande dans la racine du projet :

```shell
grunt
```

Pour éviter de devoir lancer la compilation à chaque modification, on utilise cette commande :

```shell
grunt dev
```

La commande `grunt dev` va également lancer un serveur proxy Browser Sync, vous pouvez définir votre adresse de développement local dans le fichier `dev.json`.