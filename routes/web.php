<?php
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index']);