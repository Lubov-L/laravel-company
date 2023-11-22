<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'user' => UserController::class,
]);

Route::apiResources([
    'company' => CompanyController::class,
]);

Route::get('/company/comments/{company_id}', [CompanyController::class, 'getCommentsByCompanyId']);
Route::get('/company/rating/{company_id}', [CompanyController::class, 'getCompanyRating']);
Route::get('/companies/top', [CompanyController::class, 'getTop']);

Route::apiResources([
    'comment' => CommentController::class,
]);
