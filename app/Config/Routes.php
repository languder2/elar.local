<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\User;
use App\Controllers\Admin;
use App\Controllers\Sections;
use App\Controllers\Types;
use App\Controllers\Publications;
use App\Controllers\PublicController;
use App\Controllers\Download;
use App\Controllers\References;

/**
 * @var RouteCollection $routes
 */

/** ADMIN: EXIT  */
$routes->get(   '/admin/exit/',                             [User::class, 'exit']);
$routes->get(   '/exit/',                                   [User::class, 'exit']);

/** ADMIN: AUTH  */
$routes->match( ['get','post'],'/admin/',                   [User::class, 'auth']);
$routes->match( ['get','post'],'/admin/welcome',            [Admin::class, 'welcome']);

/** ADMIN: SECTIONS  */
$routes->get(   '/admin/sections',                          [Sections::class, 'adminList']);
$routes->match( ['get','post'],'/admin/sections/add',       [Sections::class, 'form/add']);
$routes->get(   '/admin/sections/edit/(:num)',              [Sections::class, 'form/edit/$1']);
$routes->post(  '/admin/sections/form-processing',          [Sections::class, 'formProcessing']);
$routes->get(   '/admin/sections/delete/(:num)',            [Sections::class, 'delete/$1']);
$routes->post(  '/admin/sections/set-filter',               [Sections::class, 'setFilter']);
$routes->post(  '/admin/sections/change-visible/',          [Sections::class, 'changeVisible']);

/** ADMIN: TYPES */
$routes->get(   '/admin/types',                             [Types::class, 'adminList']);
$routes->get(   '/admin/types/add',                         [Types::class, 'form/add']);
$routes->get(   '/admin/types/edit/(:num)',                 [Types::class, 'form/edit/$1/$2']);
$routes->post(  '/admin/types/form-processing',             [Types::class, 'formProcessing']);
$routes->get(   '/admin/types/delete/(:num)',               [[Types::class, 'delete'],    "$1"]);
$routes->post(  '/admin/types/change-visible/',             [Types::class, 'changeVisible']);
$routes->post(  '/admin/types/set-filter',                  [Types::class, 'setFilter']);

/** Admin: Publications */
$routes->get(   '/admin/publications/',                     [Publications::class, 'adminList']);
$routes->get(   '/admin/publications/page-(:num)/',         [Publications::class, 'adminList']);
$routes->get(   '/admin/publications/add',                  [Publications::class, 'form/add']);
$routes->post(  '/admin/publications/form-processing',      [Publications::class, 'formProcessing']);
$routes->get(   '/admin/publications/edit/(:num)',          [Publications::class, 'form/edit']);
$routes->get(   '/admin/publications/delete/(:num)',        [Publications::class, 'delete']);
$routes->post(  '/admin/publications/change-visible',       [Publications::class, 'changeVisible']);

/** Public: Publications */
$routes->get(   'publications',                             [Publications::class, 'list']);
$routes->get(   'publications/page-(:num)',                 [Publications::class, 'list']);
$routes->get(   'publications/(:segment)-(:segment)/',      [Publications::class, 'setPublicSort']);
$routes->get(   'publication/(:num)',                       [Publications::class, 'publication']);
$routes->post(  'search-publications',                      [Publications::class, 'setPublicSearch']);
$routes->get(   'correct/',                                 [Publications::class, 'correct']);
$routes->get(   'set-(:segment)/(:num)',                    [[Publications::class, 'publicFilter'], "true/$1/$2"]);

/** Public: Section */
$routes->get(   'section/(:num)',                           [Sections::class, 'showSection']);
$routes->get(   'section/(:num)/page-(:num)/',              [Sections::class, 'showSection']);
$routes->get(   'section/(:num)/(:segment)-(:segment)/',    [Sections::class, 'setSort']);
$routes->get(   'sections',                                 [Sections::class, 'showSections']);

/** PUBLIC: PAGES */
//$routes->get(   '/',                                           [PublicController::class, 'MainList']);
$routes->get(   '/',                                        [PublicController::class, 'index']);
$routes->get(   '/sections/(:num)',                         [PublicController::class, 'ChapterList']);
$routes->get(   '/sections/(:num)/page-(:num)',             [PublicController::class, 'ChapterList']);
$routes->get(   '/browse/(:segment)',                       [PublicController::class, 'browse/$1']);
$routes->post(  '/browse/(:segment)/set-filter',            [PublicController::class, 'setFilter/$1']);

/** Downloader */
$routes->get(   '/download/(:segment)/(:segment)',          [Download::class, 'downloadPdf/$1/$2']);
$routes->get(   '/link/',                                   [Download::class, 'readPDF']);

/** Public: References (Tags,Authors,Advisors) */
$routes->get(   'show/(:segment)/',                         [References::class, "list"]);
$routes->get(   'show/(:segment)/page-(:num)',              [References::class, "list"]);
$routes->get(   'show/tag/',                                [References::class, "publications"]);
$routes->get(   '(:segment)/letter/(:segment)',             [References::class, "showByLetter"]);
$routes->post(  '(:segment)/search',                        [References::class, "searchByType"]);
$routes->get(   'show/(:segment)/(:segment)-(:segment)/',   [References::class, "setSort"]);

/** Other */
$routes->get(   '/test',                                    [Sections::class, 'test']);
$routes->get(   '/(:any)',                                  [PublicController::class, 'MainList']);
