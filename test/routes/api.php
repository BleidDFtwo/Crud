<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crud;
use App\Http\Controllers\CrudVentas;

//Tabla Usuario
Route::get('/getDataTable', [Crud::class, 'getDataTable']);
Route::put('/updateElement', [Crud::class, 'updateElement']);
Route::delete('/deleteElement/{id}', [Crud::class, 'deleteElement']);

// Rutas para la tabla Ventas
Route::get('/ventas/getDataTable', [CrudVentas::class, 'getDataTable']);
Route::put('/ventas/updateElement', [CrudVentas::class, 'updateElement']);
Route::delete('/ventas/deleteElement/{id}', [CrudVentas::class, 'deleteElement']);
