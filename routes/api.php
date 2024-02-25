<?php

	use App\Http\Controllers\TaskController;
	use App\Http\Controllers\UserController;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Route;

	/*
	|--------------------------------------------------------------------------
	| API Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register API routes for your application. These
	| routes are loaded by the RouteServiceProvider and all of them will
	| be assigned to the "api" middleware group. Make something great!
	|
	*/

	/*
	 * Auth group
	 */
	Route::group([
		'prefix' => 'auth'
	], function () {
		Route::post('/signup', [UserController::class, 'signup']);
		Route::post('/login', [UserController::class, 'login']);
	});


	/*
	 * Task group
	 */
	Route::group([
		'prefix'     => 'task',
		'middleware' => 'auth:sanctum'
	], function () {
		Route::get('/all', [TaskController::class, 'all']);
		Route::post('/new', [TaskController::class, 'store']);
		Route::post('/complete', [TaskController::class, 'complete']);
	});

	Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
		return $request->user();
	});
