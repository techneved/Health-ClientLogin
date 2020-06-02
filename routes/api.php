<?php


//Route::apiResource('instructor','InstructorController')->middleware('api');


    Route::prefix('client')->name('client.')->group(function() {

        Route::post('login','ClientLoginController@login')->name('login');
        Route::post('logout','ClientLoginController@logout')->name('logout');
    });
    Route::apiResource('client','ClientController')->middleware('api');