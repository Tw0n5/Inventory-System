<?php
// start session management for tracking status if needed later
    session_start();
    
    // ⚡ ADD THESE 3 LINES AT the VERY TOP OF index.php:
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

//automatically require system files
    require_once 'Router.php';
    require_once 'controllers/InventoryController.php';
    require_once 'models/InventoryModel.php';

// //Instantiate the custom router engine
   $router= new Router();

// //Define system routes
// // //web page layouts
   $router->add('GET', '/', 'InventoryController@getLoginPage');
$router->add('GET', '/dashboard', 'InventoryController@getDashboardPage'); // ✅ FIXED: Changed '/' to '/dashboard'

// // //API Datas streams (handles authentication & data fetch via JS)
     $router->add('POST', '/api/login', 'InventoryController@loginProcess');
    $router->add('GET', '/api/inventory', 'InventoryController@getInventoryData');

// //resolve the incoming client request
   $router->dispatch();

?>