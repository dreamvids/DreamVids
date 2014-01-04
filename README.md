DreamVids
=========

![Alt text](img/logo_white_540p.png "logo_main")

New, Free, Open Source and French Videos sharing platform.


For NginX Config :

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
