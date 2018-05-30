<?php

Route::group(['middleware' => ['web'], 'namespace' => 'Modules\Core\Http\Controllers'], function () {
    Route::get('{vue_capture?}', 'CoreAdminController@index')
        ->where('vue_capture', '[\/\w\.-]*')
        ->where('vue_capture', '^(?!(api|oauth)).*$');
});
