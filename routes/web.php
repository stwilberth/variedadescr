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

Route::get('/', 'Welcome@vista');

Auth::routes();

Route::resource('users', 'UserController')->middleware('adminrole');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/contactenos', 'Paginas@contactar');
Route::get('/envio', 'Paginas@envio');
Route::get('/garantia', 'Paginas@garantia');
Route::resource('marcas', 'MarcaController')->middleware('adminrole');

//catalogo
Route::get('/catalogo/{categoria}', 'Productos@index')->name('catalogoIndex');
Route::get('/catalogo/{categoria}/{slug}', 'Productos@show')->name('productoShow');

Route::get('/inventario', 'Productos@inventario')->name('productoInventario')->middleware('adminrole');
Route::get('/inventarito/{disponibilidad}', 'Productos@inventarito')->name('productoInventarito')->middleware('adminrole');
Route::post('/inventario-update/{slug}', 'Productos@updateInventario')->name('updateInventario')->middleware('adminrole');

Route::get('/producto-edit/{slug}', 'Productos@edit')->name('productoEdit')->middleware('adminrole');
Route::get('/producto-create', 'Productos@create')->name('productoCreate')->middleware('adminrole');
Route::post('/producto-update/{slug}', 'Productos@update')->name('productoUpdate')->middleware('adminrole');
Route::post('/producto-store', 'Productos@store')->name('productoStore')->middleware('adminrole');
//Route::post('/producto-delete', 'Productos@delete')->name('productoDelete');

//edicion de imagenes
Route::get('/image-edit/{tour}', 'ImageCtr@edit')->name('imageEdit')->middleware('adminrole');
Route::post('/image-save', 'ImageCtr@save')->name('imageSave')->middleware('adminrole');
Route::post('/image-update', 'ImageCtr@update')->name('imageUpdate')->middleware('adminrole');
Route::post('/image-delete', 'ImageCtr@delete')->name('imageDelete')->middleware('adminrole');

 //Clear route cache:
//  Route::get('/route-cache', function() {
//     $exitCode = Artisan::call('route:cache');
//     return 'Routes cache cleared';
// });

// //Clear config cache:
// Route::get('/config-cache', function() {
//     $exitCode = Artisan::call('config:cache');
//     return 'Config cache cleared';
// });

//Clear config cache:
// //Clear config cache:
// Route::get('/config-cache', function() {
//     $exitCode = Artisan::call('config:cache');
//     return 'Config cache cleared';
// });

// // Clear application cache:
// Route::get('/clear-cache', function() {
//     $exitCode = Artisan::call('cache:clear');
//     return 'Application cache cleared';
// });

// // key:
// Route::get('/key-generate', function() {
//     $exitCode = Artisan::call('key:generate');
//     return $exitCode;
// });