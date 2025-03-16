<?php
namespace App\Controllers;
use App\Tables\Driver;
class AdminController {
    public function index() {
        // Display admin dashboard
        page('admin/dashboard', ['title' => 'لوحة تحكم الادمن']);
    }

    public function manageDrivers() {
        $drivers = Driver::all();
        page('admin/drivers', ['drivers' => $drivers]);
    }

    public function manageBuses() {
        $buses = \App\Tables\Bus::all();
        page('admin/buses', ['buses' => $buses]);
    }

    public function manageRoutes() {
        $routes = \App\Tables\Route::all();
        page('admin/routes', ['routes' => $routes]);
    }

    public function manageTrips() {
        $trips = \App\Tables\Trip::all();
        page('admin/trips', ['trips' => $trips]);
    }

    public function manageBookings() {
        $bookings = \App\Tables\Booking::all();
        page('admin/bookings', ['bookings' => $bookings]);
    }
}
