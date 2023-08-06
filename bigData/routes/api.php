<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MongoDBController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('bigData')->group(function () {
    Route::get("/testConnectMongodb", [MongoDBController::class, 'getValues']);
    Route::post("/testInsertToMongodb", [MongoDBController::class, 'insertValue']);
    Route::post("/syncDataInToDataTrain", [MongoDBController::class, 'syncDataInToDataTrain']);
});
