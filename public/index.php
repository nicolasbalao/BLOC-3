<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

use App\Autloader;
use App\Controllers\AuthController;
use App\Controllers\HomePageController;
use App\Routes\Router;
use App\Utils\SessionHelper;

/**
 * Import namespace
 */



// GLOBAL VARIABLE
define('ROOT', dirname(__DIR__));
define('APP_DIR', dirname(__DIR__) . "/App/");
define('VIEWS_DIR', dirname(__DIR__) . "/App/Views/");
define('ASSETS_DIR', dirname(__DIR__) . "/public/assets/");
define('PUBLIC_DIR', dirname(__DIR__) . "/public/");

// Require the autloader
require_once "../App/Autoloader.php";


// ------------------ ROUTING ------------------//
$router = new Router();

// AUTH
$router->get("/login", [AuthController::class, "loginPage"]);
$router->post("/login", [AuthController::class, "login"]);
$router->get("/register", [AuthController::class, "registerPage"]);
$router->post("/register", [AuthController::class, "register"]);
$router->get('/logout', [AuthController::class, "logout"]);

// HOMEPAGE
$router->get("/", [HomePageController::class, "index"]);
$router->post("/", [HomePageController::class, "create"]);
$router->put("/{id}", [HomePageController::class, "update"]);
$router->delete("/{id}", [HomePageController::class, "delete"]);





// Resolve URI
$router->handleRequest();
