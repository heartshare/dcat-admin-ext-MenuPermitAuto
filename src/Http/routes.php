<?php

use Dcat\Admin\MenuPermitAuto\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('menu-permit-auto', Controllers\MenuPermitAutoController::class.'@index');

Route::get('sync-menu-permit', Controllers\MenuPermitAutoController::class.'@syncMenuPeimit');
