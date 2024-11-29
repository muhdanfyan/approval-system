<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\ApproverController;
use App\Http\Controllers\ApprovalStageController;
use App\Http\Controllers\ExpenseController;

Route::post('/approvers', [ApproverController::class, 'store']);
Route::post('/approval-stages', [ApprovalStageController::class, 'store']);
Route::put('/approval-stages/{id}', [ApprovalStageController::class, 'update']);
Route::post('/expenses', [ExpenseController::class, 'store']);
Route::patch('/expenses/{id}/approve', [ExpenseController::class, 'approve']);
Route::get('/expenses/{id}', [ExpenseController::class, 'show']);
