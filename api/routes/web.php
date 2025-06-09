<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('storage/{file}', function (Request $request) {

    if (! file_exists(storage_path('app/'.$request->route('file')))) {
        abort(404);
    }
    return response()->file(storage_path('app/'.$request->route('file')));
});
