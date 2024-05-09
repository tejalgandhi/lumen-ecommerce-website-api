
<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api'], function () use ($router) {

        $router->get('products', 'ProductController@index');
        $router->post('product', 'ProductController@store');
        $router->get('product/{id}', 'ProductController@show');
        $router->put('product/{id}', 'ProductController@update');
        $router->delete('product/{id}', 'ProductController@destroy');
});
