<?php
//Theme::routes();
Route::group(['namespace' => '\Theme\Pearl\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {

//        Route::get('/', 'ThemePearlController@getIndex')
//            ->name('public.index');


        Route::get('doctors/{slug}', 'ThemePearlController@getDoctor')->name('public.doctor');
        Route::get('departments','ThemePearlController@getDepartments')->name('public.departments');
        Route::get('departments/{slug}', 'ThemePearlController@getDepartment')->name('public.department');

//        Theme::routes();

        Route::get('{slug?}' . config('core.base.general.public_single_ending_url'), 'ThemePearlController@getView')
            ->name('public.single');
    });


});
