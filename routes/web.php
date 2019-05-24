<?php

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
/*
use App\Video;

$videos = Video::all();
    foreach ($videos as $video) {
        # code...
        echo $video->title."<br>";
        echo $video->user->email;
        foreach ($video->comments as $comment) {
            echo "<br>";
            echo $comment->body."<br>";
        }
        
        echo "<hr>";
    }

    die();

*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resource('/crear-video', 'VideoController');


Route::get('/miniatura/{file}',"VideoController@getImage");
Route::get('/video-file/{file}',"VideoController@getVideo");


Route::resource('/comments', 'ComentarioController');
Route::get('/search/{filtro?}',"VideoController@buscarVideo");