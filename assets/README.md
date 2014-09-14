# DreamVids - Assets

Le développement du style et des scripts nécessite des dépendances, pour les installer, veuillez suivre la démarche :

###NodeJs

Si NodeJs n'est pas déjà installé sur votre ordinateur sous Windows et Mac : [nodejs.org](http://nodejs.org/)

Pour GNU/Linux on installe NodeJs comme ceci : 

```shell
apt-get install nodejs
```
###Ruby

Si Ruby n'est pas installé sur votre ordinateur sous Windows : [rubyinstaller.org](http://rubyinstaller.org/) Attention ! Il faut absolument cocher la case "Add Ruby executables to your PATH".

Si Ruby n'est pas installé sur GNU/Linux : 

```shell
apt-get install ruby
```
*Ruby est normalement déjà installé sur Mac.*

###Sass

Il faut maintenant installer Sass, pour cela, ouvrez l'invite de commande dans votre dossier et lancez cette commande :

```shell
gem install sass
```

###Grunt et ses plugins

Pour installer Grunt et ses plugins, il faut lancer cette commande dans la racine du projet :

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
grunt auto
```
