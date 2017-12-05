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


Route::get('/', function () {
    return view('app');
});

Route::post('oauth/acess_token', function () {
    return Response::json(Authorizer::issueAccessToken());
});

Route::get('/besteira', 'ClientController@besteira');



Route::group(['middleware' => 'oauth'], function () {

    Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);
    Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);
    Route::group(['prefix' => 'project'], function () {

        Route::get('/{id}/notes', 'ProjectNoteController@index');
        Route::post('/{id}/notes', 'ProjectNoteController@store');
        Route::get('/{id}/notes/{noteId}', 'ProjectNoteController@show');
        Route::put('/{id}/notes/{noteId}', 'ProjectNoteController@update');
        Route::delete('/{id}/notes/{noteId}', 'ProjectNoteController@destroy');

        Route::get('/{id}/task', 'ProjectTaskController@index');
        Route::post('/{id}/task', 'ProjectTaskController@store');
        Route::get('/{id}/task/{taskId}', 'ProjectTaskController@show');
        Route::post('/{id}/task/{taskId}', 'ProjectTaskController@update');
        Route::delete('/{id}/task/{taskId}', 'ProjectTaskController@destroy');

        Route::get('/{id}/members', 'ProjectMembersController@index');
        Route::post('/{id}/members', 'ProjectMembersController@store');
        Route::delete('/{id}/members/{memberId}', 'ProjectMembersController@destroy');
        Route::get('/{id}/members/{userId}', 'ProjectMembersController@member');

        Route::post('/{id}/file', 'ProjectFileController@store');
        Route::delete('/{id}/file/{fileId}', 'ProjectFileController@destroy');

    });
});







