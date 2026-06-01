<?php

use App\Http\Controllers\Dev\DiplomaImportController;
use App\Http\Controllers\Dev\ContentImportController;
use App\Http\Controllers\Ajax\CityController;
use App\Http\Controllers\Axios\AxiosController;
use App\Http\Controllers\FancyBox\FancyBoxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pages\AboutController;
use App\Http\Controllers\Pages\ConsultingController;
use App\Http\Controllers\Pages\ScheduleController;
use App\Http\Controllers\Pages\ContactController;
use App\Http\Controllers\Pages\RemoteController;
use App\Http\Controllers\Pages\ResourcesController;
use App\Http\Controllers\Pages\TrainingController;
use App\Models\Consulting;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/** Главная **/
Route::get('/', [HomeController::class, 'index'])->name('home');
/** ///Главная **/

/** О нас **/
Route::controller(AboutController::class)->group(function () {
    Route::get('/onas', 'index')->name('about');
    Route::get('/onas/team', 'team')->name('about.team');
    Route::get('/onas/team/{slug}', 'teamShow')->name('about.team.show');
    Route::get('/onas/partnjory', 'partners')->name('about.partners');
    Route::get('/onas/partnjory/{slug}', 'partnersShow')->name('about.partners.show');
    Route::get('/onas/dokumenty', 'documents')->name('about.documents');
    Route::get('/onas/dokumenty/{slug}', 'documentsShow')->name('about.documents.show');
    Route::get('/onas/klienty', 'clients')->name('about.clients');
    Route::get('/onas/obrashchenie', 'aboutCompany')->name('about.company');
    Route::get('/onas/sotrudnichestvo', 'cooperation')->name('about.cooperation');
    Route::get('/onas/{slug}', 'indexShow')->name('about.show');
});
/** ///О нас **/

/** Обучение **/
Route::controller(TrainingController::class)->group(function () {
    Route::get('/obuchenie', 'index')->name('training');
    Route::get('/obuchenie/{slug}', 'indexShow')->name('training.show');
});
/** ///Обучение **/

/** Консалтинг **/
Route::controller(ConsultingController::class)->group(function () {
    Route::get('/konsalting', 'index')->name('consulting');
    Route::get('/konsalting/{slug}', 'indexShow')->name('consulting.show');
});
/** ///Консалтинг **/

/** Дистанционно **/
Route::controller(RemoteController::class)->group(function () {
    Route::get('/distantcionno', 'index')->name('remote');
    Route::get('/distantcionno/{slug}', 'indexShow')->name('remote.show');
});
/** ///Дистанционно **/

/** Полезное **/
Route::controller(ResourcesController::class)->group(function () {
    Route::get('/poleznoe',               'index')->name('resources');
    Route::get('/poleznoe/zakony',        'laws')->name('resources.laws');
    Route::get('/poleznoe/zakony/{slug}', 'lawsShow')->name('resources.laws.show');
    Route::get('/poleznoe/novosti',       'news')->name('resources.news');
    Route::get('/poleznoe/novosti/{slug}','newsShow')->name('resources.news.show');
    Route::get('/poleznoe/stati',       'important')->name('resources.important');
    Route::get('/poleznoe/stati/{slug}','importantShow')->name('resources.important.show');
    Route::get('/poleznoe/diplomy',       'diplomas')->name('resources.diplomas');
    Route::get('/poleznoe/diplomy/{slug}','diplomasShow')->name('resources.diplomas.show');
    Route::get('/poleznoe/seminar',       'seminar')->name('resources.seminar');
    Route::get('/poleznoe/seminar/{slug}','seminarShow')->name('resources.seminar.show');
    Route::get('/poleznoe/{slug}',        'indexShow')->name('resources.show');
});
/** ///Полезное **/

/** Расписание **/
Route::controller(ScheduleController::class)->group(function () {
    Route::get('/raspisani', 'index')->name('schedule');
    Route::get('/raspisani/filter', 'filterByCourse')->name('schedule.filter');
    Route::get('/raspisani/{slug}/months', 'filterByMonth')->name('schedule.filterByMonth');
    Route::get('/raspisani/{slug}', 'indexShow')->name('schedule.show');
});
/** ///Расписание **/

/** Контакты **/
Route::get('/kontakty', [ContactController::class, 'index'])->name('contacts');
/** ///Контакты **/

/** Город (сессия) **/
Route::post('/set-city', [CityController::class, 'setCity'])->name('city.set');
/** ///Город (сессия) **/

/** FancyBox AJAX **/
Route::controller(FancyBoxController::class)->group(function () {
    Route::post('/fancybox-ajax', 'fancybox');
});
/** ///FancyBox AJAX **/

/** Axios async forms **/
Route::controller(AxiosController::class)->group(function () {
    Route::post('/upload-form-async', 'async');
    Route::post('/call-me-blue', 'callMeBlue');
    Route::post('/consult-me', 'consultMe');
    Route::post('/record-me', 'recordMe');
    Route::post('/schedule-enroll', 'scheduleEnroll');
    Route::post('/program-enroll', 'programEnroll');
});
/** ///Axios async forms **/

/** Admin Inline Edit **/
Route::post('/admin-inline-edit', [\App\Http\Controllers\Admin\InlineEditController::class, 'update'])
    ->name('admin.inline-edit');
/** ///Admin Inline Edit **/

/** Admin AJAX **/
Route::post('/admin-ajax/training/{training}/categories', function (Request $request, Training $training) {
    $training->categories()->sync($request->input('categories', []));
    return response()->json(['ok' => true]);
})->name('training.categories.update');

Route::post('/admin-ajax/consulting/{consulting}/categories', function (Request $request, Consulting $consulting) {
    $consulting->categories()->sync($request->input('categories', []));
    return response()->json(['ok' => true]);
})->name('consulting.categories.update');
/** ///Admin AJAX **/

/** DEV: импорт дипломов из Joomla Zoo — удалить после использования **/
Route::prefix('dev/diplomas')->controller(DiplomaImportController::class)->group(function () {
 /*   Route::get('/preview', 'preview');
    Route::get('/import', 'import');*/
});
/** DEV: импорт контента из Joomla (catid=25) — удалить после использования **/
Route::prefix('dev/contents')->controller(ContentImportController::class)->group(function () {
/*    Route::get('/preview', 'preview');
    Route::get('/import', 'import');*/
});
/** ///DEV **/
