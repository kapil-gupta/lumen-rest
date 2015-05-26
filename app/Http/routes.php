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
    //return $app->welcome();
	return view()->make('client');
});
	 
$api_prefix = config('constants.api_prefix');
/*
$app->post('login', function() use($app) {
	$credentials = app()->make('request')->input("credentials");
	return $app->make('App\Auth\Proxy')->attemptLogin($credentials);
});
$app->post('refresh-token', function() use($app) {
	return $app->make('App\Auth\Proxy')->attemptRefresh();
});
*/
$app->post('login',  [
			'as' => 'login',
			'uses' => 'App\Http\Controllers\OAuth\ProxyController@attemptLogin'
]);
$app->post('refresh-token',  [
			'as' => 'login',
			'uses' => 'App\Http\Controllers\OAuth\ProxyController@attemptRefresh'
]);

$app->post('oauth/access-token',  [
		'as' => 'login',
		'uses' => 'App\Http\Controllers\OAuth\ProxyController@getAccessToken'
]);

$app->group(['prefix' => $api_prefix, 'middleware' => 'oauth'], function($app)
{
	$app->get('users', [
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
