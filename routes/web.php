<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::resource('users', 'UserController')->middleware('adminrole');
Route::get('/', 'Welcome@vista')->name('welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/contactenos', 'Paginas@contactar');
Route::get('/envio', 'Paginas@envio');
Route::get('/garantia', 'Paginas@garantia');

//marcas
Route::resource('marcas', 'MarcaController')->middleware('adminrole');

//catalogo y productos
Route::get('/catalogo/{categoria}', 'Productos@index')->name('catalogoIndex');
Route::get('/catalogo/{categoria}/{slug}', 'Productos@show')->name('productoShow');
Route::get('/producto-edit/{slug}', 'Productos@edit')->name('productoEdit')->middleware('adminrole');
Route::get('/producto-create', 'Productos@create')->name('productoCreate')->middleware('adminrole');
Route::post('/producto-update/{slug}', 'Productos@update')->name('productoUpdate')->middleware('adminrole');
Route::post('/producto-store', 'Productos@store')->name('productoStore')->middleware('adminrole');
Route::get('/inventario', 'Productos@inventario')->name('productoInventario')->middleware('adminrole');
Route::get('/sin-publicar', 'Productos@sinPublicar')->name('productoSinPublicar')->middleware('adminrole');
Route::post('/producto-publicar/{slug}', 'Productos@publicar')->name('productoPublicar')->middleware('adminrole');
Route::post('/producto-notificar/{slug}', 'Productos@notificar')->name('productoNotificar')->middleware('adminrole');
//Route::post('/producto-delete', 'Productos@delete')->name('productoDelete');

//edicion de imagenes
Route::get('/image-edit/{slug}', 'ImageCtr@edit')->name('imageEdit')->middleware('adminrole');
Route::post('/image-save', 'ImageCtr@save')->name('imageSave')->middleware('adminrole');
Route::post('/image-update', 'ImageCtr@update')->name('imageUpdate')->middleware('adminrole');
Route::post('/image-delete', 'ImageCtr@delete')->name('imageDelete')->middleware('adminrole');

// --------- Rutas de suscripción
//index
Route::get('/suscripciones', 'SubscriptionController@index')->name('subscriptionsIndex')->middleware('adminrole');
//create
Route::get('/suscripciones/create', 'SubscriptionController@create')->name('subscriptionsCreate');
//store
Route::post('/suscripciones', 'SubscriptionController@store')->name('subscriptionsStore');
//edit
Route::get('/suscripciones/{id}/edit', 'SubscriptionController@edit')->name('subscriptionsEdit');
//update
Route::put('/suscripciones/{id}', 'SubscriptionController@update')->name('subscriptionsUpdate');
//delete
Route::get('/suscripciones/delete/{id}', 'SubscriptionController@delete')->name('subscriptionsDelete');
//destroy
Route::delete('/suscripciones/{id}', 'SubscriptionController@destroy')->name('subscriptionsDestroy');

Route::get('/subscription/confirm/{token}', 'SubscriptionController@confirm')->name('subscription.confirm');

// Clear config cache:
Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    return redirect()->back()->with('success', 'Cache limpiado correctamente');
})->name('clearCache')->middleware('adminrole');

/* 

// key:
Route::get('/key-generate', function() {
    $exitCode = Artisan::call('key:generate');
    return $exitCode;
});

//symbolic link
Route::get('/symlink', function() {
    $exitCode = Artisan::call('storage:link');
    return $exitCode;
}); 

*/
