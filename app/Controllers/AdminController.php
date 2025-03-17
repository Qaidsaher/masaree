<?php

namespace App\Controllers;

use App\Tables\Student;
use App\Tables\Admin;
use App\Tables\Driver;
use App\Tables\Bus;
use App\Tables\Route;
use App\Tables\Trip;
use App\Tables\Booking;

class AdminController
{
    public function index()
    {
        // Display admin dashboard
        page('admin/dashboard', ['title' => 'لوحة تحكم الادمن']);
    }

    public function manageStudents()
    {
        $students = Student::all();
        page('admin/students', data: ['students' => $students]);
    }
    public function manageAdmins() {
        $admins = Admin::all();
        page('admin/admins', data: ['admins' => $admins]);

    }
    public function manageDrivers()
    {
        $drivers = Driver::all();
        page('admin/drivers', ['drivers' => $drivers]);
    }

    public function manageBuses()
    {
        $buses = \App\Tables\Bus::all();
        page('admin/buses', ['buses' => $buses]);
    }

    public function manageRoutes()
    {
        $routes = \App\Tables\Route::all();
        page('admin/routes', ['routes' => $routes]);
    }

    public function manageTrips()
    {
        $trips = \App\Tables\Trip::all();
        page('admin/trips', ['trips' => $trips]);
    }

    public function manageBookings()
    {
        $bookings = \App\Tables\Booking::all();
        page('admin/bookings', ['bookings' => $bookings]);
    }
    

    /**
     * Delete a student by ID.
     *
     * @param mixed $id
     */
    public function deleteStudent($id)
    {
        if ($id) {
            $student = Student::find($id);
            if ($student) {
                if ($student->delete()) {
                    $_SESSION['success'] = "تم حذف الطالب بنجاح";
                } else {
                    $_SESSION['error'] = "فشل حذف الطالب";
                }
            } else {
                $_SESSION['error'] = "الطالب غير موجود";
            }
        }
        header("Location: " . gotolink('admin.students'));
        exit;
    }

    /**
     * Delete an admin by ID.
     *
     * @param mixed $id
     */
    public function deleteAdmin($id)
    {
        if ($id) {
            $admin = Admin::find($id);
            if ($admin) {
                if ($admin->delete()) {
                    $_SESSION['success'] = "تم حذف المسؤول بنجاح";
                } else {
                    $_SESSION['error'] = "فشل حذف المسؤول";
                }
            } else {
                $_SESSION['error'] = "المسؤول غير موجود";
            }
        }
        header("Location: " . gotolink('admin.admins'));
        exit;
    }

    /**
     * Delete a driver by ID.
     *
     * @param mixed $id
     */
    public function deleteDriver($id)
    {
        if ($id) {
            $driver = Driver::find($id);
            if ($driver) {
                if ($driver->delete()) {
                    $_SESSION['success'] = "تم حذف السائق بنجاح";
                } else {
                    $_SESSION['error'] = "فشل حذف السائق";
                }
            } else {
                $_SESSION['error'] = "السائق غير موجود";
            }
        }
        header("Location: " . gotolink('admin.drivers'));
        exit;
    }

    /**
     * Delete a bus by ID.
     *
     * @param mixed $id
     */
    public function deleteBus($id)
    {
        if ($id) {
            $bus = Bus::find($id);
            if ($bus) {
                if ($bus->delete()) {
                    $_SESSION['success'] = "تم حذف الحافلة بنجاح";
                } else {
                    $_SESSION['error'] = "فشل حذف الحافلة";
                }
            } else {
                $_SESSION['error'] = "الحافلة غير موجودة";
            }
        }
        header("Location: " . gotolink('admin.buses'));
        exit;
    }

    /**
     * Delete a route by ID.
     *
     * @param mixed $id
     */
    public function deleteRoute($id)
    {
        if ($id) {
            $route = Route::find($id);
            if ($route) {
                if ($route->delete()) {
                    $_SESSION['success'] = "تم حذف الطريق بنجاح";
                } else {
                    $_SESSION['error'] = "فشل حذف الطريق";
                }
            } else {
                $_SESSION['error'] = "الطريق غير موجود";
            }
        }
        header("Location: " . gotolink('admin.routes'));
        exit;
    }

    /**
     * Delete a trip by ID.
     *
     * @param mixed $id
     */
    public function deleteTrip($id)
    {
        if ($id) {
            $trip = Trip::find($id);
            if ($trip) {
                if ($trip->delete()) {
                    $_SESSION['success'] = "تم حذف الرحلة بنجاح";
                } else {
                    $_SESSION['error'] = "فشل حذف الرحلة";
                }
            } else {
                $_SESSION['error'] = "الرحلة غير موجودة";
            }
        }
        header("Location: " . gotolink('admin.trips'));
        exit;
    }

    /**
     * Delete a booking by ID.
     *
     * @param mixed $id
     */
    public function deleteBooking($id)
    {
        if ($id) {
            $booking = Booking::find($id);
            if ($booking) {
                if ($booking->delete()) {
                    $_SESSION['success'] = "تم حذف الحجز بنجاح";
                } else {
                    $_SESSION['error'] = "فشل حذف الحجز";
                }
            } else {
                $_SESSION['error'] = "الحجز غير موجود";
            }
        }
        header("Location: " . gotolink('admin.bookings'));
        exit;
    }
    
}
