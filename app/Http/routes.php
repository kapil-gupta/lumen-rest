<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */
$app->get('/', function () use($app) {
    return $app->welcome();
});
$api_prefix = config('constants.api_prefix');
$app->group(['prefix' => $api_prefix], function($app)
{
	$app->get('users', [
			'middleware' => 'old',
			'as' => 'users.index',
			'uses' => 'App\Http\Controllers\UserController@index'
	]);
	$app->post('users', [
			'as' => 'users.store',
			'uses' => 'App\Http\Controllers\UserController@store'
	]);
	$app->put('users/{id}', [
			'as' => 'users.update',
			'uses' => 'App\Http\Controllers\UserController@update'
	]);
	$app->delete('users/{id}', [
			'as' => 'users.delete',
			'uses' => 'App\Http\Controllers\UserController@destroy'
	]);
});
