<?php

use App\Tables\Trip;
use App\Tables\Booking;

$title = 'حجز الرحلة - لوحة الطالب';
$active = 'student.trips';
ob_start();

// Retrieve the trip id from either POST or GET parameters
$tripId = $_POST['id'] ?? $_GET['id'] ?? null;
if (!$tripId) {
    $_SESSION['error'] = "لم يتم تحديد الرحلة.";
    header("Location: " . gotolink('student.trips'));
    exit;
}

// Retrieve the selected trip details
$trip = Trip::find($tripId);
if (!$trip) {
    $_SESSION['error'] = "الرحلة غير موجودة.";
    header("Location: " . gotolink('student.trips'));
    exit;
}

// Process the booking form when submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingDate = trim($_POST['booking_date'] ?? date('Y-m-d'));

    // Check if a booking for the same trip and date already exists for this student.
    $existingBookings = Booking::where([
        'student_id'   => auth()->student()->id,
        'trip_id'      => $trip->id,
        'booking_date' => $bookingDate
    ]);

    if (!empty($existingBookings)) {
        $_SESSION['error'] = "لقد قمت بحجز هذه الرحلة لهذا اليوم بالفعل.";
        header("Location: " . gotolink('student.trips'));
        exit;
    }

    $data = [
        'student_id'    => auth()->student()->id,
        'trip_id'       => $trip->id,
        'booking_date'  => $bookingDate,
       
    ];

    $booking = new Booking($data);
    if ($booking->save()) {
        $_SESSION['success'] = "تم حجز الرحلة بنجاح";
    } else {
        $_SESSION['error'] = "فشل في حجز الرحلة";
    }
    header("Location: " . gotolink('student.trips'));
    exit;
}
?>

<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden">
    <!-- Card Header with Gradient & Icon -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-700 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <i class="fa-solid fa-bus text-white text-2xl"></i>
            <h1 class="text-2xl text-white font-bold">حجز الرحلة</h1>
        </div>
        <span class="text-white text-sm font-medium tracking-wide">
            رحلة #<?= htmlspecialchars($trip->id); ?>
        </span>
    </div>

    <!-- Trip Details -->
    <div class="p-6 border-b border-gray-200">
        <div class="space-y-2">
            <p class="text-gray-700 flex items-center">
                <i class="fa-regular fa-calendar mr-2"></i>
                <span class="font-semibold">التاريخ:</span>
                <span class="mr-1"><?= htmlspecialchars($trip->trip_date); ?></span>
            </p>
            <p class="text-gray-700 flex items-center">
                <i class="fa-regular fa-clock mr-2"></i>
                <span class="font-semibold">الوقت:</span>
                <span class="mr-1"><?= htmlspecialchars($trip->trip_time); ?></span>
            </p>
            <p class="text-gray-700 flex items-center">
                <i class="fa-solid fa-info-circle mr-2"></i>
                <span class="font-semibold">الحالة:</span>
                <span class="mr-1"><?= htmlspecialchars($trip->status); ?></span>
            </p>
            <!-- Additional details (bus, route, etc.) can be added here if needed -->
        </div>
    </div>

    <!-- Booking Form -->
    <div class="p-6">
        <form action="<?= gotolink('student.book_trip', ['id' => $trip->id]); ?>" method="POST" class="space-y-6">
            <div>
                <label for="booking_date" class="block text-teal-700 font-semibold mb-1">
                    <i class="fa-regular fa-calendar-check mx-2"></i>تاريخ الحجز
                </label>
                <input type="date" id="booking_date" name="booking_date" value="<?= date('Y-m-d'); ?>" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-600">
            </div>
            <div class="flex justify-between gap-x-8">
                <a href="<?= gotolink('student.trips'); ?>"
                    class="w-1/2 text-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 rounded-lg transition-colors duration-300">
                    إلغاء
                </a>
                <button type="submit"
                    class="w-1/2 ml-4 text-center bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 rounded-lg transition-colors duration-300">
                    تأكيد الحجز
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
student_layout($content, ['title' => $title, 'active' => $active]);
?>