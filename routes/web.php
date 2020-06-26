<?php

use Illuminate\Support\Facades\Route;
use  GuzzleHttp \ Client ;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $client  =  new  Client ([
        'base_uri'  =>  'http://gateway.marvel.com'
    ]);
    $response = $client->request('GET', '/v1/public/comics?ts=1&apikey=14cfef4a2ed0248b39a2f9897cbe6dd8&hash=ddc175e39e993b7af94eb8f6856aa1cb');
    $data = json_decode($response->getBody()->getContents());
    $results = $data->data->results;



    usort($results, "cmp");
    return view('welcome', compact('results') );
});

function cmp($a, $b) {
    return strcmp($a->title, $b->title);
}


Route::post('/informacion', 'Controller@loadInformacion')->name('informacion');
Route::get('/sucursales', 'Controller@sucursales')->name('sucursales');
Route::post('/sucursales/save', 'Controller@sucursalesSave')->name('sucursales/save');
Route::post('/sucursales/edit', 'Controller@sucursalesEdit')->name('sucursales/edit');
Route::post('/sucursales/delete', 'Controller@sucursalesDelete')->name('sucursales/delete');

Route::post('/loadForm', 'Controller@loadFormSucursales')->name('loadForm');
Route::post('/loadFormEdit', 'Controller@loadFormSucursalesEdit')->name('loadFormEdit');


Route::get('/sucursales/add/comics/{idSucursal}/{nombreSuc}', 'Controller@sucursalesAdd')->name('sucursales/add');
Route::post('/inventory/save', 'Controller@saveInventory')->name('save/inventory');

