<?php

Route::group(['middleware' => 'auth', 'prefix' => 'adm'], function()
{
    Route::get('/rss/fetch/{link_name}', ['as' => 'rss_fetch',  'uses' => 'Interpro\RSS\Laravel\Http\RSSController@fetchRSS']);
});

