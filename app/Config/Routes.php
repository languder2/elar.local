<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\SectionsController;
use App\Controllers\CollectionsController;

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
$routes->match(['get','post'],'/admin/sections', [SectionsController::class, 'adminList']);
$routes->match(['get','post'],'/admin/sections/add', [SectionsController::class, 'form/add']);
$routes->match(['get','post'],'/admin/sections/edit/(:num)', [SectionsController::class, 'form/edit/$1']);
$routes->match(['get','post'],'admin/sections/form-processing', [SectionsController::class, 'formProcessing']);

/** PUBLIC: ЗАГЛУШКА */
$routes->get('/admin/collections', [CollectionsController::class, 'CollectionsList']);
$routes->get('/admin/collections/add', [CollectionsController::class, 'form/add']);
$routes->get('/admin/collections/edit/(:num)', [CollectionsController::class, 'form/edit/$1/$2']);
$routes->post('/admin/collections/form-processing', [CollectionsController::class, 'formProcessing']);
$routes->get('/admin/collections/delete/(:num)', [CollectionsController::class, 'delete/$1']);
$routes->post('/admin/collections/change-visible/', [CollectionsController::class, 'changeVisible']);
$routes->post('/admin/collections/set-filter', [CollectionsController::class, 'setFilter']);

