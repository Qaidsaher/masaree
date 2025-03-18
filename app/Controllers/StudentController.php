<?php

namespace App\Controllers;

use App\Tables\Trip;
use App\Tables\Booking;
use App\Tables\Report;
use App\Tables\RequestPoint;
use App\Tables\Challenge;

class StudentController
{

    /**
     * Show the student dashboard.
     */
    public function dashboard()
    {
        // Here you might gather dashboard-specific data.
        // Then include a view file (or use a helper function like page())
        page('student/dashboard');
    }

    /**
     * Show the list of available trips.
     */
    public function trips()
    {
        page('student/trips');
    }

    /**
     * Process a booking for a selected trip.
     * If GET, show the booking form; if POST, process the booking.
     */
    public function bookTrip()
    {

        page('student/book_trip');
    }

    /**
     * Show a list of the student's booked trips.
     */
    public function bookedTrips()
    {
        
        page('student/booked_trips');
    }



    /**
     * Show available challenges.
     */
    public function challenges()
    {
        page('student/challenges');
    }

    /**
     * Show the student's profile.
     */
    public function profile()
    {
        page('student/profile');
    }

    /**
     * Edit the student's profile.
     */
    public function editProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the current student from your authentication helper.
            $student = auth()->student();
            echo $student->name;
            if (!$student) {
                $_SESSION['error'] = "المستخدم غير موجود.";
                header("Location: " . gotolink('login'));
                exit;
            }

            // Sanitize and update student data.
            $data = [
                'name' => trim($_POST['fullName'] ?? ''),
                'email'    => trim($_POST['email'] ?? ''),
                'phone'    => trim($_POST['phone'] ?? ''),
                'address'  => trim($_POST['address'] ?? ''),
                'district' => trim($_POST['district'] ?? ''),
                'street'   => trim($_POST['street'] ?? ''),
            ];

            // Check required fields.
            foreach ($data as $field => $value) {
                if ($value === '') {
                    $_SESSION['error'] = "جميع الحقول مطلوبة.";
                    header("Location: " . gotolink('student.edit_profile'));
                    exit;
                }
            }

            // Update properties using fill (or set individually).
            $student->fill($data);

            // If password is provided, update it.
            if (!empty($_POST['password'])) {
                $student->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }

            // Attempt to save changes.
            if ($student->save()) {
                $_SESSION['success'] = "تم تحديث الملف الشخصي بنجاح";
            } else {
                $_SESSION['error'] = "فشل تحديث الملف الشخصي";
            }
            header("Location: " . gotolink('student.profile'));
            exit;
        } else {
            // If not POST, show the edit profile form.
            page('student/edit_profile');
        }
    }

    public function deleteAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the authenticated student.
            $student = auth()->student();
            if (!$student) {
                $_SESSION['error'] = "المستخدم غير موجود.";
                header("Location: " . gotolink('login'));
                exit;
            }
            // Attempt to delete the account.
            if ($student->delete()) {
                $_SESSION['success'] = "تم حذف الحساب بنجاح";
            } else {
                $_SESSION['error'] = "فشل حذف الحساب";
            }
            header("Location: " . gotolink('logout'));
            exit;
        } else {
            // If not POST, show a confirmation page.
            page('student/delete_account');
        }
    }
}
