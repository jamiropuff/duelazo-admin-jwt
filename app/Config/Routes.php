<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::dashboard');

// Login
$routes->post('/login', 'UserController::login');
$routes->get('/logout', 'UserController::logout');

// Users
$routes->get('/users', 'UserController::users');
$routes->post('/users/search', 'UserController::search');
$routes->post('/users/update', 'UserController::update');
$routes->post('/users/delete', 'UserController::delete');
$routes->get('/users/verify', 'UserController::users_verifictions');
$routes->post('/users/save_verify', 'UserController::save_verifiction');
$routes->post('/users/store_transactions', 'UserController::store_transactions');
$routes->post('/users/winners_records', 'UserController::winners_records');

// Balance
$routes->get('/balance', 'BalanceController::balance');
$routes->post('/balance/withdrawals', 'BalanceController::withdrawals');

// Matches
$routes->get('/matches/resources', 'MatchesController::resources');
$routes->get('/matches/leagues', 'MatchesController::leagues');
$routes->get('/matches', 'MatchesController::matches');
$routes->post('/matches/save', 'MatchesController::save');
$routes->post('/matches/update', 'MatchesController::update');
$routes->post('/matches/delete', 'MatchesController::delete');
$routes->get('/matches/leagues', 'MatchesController::leagues');
$routes->get('/matches/teams', 'MatchesController::teams');
$routes->get('/matches/date', 'MatchesController::find_date');
$routes->get('/matches/league', 'MatchesController::find_league');

// Brackets
$routes->get('/brackets', 'BracketsController::brackets');
$routes->get('/brackets/list', 'BracketsController::list_brackets');
$routes->get('/brackets/list_phase1/(:num)', 'BracketsController::list_phase1/$1');
$routes->post('/brackets/save', 'BracketsController::save');
$routes->post('/brackets/update', 'BracketsController::update');
$routes->post('/brackets/delete', 'BracketsController::delete');
$routes->get('/brackets/phase2/(:num)', 'BracketsController::phase2/$1');
$routes->post('/brackets/phase2_save', 'BracketsController::phase2_save');
$routes->post('/brackets/remove_match', 'BracketsController::remove_match');
$routes->get('/brackets/file/(:num)', 'BracketsController::getfile/$1');
$routes->get('/brackets/leagues', 'BracketsController::leagues');
$routes->get('/brackets/leagues/(:num)', 'BracketsController::leagues/$1');
$routes->post('/brackets/status', 'BracketsController::status');

// Pools
$routes->get('/pools', 'PoolsController::pools');
$routes->get('/pools/list', 'PoolsController::list');
$routes->get('/pools/file/(:num)', 'PoolsController::getfile/$1');
$routes->post('/pools/save', 'PoolsController::save');
$routes->post('/pools/update', 'PoolsController::update');
$routes->post('/pools/delete', 'PoolsController::delete');
$routes->post('/pools/remove_match', 'PoolsController::remove_match');
$routes->get('/pools/list_pools/(:num)', 'PoolsController::list_pools/$1');
$routes->post('/pools/tiebreakers', 'PoolsController::tiebreakers');
$routes->post('/pools/delete_tiebreaker', 'PoolsController::delete_tiebreaker');
$routes->post('/pools/sport_pool', 'PoolsController::sport_pool');
$routes->post('/pools/status', 'PoolsController::status');

// Cumulative Pools
$routes->post('/pools/phases', 'PoolsController::phases');
$routes->post('/pools/phases_add', 'PoolsController::phases_add');
$routes->get('/pools/list_phases', 'PoolsController::list_phases');
$routes->post('/pools/update_phase', 'PoolsController::update_phase');

// Streaks
$routes->get('/streaks', 'StreaksController::streaks');
$routes->post('/streaks/save', 'StreaksController::save');
$routes->get('/streaks/templates/(:num)', 'StreaksController::templates/$1');
$routes->post('/streaks/save_templates', 'StreaksController::save_templates');
$routes->get('/streaks/list/(:num)', 'StreaksController::list/$1');
$routes->post('/streaks/list_streak', 'StreaksController::list_streak');
$routes->post('/streaks/update_streaks', 'StreaksController::update_streaks');
$routes->post('/streaks/personalized_streaks', 'StreaksController::personalized_streaks');
$routes->post('/streaks/update_tournament', 'StreaksController::update_tournament');
$routes->post('/streaks/delete_tournament', 'StreaksController::delete_tournament');
$routes->post('/streaks/delete_streak', 'StreaksController::delete_streak');

//$routes->get('/login/pools', 'dashboard\LoginController::pools');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
