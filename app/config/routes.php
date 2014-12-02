<?php

Route::register('default', 'home');

Route::register('home', 'home');
Route::register('news', 'news');
Route::register('search', 'search');

Route::register('login', 'login');
Route::register('register', 'register');
Route::register('account', 'account');

Route::register('channel', 'channel');
Route::register('watch', 'video');
Route::register('feed', 'feed');
Route::register('embed', 'embed');

Route::register('videos', 'video');
Route::register('playlists', 'playlist');
Route::register('channels', 'channel');
Route::register('posts', 'channel_post');
Route::register('comments', 'comment');
Route::register('messages', 'message');
Route::register('conversations', 'conversation');
Route::register('lives', 'live');
Route::register('password', 'password');
Route::register('pages', 'page');
Route::register('upload', 'upload');

Route::register('translation', 'translation');

Route::register('admin', 'admin');

/* BETA UNIQUEMENT. A RETIRER AVANT LA PRODUCTION FINALE */
Route::register('bugs', 'bug');
Route::register('beta', 'beta');
/* BETA UNIQUEMENT. A RETIRER AVANT LA PRODUCTION FINALE */