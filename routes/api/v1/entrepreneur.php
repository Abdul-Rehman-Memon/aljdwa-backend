<?php

use App\Http\Controllers\Api\V1\Entrepreneur\IdeaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:entrepreneur'])->prefix('entrepreneur')->group(function () {
    Route::get('/ideas', [IdeaController::class, 'index']); // List all ideas
    Route::post('/ideas', [IdeaController::class, 'store']); // Add new idea
    // Additional entrepreneur routes...
});
