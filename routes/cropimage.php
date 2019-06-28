<?php

Route::group(['prefix' => 'cropimage'], function () {
    Route::get('/', 'Manuel90\CropImageField\Http\CropImageFieldController@hello');
    
    Route::post('/crop_upload_image','Manuel90\CropImageField\Http\CropImageFieldController@uploadImage')->name('crop.image.upload');

    Route::get('/site-settings','Manuel90\CropImageField\Http\CropImageFieldController@hello')->name('cropimage.site.settings');
});
