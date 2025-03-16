<?php

// Middleware helper function
function middleware($middleware, $callback)
{
    return function () use ($middleware, $callback) {
        // 'auth_student' middleware: Check if the user is logged in as a student.
        if ($middleware === 'auth_student') {
            if (!auth()->isStudent()) {
                header("Location: " . gotolink('login'));
                exit;
            }
        }
        // 'auth_admin' middleware: Check if the user is logged in and is an admin.
        if ($middleware === 'auth_admin') {
            if (!auth()->isAdmin()) {
                header("Location: " . gotolink('home'));
                exit;
            }
        }
        // If all checks pass, call the route callback.
        $callback();
    };
}

use App\Controllers\AuthController;
use App\Controllers\AdminController;
use App\Controllers\StudentController;

// Define routes
$routes = [
    // Public routes
    'home'     => function () {
        page('home');
    },
    'login'    => function () {
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            page('auth/login');
        }
    },
    'register' => function () {
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            page('auth/register');
        }
    },
    'logout'   => function () {
        session_destroy();
        header("Location: " . gotolink('home'));
        exit;
    },

    // Student routes (require student authentication)
    'student.home' => middleware('auth_student', function () {
        $controller = new StudentController();
        $controller->index();
    }),
    'student.trips' => middleware('auth_student', function () {
        $controller = new StudentController();
        $controller->viewTrips();
    }),
    'student.book_trip' => middleware('auth_student', function () {
        $controller = new StudentController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->bookTrip();
        } else {
            // Display the trip booking form (adjust as needed)
            page('student/book_trip');
        }
    }),

    // Admin routes (require admin authentication)
    'admin.home' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->index();
    }),
    'admin.drivers' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->manageDrivers();
    }),
    'admin.buses' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->manageBuses();
    }),
    'admin.routes' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->manageRoutes();
    }),
    'admin.trips' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->manageTrips();
    }),
    'admin.bookings' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->manageBookings();
    }),
];

$route = isset($_GET['route']) ? $_GET['route'] : 'home';
if (isset($routes[$route]) && is_callable($routes[$route])) {
    $routes[$route]();
} else {
    echo "المسار '{$route}' غير موجود.";
}
