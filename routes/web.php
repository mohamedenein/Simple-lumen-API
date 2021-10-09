<?php



/** @var \Laravel\Lumen\Routing\Router $router */

use App\Models\Article;
use App\Mail\Verify_Email;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api'], function() use ($router){
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');

    $router->group(['middleware' => ['auth']], function () use ($router){
        $router->post('/create_article', 'ArticleController@create');
        $router->post('/edit_article/{id}', 'ArticleController@update');
        $router->post('/delete_article/{id}', 'ArticleController@delete');
        $router->get('/profile[/lang={locale}]', 'ArticleController@profile_with_articles');

        $router->get('/send_mail', 'AuthController@SendVerifyEmail');
        $router->get('/verify', 'AuthController@VerifyEmail');
        $router->get('/verify_phone', 'AuthController@VerifyPhone');

    });

});

