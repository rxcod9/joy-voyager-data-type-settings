<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Voyager API Routes
|--------------------------------------------------------------------------
|
| This file is where you may override any of the routes that are included
| with VoyagerDataTypeSettings.
|
*/

Route::group(['as' => 'joy-voyager-data-type-settings.'], function () {
    // event(new Routing()); @deprecated

    $namespacePrefix = '\\' . config('joy-voyager-data-type-settings.controllers.namespace') . '\\';

    // event(new RoutingAfter()); @deprecated
});
