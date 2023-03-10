<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 *
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /*
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Public', 'action' => 'index']);
    $routes->connect('/admin', ['controller' => 'Admin', 'action' => 'index']);

    /*
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    // $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    $routes->prefix('api', function (RouteBuilder $routes) {
        $routes->resources('Categories');
        $routes->scope('/categories', ['controller' => 'Categories'], function ($routes) {
            $routes->connect('/:slug', ['action' => 'view', '_method' => 'GET'], ['pass' => ['slug']]);
            $routes->connect('/:slug', ['action' => 'edit', '_method' => 'PUT'], ['pass' => ['slug']]);
            $routes->connect('/:slug', ['action' => 'delete', '_method' => 'DELETE'], ['pass' => ['slug']]);
        });
        $routes->resources('Products', [
            'map' => [
                'delete-all' => [
                    'action' => 'deleteAll',
                    'method' => 'DELETE',
                ],
            ],
        ],
        function (RouteBuilder $routes) {
            $routes->scope('/images', ['controller' => 'ProductImages'], function (RouteBuilder $routes) {
                $routes->connect('/', ['action' => 'index', '_method' => ['GET']], ['pass' => ['product_id']]);
                $routes->connect('/:id', ['action' => 'view', '_method' => ['GET']], ['pass' => ['product_id', 'id']]);
                $routes->connect('/', ['action' => 'add', '_method' => ['POST']], ['pass' => ['product_id']]);
                $routes->connect('/mark-main/:id', ['action' => 'edit', '_method' => ['PUT']], ['pass' => ['product_id', 'id']]);
                $routes->connect('/:id', ['action' => 'delete', '_method' => ['DELETE']], ['pass' => ['product_id', 'id']]);
            });
            $routes->scope('/specifications', ['controller' => 'ProductSpecifications'], function (RouteBuilder $routes) {
                $routes->connect('/', ['action' => 'index', '_method' => ['GET']], ['pass' => ['product_id']]);
                $routes->connect('/:id', ['action' => 'view', '_method' => ['GET']], ['pass' => ['product_id', 'id']]);
                $routes->connect('/', ['action' => 'add', '_method' => ['POST']], ['pass' => ['product_id']]);
                $routes->connect('/:id', ['action' => 'edit', '_method' => ['PUT']], ['pass' => ['product_id', 'id']]);
                $routes->connect('/:id', ['action' => 'delete', '_method' => ['DELETE']], ['pass' => ['product_id', 'id']]);
            });
        });
        $routes->scope('/products', ['controller' => 'Products'], function ($routes) {
            $routes->connect('/:slug', ['action' => 'view', '_method' => ['GET']], ['pass' => ['slug']]);
            $routes->connect('/:slug', ['action' => 'edit', '_method' => ['PUT']], ['pass' => ['slug']]);
            $routes->connect('/:slug', ['action' => 'delete', '_method' => 'DELETE'], ['pass' => ['slug']]);
        });
        $routes->scope('/settings', ['controller' => 'Settings'], function (RouteBuilder $routes) {
            $routes->connect('/', ['action' => 'view', '_method' => ['GET']]);
            $routes->connect('/', ['action' => 'edit', '_method' => ['PUT']]);
        });
        $routes->resources('Users');
        $routes->scope('/auth', ['controller' => 'Auth'], function (RouteBuilder $routes) {
            $routes->connect('/login', ['action' => 'login', '_method' => ['POST']]);
        });
        $routes->scope('/emails', ['controller' => 'Emails'], function (RouteBuilder $routes) {
            $routes->connect('/send', ['action' => 'send', '_method' => ['POST']]);
        });
    });

    $routes->connect('/:route/**', ['controller' => 'Public', 'action' => 'index']);
    /*
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    // $routes->fallbacks(DashedRoute::class);
});

/*
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
