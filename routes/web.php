<?php

use App\Filament\Pages\CustomPropertyPage;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/personal');
});

Route::get('/custom-property-page', CustomPropertyPage::class)->name('custom.property.page');
Route::view('/legal', 'pages.legal-notice-public')->name('legal.notice');
