<?php

Route::group(['namespace' => 'Botble\News\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'news', 'as' => 'news.'], function () {
            Route::resource('', 'NewsController')->parameters(['' => 'news']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'NewsController@deletes',
                'permission' => 'news.destroy',
            ]);
        });
    });

});
