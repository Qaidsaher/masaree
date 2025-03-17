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
        page('home'); // Adjust as needed
    },
    'login'    => function () {
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if($_POST['form_type']=="register")
            {
                $controller->register();
            }
            if($_POST['form_type']=="login")
            {
                $controller->login();
            }
            
        } else {
            page('auth/login');
        }
    },
    'register' => function () {
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            page('auth/login');
        }
    },
    'logout'   => function () {
        session_destroy();
        header("Location: " . gotolink('home'));
        exit;
    },

    // Admin routes (require admin authentication)
    'admin.home' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->index();
    }),
    'admin.students' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->manageStudents();
    }),
    'admin.students.delete' => middleware('auth_admin', function () {
        $id = $_GET['id'] ?? null;
        $controller = new AdminController();
        $controller->deleteStudent($id);
    }),
    'admin.admins' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->manageAdmins();
    }),
    'admin.admins.delete' => middleware('auth_admin', function () {
        $id = $_GET['id'] ?? null;
        $controller = new AdminController();
        $controller->deleteAdmin($id);
    }),
    'admin.drivers' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->manageDrivers();
    }),
    'admin.drivers.delete' => middleware('auth_admin', function () {
        $id = $_GET['id'] ?? null;
        $controller = new AdminController();
        $controller->deleteDriver($id);
    }),
    'admin.buses' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->manageBuses();
    }),
    'admin.buses.delete' => middleware('auth_admin', function () {
        $id = $_GET['id'] ?? null;
        $controller = new AdminController();
        $controller->deleteBus($id);
    }),
    'admin.routes' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->manageRoutes();
    }),
    'admin.routes.delete' => middleware('auth_admin', function () {
        $id = $_GET['id'] ?? null;
        $controller = new AdminController();
        $controller->deleteRoute($id);
    }),
    'admin.trips' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->manageTrips();
    }),
    'admin.trips.delete' => middleware('auth_admin', function () {
        $id = $_GET['id'] ?? null;
        $controller = new AdminController();
        $controller->deleteTrip($id);
    }),
    'admin.bookings' => middleware('auth_admin', function () {
        $controller = new AdminController();
        $controller->manageBookings();
    }),
    'admin.bookings.delete' => middleware('auth_admin', function () {
        $id = $_GET['id'] ?? null;
        $controller = new AdminController();
        $controller->deleteBooking($id);
    }),
    'student.home'    => function() {
        $controller = new StudentController();
        $controller->dashboard();
    },
    'student.trips'        => function() {
        $controller = new StudentController();
        $controller->trips();
    },
    'student.book_trip'    => function() {
        $controller = new StudentController();
        $controller->bookTrip();
    },
    'student.booked_trips' => function() {
        $controller = new StudentController();
        $controller->bookedTrips();
    },
  
    'student.profile'      => function() {
        $controller = new StudentController();
        $controller->profile();
    },
    'student.edit_profile' => function() {
        $controller = new StudentController();
        $controller->editProfile();
    },
   
    'student.delete_account' => function() {
        $controller = new StudentController();
        $controller->deleteAccount();
    }
];

$route = isset($_GET['goto']) ? $_GET['goto'] : 'home';
if (isset($routes[$route]) && is_callable($routes[$route])) {
    $routes[$route]();
} else {
    echo "المسار '{$route}' غير موجود.";
}
