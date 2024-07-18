<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AddressController;

Route::get('/search/local/{ceps}', [AddressController::class, 'search']);


