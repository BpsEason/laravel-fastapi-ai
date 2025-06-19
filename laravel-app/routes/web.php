<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CommentController::class, 'showForm']);
Route::post('/analyze', [CommentController::class, 'analyzeComment']);