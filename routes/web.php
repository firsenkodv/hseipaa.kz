<?php

use App\Http\Controllers\Axios\AxiosController;
use App\Http\Controllers\FancyBox\FancyBoxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pages\AboutController;
use App\Http\Controllers\Pages\ConsultingController;
use App\Http\Controllers\Pages\RemoteController;
use App\Http\Controllers\Pages\ResourcesController;
use App\Http\Controllers\Pages\TrainingController;
use Illuminate\Support\Facades\Route;

/** Главная **/
Route::get('/', [HomeController::class, 'index'])->name('home');
/** ///Главная **/

/** О нас **/
Route::controller(AboutController::class)->group(function () {
    Route::get('/onas', 'index')->name('about');
    Route::get('/onas/team', 'team')->name('about.team');
    Route::get('/onas/partnjory', 'partners')->name('about.partners');
    Route::get('/onas/dokumenty', 'documents')->name('about.documents');
});
/** ///О нас **/

/** Обучение **/
Route::get('/obuchenie', [TrainingController::class, 'index'])->name('training');
/** ///Обучение **/

/** Консалтинг **/
Route::get('/konsalting', [ConsultingController::class, 'index'])->name('consulting');
/** ///Консалтинг **/

/** Дистанционно **/
Route::get('/distantcionno', [RemoteController::class, 'index'])->name('remote');
/** ///Дистанционно **/

/** Полезное **/
Route::controller(ResourcesController::class)->group(function () {
    Route::get('/poleznoe', 'index')->name('resources');
    Route::get('/poleznoe/zakony', 'laws')->name('resources.laws');
    Route::get('/poleznoe/zakony/{slug}', 'lawsShow')->name('resources.laws.show');
    Route::get('/poleznoe/novosti', 'news')->name('resources.news');
    Route::get('/poleznoe/novosti/{slug}', 'newsShow')->name('resources.news.show');
    Route::get('/poleznoe/vazhnoe', 'important')->name('resources.important');
    Route::get('/poleznoe/diplomy', 'diplomas')->name('resources.diplomas');
    Route::get('/poleznoe/diplomy/{slug}', 'diplomasShow')->name('resources.diplomas.show');
    Route::get('/poleznoe/seminar', 'seminar')->name('resources.seminar');
    Route::get('/poleznoe/seminar/{slug}', 'seminarShow')->name('resources.seminar.show');
});
/** ///Полезное **/

/** FancyBox AJAX **/
Route::controller(FancyBoxController::class)->group(function () {
    Route::post('/fancybox-ajax', 'fancybox');
});
/** ///FancyBox AJAX **/

/** Axios async forms **/
Route::controller(AxiosController::class)->group(function () {
    Route::post('/upload-form-async', 'async');
    Route::post('/call-me-blue', 'callMeBlue');
});
/** ///Axios async forms **/
