<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\SocialHubCategoryComponent;
use App\Http\Livewire\CategoryComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('social-hub-category', SocialHubCategoryComponent::class)->name('social-hub-category');

    Route::get('category', CategoryComponent::class)->name('category');

    // Route::get('/social-hub-category', function () {
    //     return view('default');
    // })->name('social-hub-category');
});
