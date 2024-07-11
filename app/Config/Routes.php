<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\SectionsController;
use App\Controllers\CollectionsController;
use App\Controllers\TypesController;
use App\Controllers\PublicationsController;
use App\Controllers\PublicController;
use App\Controllers\DownloadController;

/**
 * @var RouteCollection $routes
 */

/** ADMIN: EXIT  */
$routes->get(   '/admin/exit/',                         [UserController::class, 'exit']);
$routes->get(   '/exit/',                               [UserController::class, 'exit']);

/** ADMIN: AUTH  */
$routes->match( ['get','post'],'/admin/',               [UserController::class, 'auth']);
$routes->match( ['get','post'],'/admin/welcome',        [AdminController::class, 'welcome']);

/** ADMIN: SECTIONS  */
$routes->get(   '/admin/sections',                      [SectionsController::class, 'adminList']);
$routes->match( ['get','post'],'/admin/sections/add',   [SectionsController::class, 'form/add']);
$routes->get(   '/admin/sections/edit/(:num)',          [SectionsController::class, 'form/edit/$1']);
$routes->post(  '/admin/sections/form-processing',      [SectionsController::class, 'formProcessing']);
$routes->get(   '/admin/sections/delete/(:num)',        [SectionsController::class, 'delete/$1']);
$routes->post(  '/admin/sections/set-filter',           [SectionsController::class, 'setFilter']);
$routes->post(  '/admin/sections/change-visible/',      [SectionsController::class, 'changeVisible']);

/** ADMIN: COLLECTIONS */
$routes->get(   '/admin/collections',                   [CollectionsController::class, 'CollectionsList']);
$routes->get(   '/admin/collections/add',               [CollectionsController::class, 'form/add']);
$routes->get(   '/admin/collections/edit/(:num)',       [CollectionsController::class, 'form/edit/$1/$2']);
$routes->post(  '/admin/collections/form-processing',   [CollectionsController::class, 'formProcessing']);
$routes->get(   '/admin/collections/delete/(:num)',     [CollectionsController::class, 'delete/$1']);
$routes->post(  '/admin/collections/change-visible',    [CollectionsController::class, 'changeVisible']);
$routes->post(  '/admin/collections/set-filter',        [CollectionsController::class, 'setFilter']);

/** ADMIN: TYPES */
$routes->get(   '/admin/types',                         [TypesController::class, 'adminList']);
$routes->get(   '/admin/types/add',                     [TypesController::class, 'form/add']);
$routes->get(   '/admin/types/edit/(:num)',             [TypesController::class, 'form/edit/$1/$2']);
$routes->post(  '/admin/types/form-processing',         [TypesController::class, 'formProcessing']);
$routes->get(   '/admin/types/delete/(:num)',           [TypesController::class, 'delete/$1']);
$routes->post(  '/admin/types/change-visible/',         [TypesController::class, 'changeVisible']);
$routes->post(  '/admin/types/set-filter',              [TypesController::class, 'setFilter']);

/** Admin: Publications */
$routes->get(   '/admin/publications/',                 [PublicationsController::class, 'adminList']);
$routes->get(   '/admin/publications/page-(:num)/',     [PublicationsController::class, 'adminList']);
$routes->get(   '/admin/publications/add',              [PublicationsController::class, 'form/add']);
$routes->post(  '/admin/publications/form-processing',  [PublicationsController::class, 'formProcessing']);
$routes->get(   '/admin/publications/edit/(:num)',      [PublicationsController::class, 'form/edit']);
$routes->get(   '/admin/publications/delete/(:num)',    [PublicationsController::class, 'delete']);
$routes->post(  '/admin/publications/change-visible',   [PublicationsController::class, 'changeVisible']);

/** Public: Publications */
$routes->get(   '/publication/(:num)',                  [PublicationsController::class, 'publication']);
$routes->get(   '/correct/',                            [PublicationsController::class, 'correct']);

/** Public: Section */
$routes->get(   '/section/(:num)',                      [SectionsController::class, 'showSection']);
$routes->get(   '/section/(:num)/page-(:num)/',         [SectionsController::class, 'showSection']);


/** PUBLIC: PAGES */
//$routes->get(   '/',                                    [PublicController::class, 'MainList']);
$routes->get(   '/',                                    [PublicController::class, 'index']);
$routes->get(   '/sections/(:num)',                     [PublicController::class, 'ChapterList']);
$routes->get(   '/sections/(:num)/page-(:num)',         [PublicController::class, 'ChapterList']);
$routes->get(   '/browse/(:segment)',                   [PublicController::class, 'browse/$1']);
$routes->post(  '/browse/(:segment)/set-filter',        [PublicController::class, 'setFilter/$1']);

/** Downloader */
$routes->get(   '/download/(:segment)/(:segment)',      [DownloadController::class, 'downloadPdf/$1/$2']);
$routes->get(   '/link/',                               [DownloadController::class, 'readPDF']);


/** Other */
$routes->get(   '/(:any)',                              [PublicController::class, 'MainList']);
