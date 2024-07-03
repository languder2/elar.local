<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\SectionsController;
use App\Controllers\CollectionsController;
use App\Controllers\SourcesController;

/**
 * @var RouteCollection $routes
 */

/** ADMIN: EXIT  */
$routes->get('/admin/exit/', [UserController::class, 'exit']);
$routes->get('/exit/', [UserController::class, 'exit']);
/** ADMIN: AUTH  */
$routes->match(['get','post'],'/admin/', [UserController::class, 'auth']);
$routes->match(['get','post'],'/admin/welcome', [AdminController::class, 'welcome']);

/** ADMIN: SECTIONS  */
$routes->get('/admin/sections', [SectionsController::class, 'adminList']);
$routes->match(['get','post'],'/admin/sections/add', [SectionsController::class, 'form/add']);
$routes->match(['get','post'],'/admin/sections/edit/(:num)', [SectionsController::class, 'form/edit/$1']);
$routes->post('admin/sections/form-processing', [SectionsController::class, 'formProcessing']);
$routes->get('/admin/collections/delete/(:num)', [CollectionsController::class, 'delete/$1']);

/** ADMIN: COLLECTIONS */
$routes->get('/admin/collections', [CollectionsController::class, 'CollectionsList']);
$routes->get('/admin/collections/add', [CollectionsController::class, 'form/add']);
$routes->get('/admin/collections/edit/(:num)', [CollectionsController::class, 'form/edit/$1/$2']);
$routes->post('/admin/collections/form-processing', [CollectionsController::class, 'formProcessing']);
$routes->get('/admin/collections/delete/(:num)', [CollectionsController::class, 'delete/$1']);
$routes->post('/admin/collections/change-visible/', [CollectionsController::class, 'changeVisible']);
$routes->post('/admin/collections/set-filter', [CollectionsController::class, 'setFilter']);

/** ADMIN: SOURCES */
$routes->get('/admin/sources', [SourcesController::class, 'SourcesList']);
$routes->get('/admin/sources/add', [SourcesController::class, 'form/add']);
$routes->get('/admin/sources/edit/(:num)', [SourcesController::class, 'form/edit/$1/$2']);
$routes->post('/admin/sources/form-processing', [SourcesController::class, 'formProcessing']);
$routes->get('/admin/sources/delete/(:num)', [SourcesController::class, 'delete/$1']);
$routes->post('/admin/sources/change-visible/', [SourcesController::class, 'changeVisible']);
$routes->post('/admin/sources/set-filter', [SourcesController::class, 'setFilter']);


