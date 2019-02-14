<?php

Route::get('/', 'CaseViewController@index');
Route::get('/valentines1', 'MyValentineController@qrCode');
Route::get('/for_the_most_amazing_woman_in_the_world', 'MyValentineController@timedEvents');
