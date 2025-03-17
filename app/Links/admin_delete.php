<?php
// File: app/links/admin_delete.php

session_start(); // Ensure session is started

// Example: URL might be like: index.php?route=admin.students.delete&id=5
$route = $_GET['route'] ?? '';
$id = $_GET['id'] ?? null;

switch ($route) {
    case 'admin.students.delete':
        if ($id) {
            $student = \App\Tables\Student::find($id);
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
    
    case 'admin.admins.delete':
        if ($id) {
            $admin = \App\Tables\Admin::find($id);
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
    
    case 'admin.drivers.delete':
        if ($id) {
            $driver = \App\Tables\Driver::find($id);
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
    
    case 'admin.trips.delete':
        if ($id) {
            $trip = \App\Tables\Trip::find($id);
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
    
    case 'admin.routes.delete':
        if ($id) {
            $routeObj = \App\Tables\Route::find($id);
            if ($routeObj) {
                if ($routeObj->delete()) {
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
    
    case 'admin.buses.delete':
        if ($id) {
            $bus = \App\Tables\Bus::find($id);
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
    
    case 'admin.bookings.delete':
        if ($id) {
            $booking = \App\Tables\Booking::find($id);
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
    
    default:
        $_SESSION['error'] = "المسار غير معرف";
        header("Location: " . gotolink('admin.home'));
        exit;
}
