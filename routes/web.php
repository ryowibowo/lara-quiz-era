<?php

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

Route::get('/register', function () {
    return view('register');
});
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'postRegis'])->name('check-register');

Auth::routes(['register' => false]);

Route::get('/others', function () {
    return view('others');
});



Route::get('/elearning', function () {
    return view('elearning');
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/post-login', [\App\Http\Controllers\Auth\LoginController::class, 'postLogin'])->name('post-login');

Route::get('/getProvinces', [\App\Http\Controllers\DistrictController::class, 'getAjaxProvinces'])->name('get-ajax-provinces');
Route::get('/getCities/{id}', [\App\Http\Controllers\DistrictController::class, 'getAjaxCities'])->name('get-ajax-cities');
Route::get('/getDistricts/{id}', [\App\Http\Controllers\DistrictController::class, 'getAjaxDistricts'])->name('get-ajax-districts');
Route::get('/getSubDistricts/{id}', [\App\Http\Controllers\DistrictController::class, 'getAjaxSubDistricts'])->name('get-ajax-sub-districts');

Route::group(['middleware' => 'auth'], function () {
    Route::fallback(function () {
        return view('errors.404');
    });

    Route::group(['prefix' => 'menus'], function () {
        Route::get('/', [App\Http\Controllers\MenuController::class, 'index'])->name('menus.index');
        Route::get('/get-datatables', [App\Http\Controllers\MenuController::class, 'getDatatables'])->name('menus.getDatatables');
        Route::get('/get-parent-menu', [App\Http\Controllers\MenuController::class, 'getParentMenu'])->name('menus.getParentMenu');
        Route::post('/', [App\Http\Controllers\MenuController::class, 'store'])->name('menus.store');
        Route::get('/{id}', [App\Http\Controllers\MenuController::class, 'edit'])->name('menus.edit');
        Route::put('/{id}', [App\Http\Controllers\MenuController::class, 'update'])->name('menus.update');
        Route::delete('/{id}', [App\Http\Controllers\MenuController::class, 'destroy'])->name('menus.destroy');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
        Route::get('/get-datatables', [App\Http\Controllers\RoleController::class, 'getDatatables'])->name('roles.getDatatables');
        Route::post('/', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
        Route::get('/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
        Route::delete('/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/privileges/{id}', [App\Http\Controllers\RoleController::class, 'privileges'])->name('roles.privileges');
        Route::post('/privileges', [App\Http\Controllers\RoleController::class, 'storePrivileges'])->name('roles.privileges.store');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/get-datatables', [App\Http\Controllers\UserController::class, 'getDatatables'])->name('users.getDatatables');
        Route::post('/', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::group(['prefix' => 'actions'], function () {
        Route::get('/', [App\Http\Controllers\ActionController::class, 'index'])->name('actions.index');
        Route::get('/get-datatables', [App\Http\Controllers\ActionController::class, 'getDatatables'])->name('actions.getDatatables');
        Route::post('/', [App\Http\Controllers\ActionController::class, 'store'])->name('actions.store');
        Route::get('/{id}', [App\Http\Controllers\ActionController::class, 'edit'])->name('actions.edit');
        Route::put('/{id}', [App\Http\Controllers\ActionController::class, 'update'])->name('actions.update');
        Route::delete('/{id}', [App\Http\Controllers\ActionController::class, 'destroy'])->name('actions.destroy');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
        Route::put('/{id}', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    });

    //master
    Route::group(['prefix' => 'master'], function () {
        Route::group(['prefix' => 'soal'], function () {
            //topic
            Route::get('/', [App\Http\Controllers\QuestionController::class, 'index'])->name('question.index');
            Route::get('/get-datatables', [App\Http\Controllers\QuestionController::class, 'getDatatables'])->name('question.getDatatables');
            Route::post('/storeTopic', [App\Http\Controllers\QuestionController::class, 'storeTopic'])->name('question.storeTopic');
            Route::get('/editTopic/{id}', [App\Http\Controllers\QuestionController::class, 'editTopic'])->name('question.editTopic');
            Route::put('/updateTopic/{id}', [App\Http\Controllers\QuestionController::class, 'updateTopic'])->name('question.updateTopic');
            Route::delete('/deleteTopic/{id}', [App\Http\Controllers\QuestionController::class, 'destroyTopic'])->name('question.destroyTopic');

            //soal
            Route::get('/detail/{id}', [App\Http\Controllers\QuestionController::class, 'detail'])->name('question.detail');
            Route::get('/create/{id}', [App\Http\Controllers\QuestionController::class, 'create'])->name('question.create');
            Route::post('/storeQuestion/{id}', [App\Http\Controllers\QuestionController::class, 'storeQuestion'])->name('question.storeQuestion');
            Route::get('/get-datatablesQuestion/{id}', [App\Http\Controllers\QuestionController::class, 'getDatatablesQuestion'])->name('question.getDatatablesQuestion');
            Route::get('/editQuestion/{id}', [App\Http\Controllers\QuestionController::class, 'edit'])->name('question.edit');
            Route::post('/updateQuestion/{id}', [App\Http\Controllers\QuestionController::class, 'update'])->name('question.update');
            Route::delete('/deleteQuestion/{id}', [App\Http\Controllers\QuestionController::class, 'destroy'])->name('question.destroy');
        });
    });

    Route::group(['prefix' => 'quiz'], function () {
        Route::get('/', [App\Http\Controllers\QuizController::class, 'index'])->name('quiz.index');
        Route::get('/start/{id}', [App\Http\Controllers\QuizController::class, 'start'])->name('quiz.start');
        Route::post('/{id}', [App\Http\Controllers\QuizController::class, 'store'])->name('quiz.store');
    });
});
