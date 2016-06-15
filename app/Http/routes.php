<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/sprints', 'SprintsController@index');
Route::get('/get/sprint', 'SprintsController@getSprint');
Route::post('/loa/task', 'TaskController@getTask');
Route::post('/work/task', 'TaskController@onWork');
Route::post('/work/finish', 'TaskController@onFinish');



Route::get('/get/project', 'ProjectsController@getProject');
Route::get('/projects', 'ProjectsController@index');


Route::group(['middleware' => ['admin']], function () {
    //Создание спинтов только для администратора или Скрам менеджера
    Route::post('/create/sprint', 'SprintsController@create');
    //Создание проектов только для администратора или Скрам менеджера
    Route::post('/create/project', 'ProjectsController@create');
    //Удалить проект
    Route::post('/delete/project', 'ProjectsController@delete');
    
    Route::post('/create/task', 'TaskController@create');

    Route::get('/users', 'UsersController@index');

    Route::get('/gant', 'TaskController@gant');


    Route::get('/back', 'BackController@index');
    Route::post('/create/back', 'BackController@create');
    Route::post('/delete/back', 'BackController@delete');
    Route::get('/get/back', 'BackController@getBack');


    Route::get('/get/gant', 'TaskController@getGant');
    

    Route::get('/', 'ProjectsController@index');
    Route::get('/sprint/gant', 'SprintsController@sprintGant');
    Route::get('/sprint_gant', 'SprintsController@gant');
});