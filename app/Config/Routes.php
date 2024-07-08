<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\SectionsController;
use App\Controllers\CollectionsController;
use App\Controllers\SourcesController;
use App\Controllers\PublicationsController;
use App\Controllers\PublicController;
use App\Controllers\DownloadController;

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
$routes->post('/admin/sections/form-processing', [SectionsController::class, 'formProcessing']);
$routes->get('/admin/sections/delete/(:num)', [SectionsController::class, 'delete/$1']);
$routes->post('/admin/sections/set-filter', [SectionsController::class, 'setFilter']);
$routes->post('/admin/sections/change-visible/', [SectionsController::class, 'changeVisible']);

/** ADMIN: COLLECTIONS */
$routes->get('/admin/collections', [CollectionsController::class, 'CollectionsList']);
$routes->get('/admin/collections/add', [CollectionsController::class, 'form/add']);
$routes->get('/admin/collections/edit/(:num)', [CollectionsController::class, 'form/edit/$1/$2']);
$routes->post('/admin/collections/form-processing', [CollectionsController::class, 'formProcessing']);
$routes->get('/admin/collections/delete/(:num)', [CollectionsController::class, 'delete/$1']);
$routes->post('/admin/collections/change-visible', [CollectionsController::class, 'changeVisible']);
$routes->post('/admin/collections/set-filter', [CollectionsController::class, 'setFilter']);

/** ADMIN: SOURCES */
$routes->get('/admin/sources', [SourcesController::class, 'SourcesList']);
$routes->get('/admin/sources/add', [SourcesController::class, 'form/add']);
$routes->get('/admin/sources/edit/(:num)', [SourcesController::class, 'form/edit/$1/$2']);
$routes->post('/admin/sources/form-processing', [SourcesController::class, 'formProcessing']);
$routes->get('/admin/sources/delete/(:num)', [SourcesController::class, 'delete/$1']);
$routes->post('/admin/sources/change-visible/', [SourcesController::class, 'changeVisible']);
$routes->post('/admin/sources/set-filter', [SourcesController::class, 'setFilter']);

/** ADMIN: PUBLICATIONS */
$routes->get(   '/admin/publications/',                  [PublicationsController::class, 'adminList']);
$routes->get(   '/admin/publications/page-(:num)/',                  [PublicationsController::class, 'adminList/$1']);
$routes->get(   '/admin/publications/add',              [PublicationsController::class, 'form/add']);
$routes->post(  '/admin/publications/form-processing',  [PublicationsController::class, 'formProcessing']);
$routes->get(   '/admin/publications/edit/(:num)',      [PublicationsController::class, 'form/edit/$1/$2']);
$routes->get(   '/admin/publications/delete/(:num)',    [PublicationsController::class, 'delete/$1']);
$routes->post(  '/admin/publications/change-visible',   [PublicationsController::class, 'changeVisible']);

/** PUBLIC: PUBLICATIONS */
$routes->get('/', [PublicController::class, 'MainList']);
$routes->get('/sections/(:num)', [PublicController::class, 'ChapterList/$1']);
$routes->get('/sections/(:num)/page-(:num)', [PublicController::class, 'ChapterList/$1/$2']);
$routes->get('/collections/(:num)', [PublicController::class, 'CollectList/$1']);
$routes->get('/collections/(:num)/page-(:num)', [PublicController::class, 'CollectList/$1/$2']);
$routes->get('/publication/(:num)', [PublicController::class, 'Publication/$1']);
$routes->get('/publication/(:num)/page-(:num)', [PublicController::class, 'Publication/$1/$2']);

/* Downloader */
$routes->get('/download/(:segment)/(:segment)', [DownloadController::class, 'downloadPdf/$1/$2']);
$routes->get('/link/', [DownloadController::class, 'readPDF']);
