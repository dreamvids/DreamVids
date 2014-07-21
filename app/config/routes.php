<?php

Route::register('default', 'home');

Route::register('home', 'home');
Route::register('discover', 'discover');

Route::register('login', 'login');
Route::register('register', 'register');
Route::register('account', 'account');

Route::register('channel', 'channel');
Route::register('watch', 'video');
Route::register('feed', 'feed');

Route::register('videos', 'video');
Route::register('channels', 'channel');
Route::register('posts', 'channel_post');
Route::register('comments', 'comment');

Route::register('admin', 'admin');