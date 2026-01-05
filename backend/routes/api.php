<?php

declare(strict_types=1);

use App\Http\Controllers\RepositoryController;
use Illuminate\Support\Facades\Route;

Route::get('/repositories', [RepositoryController::class, 'index']);
Route::get('/repositories/{owner}/{repo}', [RepositoryController::class, 'show']);
