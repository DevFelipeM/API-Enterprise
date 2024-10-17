<?php

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\FuncionarioController;
use Illuminate\Support\Facades\Route;


Route::apiResource('funcionario', FuncionarioController::class);
// Route::get('funcionario/search', [FuncionarioController::class, 'search']);

Route::apiResource('empresas', EmpresaController::class);
// Route::post('eempresas', [EmpresaController::class, "store"] );