<?php
if(config("laradzmanager.force_auth")){

  Route::group(['middleware' => ['web', 'auth']], function(){

    Route::get('/dzmanager', 'Codiiv\Laradzmanager\LaradzmanagerController@loadMediaManager')->name('laradzmanager');

    //DROPZONE ROUTES
    Route::get('/dzmanager/dropzone', 'Codiiv\Laradzmanager\LaradzmanagerController@dropzone');
    Route::post('/dzmanager/dropzone/store', ['as'=>'dropzone.store','uses'=>'Codiiv\Laradzmanager\LaradzmanagerController@dropzoneStore']);

  });
}else{
    Route::get('/dzmanager', 'Codiiv\Laradzmanager\LaradzmanagerController@loadMediaManager')->name('laradzmanager');

    //DROPZONE ROUTES
    Route::get('/dzmanager/dropzone', 'Codiiv\Laradzmanager\LaradzmanagerController@dropzone');
    Route::post('/dzmanager/dropzone/store', ['as'=>'dropzone.store','uses'=>'Codiiv\Laradzmanager\LaradzmanagerController@dropzoneStore']);
}
