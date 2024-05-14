
<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api'], function () use ($router) {

        $router->get('products', 'ProductController@index');
        $router->post('product', 'ProductController@store');
        $router->get('product/{id}', 'ProductController@show');
        $router->put('product/{id}', 'ProductController@update');
        $router->delete('product/{id}', 'ProductController@destroy');

        $router->get('categories', 'CategoryController@index');
        $router->post('categories', 'CategoryController@store');
        $router->get('categories/{id}', 'CategoryController@show');
        $router->put('categories/{id}', 'CategoryController@update');
        $router->delete('categories/{id}', 'CategoryController@destroy');

        $router->post('user/register', 'AuthController@register');
        $router->post('user/login', 'AuthController@login');

    $router->group(['prefix' => 'user','middleware' => 'auth:api'], function () use ($router) {

        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
        $router->post('user-profile', 'AuthController@me');
    });

});
