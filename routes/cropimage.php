<?php

Route::middleware(['web'])->group(function () {
    Route::group(['prefix' => 'cropimage'], function () {
        Route::post('/crop_upload_image','\Manuel90\CropImageField\Http\CropImageFieldController@uploadImage')->name('crop.image.upload');
        Route::post('/crop_image','\Manuel90\CropImageField\Http\CropImageFieldController@cropImage')->name('crop.image');
    });
});
