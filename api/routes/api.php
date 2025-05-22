<?php

use App\Http\Controllers\Organizers\EventController as OrganizersEventController;
use App\Http\Controllers\Users\EventController as UsersEventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], function() {

    Route::group(['prefix' => 'events'], function() {
        Route::get('', [OrganizersEventController::class, 'index']);
        Route::post('', [OrganizersEventController::class, 'store']);

        Route::post('join', [UsersEventController::class, 'join']);

        Route::group(['prefix' => '{event_id}'], function() {
            Route::get('', [OrganizersEventController::class, 'show']);
            Route::put('', [OrganizersEventController::class, 'update']);
            Route::post('cancel', [OrganizersEventController::class, 'cancel']);

            Route::group(['prefix' => 'participants'], function() {
                Route::post('arrival', [OrganizersEventController::class, 'storeParticipantArrival']);

                Route::get('', [OrganizersEventController::class, 'indexParticipants']);
                Route::post('', [OrganizersEventController::class, 'storeParticipant']);
            });

            Route::group(['prefix' => 'organizers'], function() {
                Route::get('', [OrganizersEventController::class, 'indexOrganizers']);
                Route::post('', [OrganizersEventController::class, 'storeOrganizer']);
                Route::group(['prefix' => '{organizer_id}'], function() {
                    Route::delete('', [OrganizersEventController::class, 'deleteOrganizer']);
                });
            });
        });
    });
});