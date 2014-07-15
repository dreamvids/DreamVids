# DreamVids

> New, Free, Open Source and French Videos sharing platform.

![DreamVids](img/blue_logo.png "DreamVids")

[dreamvids.fr](http://dreamvids.fr/)
Twitter : [@DreamVids_](https://twitter.com/DreamVids_)
FaceBook : [/dreamvids](https://www.facebook.com/dreamvids)

###For NginX Config :

delete the .htaccess & place this code in your nginx config

<pre>
# nginx configuration

location = /home {
  rewrite ^(.*)$ /index.php?page=home break;
}

location = /signin {
  rewrite ^(.*)$ /index.php?page=reg break;
}

location = /login {
  rewrite ^(.*)$ /index.php?page=log break;
}

location = /logout {
  rewrite ^(.*)$ /index.php?page=log&out break;
}

location = /profile {
  rewrite ^(.*)$ /index.php?page=profile;
}
</pre>
