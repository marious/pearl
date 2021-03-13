<?php

Route::group(['namespace' => 'Botble\Counter\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'counters', 'as' => 'counter.'], function () {
            Route::resource('', 'CounterController')->parameters(['' => 'counter']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'CounterController@deletes',
                'permission' => 'counter.destroy',
            ]);
        });
    });

});
