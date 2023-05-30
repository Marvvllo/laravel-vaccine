<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\VaccinationController;
use App\Models\Vaccinations;
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

// Auth group
Route::prefix('v1/auth')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
});

// Consultation group
Route::prefix('v1')->controller(ConsultationController::class)->group(function () {
    Route::get('consultations', 'index');
    Route::post('consultations', 'store');
});

// Vaccination spots group
Route::prefix('v1')->controller(SpotController::class)->group(function () {
    Route::get('/spots', 'index');
    Route::get('/spots/{spot_id}', 'show');
});

// Vaccinations group
Route::prefix('v1')->controller(VaccinationController::class)->group(function () {
    Route::post('/vaccinations', 'store');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
