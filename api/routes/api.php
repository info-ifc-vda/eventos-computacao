<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Organizers\EventController as OrganizersEventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Users\EventController as UsersEventController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * POST api/v1/auth/login - Não auth
 * POST api/v1/auth/refresh
 * GET api/v1/auth/logout
 *
 * POST api/v1/users - Não auth
 * GET api/v1/users
 * PUT api/v1/users/password
 * GET api/v1/users/{user_id}
 * PUT api/v1/users/{user_id}
 *
 * GET api/v1/events
 * POST api/v1/events - create_event
 * GET api/v1/events/{event_id} - create_event
 * PUT api/v1/events/{event_id} - organizer do evento
 * PATCH api/v1/events/{event_id}/cancel - user_id do evento e nenhum participante // TODO
 * POST api/v1/events/join // TODO
 *
 * GET api/v1/events/{event_id}/expenses - organizer do evento
 * POST api/v1/events/{event_id}/expenses - organizer do evento
 * GET api/v1/events/{event_id}/expenses/{event_expense_id} - organizer do evento
 * PUT api/v1/events/{event_id}/expenses/{event_expense_id} - organizer do evento // TODO
 *
 * GET api/v1/events/{event_id}/participants - organizer do evento
 * POST api/v1/events/{event_id}/participants - organizer do evento
 * POST api/v1/events/{event_id}/participants/arrival - organizer do evento // TODO
 *
 * GET api/v1/events/{event_id}/payments - user_id do evento // TODO
 * POST api/v1/events/{event_id}/payments - user_id do evento // TODO
 * POST api/v1/events/{event_id}/payments/dispatch - user_id do evento // TODO
 *
 * POST api/v1/events/{event_id}/conclude - user_id do evento e todos payments pagos // TODO
 *
 * GET api/v1/events/{event_id}/organizers - organizer do evento
 * POST api/v1/events/{event_id}/organizers - organizer do evento
 * DELETE api/v1/events/{event_id}/organizers - user_id do evento
 *
 */
// Rota para validar o token JWT
Route::middleware('auth:api')->get('/v1/auth/validate', function (Request $request) {
    return response()->json([
        'valid' => true,
        'user' => $request->user()
    ]);
});

Route::group(['prefix' => 'v1'], function() {
    Route::group(['prefix' => 'auth'], function() {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
        Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    });

    Route::post('users', [UserController::class, 'store']); // Rota que não necessita autenticação

    Route::group(['prefix' => 'users', 'middleware' => 'auth:api'], function() {
        Route::get('', [UserController::class, 'index']);
        Route::put('password', [UserController::class, 'updatePassword']);

        // Route::get('me', [UserController::class, 'showMe']);
        Route::group(['prefix' => '{user_id}'], function() {
            Route::get('', [UserController::class, 'show']);
            Route::put('', [UserController::class, 'update']);
        });
    });

    Route::group(['prefix' => 'events', 'middleware' => 'auth:api'], function() {
        Route::get('', [OrganizersEventController::class, 'index']);
        Route::post('', [OrganizersEventController::class, 'store']);
        Route::post('join', [UsersEventController::class, 'join']);

        Route::group(['prefix' => '{event_id}'], function() {
            Route::get('', [OrganizersEventController::class, 'show']);
            Route::put('', [OrganizersEventController::class, 'update']);
            Route::post('cancel', [OrganizersEventController::class, 'cancel']);

            //Rotas de despesas de eventos
            Route::group(['prefix' => 'expenses'], function() {
                Route::get('', [OrganizersEventController::class, 'indexExpenses']);
                Route::post('', [OrganizersEventController::class, 'storeExpense']);
                Route::get('{event_expense_id}', [OrganizersEventController::class, 'showExpense']);
            });

            Route::group(['prefix' => 'participants'], function() {
                Route::post('arrival', [OrganizersEventController::class, 'storeParticipantArrival']);

                Route::get('', [OrganizersEventController::class, 'indexParticipants']);
                Route::post('', [OrganizersEventController::class, 'storeParticipant']);

                Route::get('payments', [OrganizersEventController::class, 'indexParticipantsPayments']);
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
