<?php

Route::get('/', 'IndexController@index');
Route::post('/', 'IndexController@postUrl');
Route::get('/{url}', 'IndexController@redirectByShortLink')->where('url', '[[:alnum:]]+');
