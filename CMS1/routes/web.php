<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

use App\Mail\InformacionMailable;
use Illuminate\Support\Facades\Mail;

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

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});



Route::get('/',        [CartController::class, 'shop'])->name('shop');
Route::get('/cart',    [CartController::class, 'cart'])->name('cart.index');
Route::post('/add',    [CartController::class, 'add'])->name('cart.store');
Route::post('/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/clear',  [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cheackout', [CartController::class, 'cheackout'])->name('cart.cheackout');

//Categorias
Route::get('categorias',  [CategoriaController::class, 'index'])->middleware('can:admin.categorias')->name('categoria.index');
Route::post('categorias/save', [CategoriaController::class, 'save'])->middleware('can:admin.categorias')->name('categoria.save');
Route::get('categoria/editar/{id}', [CategoriaController::class, 'edit'])->name('categoria.editar');
Route::post('categoria/update', [CategoriaController::class, 'update'])->name('categoria.update');
Route::get('categoria/change_status/{id}', [CategoriaController::class, 'change_status'])->name('categoria.change_status');
Route::get('categoria/delete/{id}', [CategoriaController::class, 'delete'])->name('categoria.delete');


//Productos
Route::get('productos', 	  [ProductsController::class, 'index'])->middleware('can:products.index')->name('products.index');
Route::get('producto/create', [ProductsController::class, 'create'])->middleware('can:products.create')->name('products.create');
Route::post('producto/save',  [ProductsController::class, 'save'])->middleware('can:products.create')->name('products.save');
Route::get('producto/image/{filename}', [ProductsController::class, 'getImage'])->name('producto.image');
Route::get('producto/editar/{id}', [ProductsController::class, 'editar'])->name('producto.edit');
Route::post('producto/update', [ProductsController::class, 'update'])->name('producto.update');
Route::get('producto/detalle/{id}', [ProductsController::class, 'detalle'])->name('producto.detalle');
Route::get('producto/change_status/{id}', [ProductsController::class, 'change_status'])->name('producto.change_status');

//Pedido
Route::get('pedido/detalle/{id}', 	  [PedidoController::class, 'detalle'])->name('pedido.detalle');
Route::get('pedido/mis_pedidos',  	  [PedidoController::class, 'mis_pedidos'])->middleware('auth')->name('pedido.mis_pedidos');
Route::get('pedidos',             	  [PedidoController::class, 'pedidos'])->middleware('can:pedidos.index')->name('pedidos.index');
Route::post('pedido/update',      	  [PedidoController::class, 'update'])->middleware('can:pedidos.update')->name('pedido.update');
Route::get('pedidos/reporte/diario',  [PedidoController::class, 'reporte_diario'])->name('pedidos.reporte_diario');
Route::get('pedidos/reporte/mes',     [PedidoController::class, 'reporte_mes'])->name('pedidos.reporte_mes');
Route::get('pedidos/reporte/year',    [PedidoController::class, 'reporte_year'])->name('pedidos.reporte_year');
Route::get('pedidos/reportes',        [PedidoController::class, 'reporte_personalizado'])->name('pedidos.reporte_personalizado');
Route::post('reporte',                [PedidoController::class, 'reporte'])->name('reporte.find');

//Permiso
Route::resource('users', 'App\Http\Controllers\Admin\UserController')->middleware('can:admin.users')->names('admin.users');

// //Emails
// Route::get('informacion', function(){
// 	$correo = new InformacionMailable;

// 	Mail::to('sfrodriguez-es@udabol.edu.bo')->send($correo); 

// 	return "Mensaje enviado";
// });

//Listar productos por categoria
Route::get('producto/{id}',[CartController::class, 'shopbycategoria'])->name('producto.categoria');


