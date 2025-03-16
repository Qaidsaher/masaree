<?php
namespace App\Controllers;

class StudentController {
    public function index() {
        // Display student dashboard
        page('student/dashboard', ['title' => 'لوحة تحكم الطالب']);
    }

    public function viewTrips() {
        $trips = \App\Tables\Trip::all();
        page('student/trips', ['trips' => $trips]);
    }

    public function bookTrip() {
        $tripId = $_POST['trip_id'] ?? null;
        if ($tripId) {
            $bookingData = [
                'student_id'   => $_SESSION['user']['id'],
                'trip_id'      => $tripId,
                // booking_date and booking_status can be set in the model defaults or here
            ];
            $booking = new \App\Tables\Booking($bookingData);
            if ($booking->save()) {
                header("Location: " . gotolink('student.home'));
                exit;
            }
        }
        echo "Booking failed. Please try again.";
    }
}
