<?php
namespace App\Controllers;

use App\Tables\Trip;
use App\Tables\Booking;
use App\Tables\Report;
use App\Tables\RequestPoint;
use App\Tables\Challenge;

class StudentController {

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process form submission
            $tripId = $_POST['trip_id'] ?? null;
            if (!$tripId) {
                $_SESSION['error'] = "لم يتم تحديد الرحلة.";
                header("Location: " . gotolink('student.trips'));
                exit;
            }
            // Prepare booking data
            $data = [
                'student_id'   => auth()->student()->id,
                'trip_id'      => $tripId,
                'booking_date' => trim($_POST['booking_date'] ?? date('Y-m-d')),
                // booking_status will be set by default (e.g., "قيد الانتظار") in the model
            ];
            $booking = new Booking($data);
            if ($booking->save()) {
                $_SESSION['success'] = "تم حجز الرحلة بنجاح";
            } else {
                $_SESSION['error'] = "فشل حجز الرحلة";
            }
            header("Location: " . gotolink('student.trips'));
            exit;
        } else {
            // GET: Display the booking form
            page('student/book_trip');
        }
    }

    /**
     * Show a list of the student's booked trips.
     */
    public function bookedTrips()
    {
        page('student/booked_trips');
    }

    /**
     * Show the student's reports.
     */
    public function reports()
    {
        page('student/reports');
    }

   

    /**
     * Show the student's requests.
     */
    public function requests()
    {
        page('student/requests');
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
            // Process profile update, then redirect.
            // (Your update logic goes here)
            header("Location: " . gotolink('student.profile'));
            exit;
        } else {
            page('student/edit_profile');
        }
    }

    /**
     * Show the student's settings.
     */
    public function settings()
    {
        page('student/settings');
    }

    /**
     * Delete the student's account.
     */
    public function deleteAccount()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process account deletion (call your auth helper or model method)
            // Then redirect to logout
            header("Location: " . gotolink('logout'));
            exit;
        } else {
            page('student/delete_account');
        }
    }
}
