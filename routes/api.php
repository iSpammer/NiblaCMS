<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {


    return $request->user();
});

Route::apiResources(['user' => 'API\UserController']);
Route::apiResources(['contract' => 'API\ContractController']);
Route::apiResources(['agent' => 'API\AgentController']);
Route::apiResources(['project' => 'API\ProjectController']);
Route::post('addProjAgent', 'API\AgentController@addProject');
Route::get('getAgents', 'API\AgentController@getAllAgents');
Route::get('getProjects', 'API\ProjectController@getAllProjects');
Route::get('getContracts', 'API\ContractController@getAllContracts');
Route::get('profile', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');
Route::get('findUser', 'API\UserController@search');
Route::get('findContract', 'API\ContractController@search');
Route::get('findAgent', 'API\AgentController@search');
Route::get('findProject', 'API\ProjectController@search');

//     Route::get('/getTiers', function () {
//         $projects = DB::table('tier')->select()->get();
//         return (json_encode($projects));
// });
Route::middleware('auth:api')->get('/getStatus', function () {
    $status = DB::table('status')->select()->get();
    return (json_encode($status));
});

Route::middleware('auth:api')->get('/getTiers', function () {
    $tiers = DB::table('tier')->select()->get();
    return (json_encode($tiers));
});

Route::middleware('auth:api')->get('/getClass', function () {
    $classes = DB::table('class')->select()->get();
    return (json_encode($classes));
});

Route::get('/products', 'ProductController@index');
    Route::post('/upload-file', 'ProductController@uploadFile');
    Route::get('/products/{product}', 'ProductController@show');
