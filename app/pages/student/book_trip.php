<?php
use App\Tables\Trip;
use App\Tables\Booking;

$title = 'حجز الرحلة - لوحة الطالب';
$active = 'student.trips';
ob_start();

// Get the trip id from GET parameters
$tripId = $_GET['id'] ?? null;
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
    // Get the booking date from POST (default to today if not provided)
    $bookingDate = trim($_POST['booking_date'] ?? date('Y-m-d'));

    // Create a new booking with default status (e.g. "قيد الانتظار")
    $data = [
        'student_id'   => auth()->student()->id,
        'trip_id'      => $trip->id,
        'booking_date' => $bookingDate,
        // The booking_status can be set by the model as a default ("قيد الانتظار")
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

<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold text-teal-700 mb-4 text-center">حجز الرحلة</h1>
    <div class="mb-6 border-b pb-4">
        <p class="text-gray-700"><span class="font-semibold">رقم الرحلة:</span> <?= htmlspecialchars($trip->id); ?></p>
        <p class="text-gray-700"><span class="font-semibold">التاريخ:</span> <?= htmlspecialchars($trip->trip_date); ?></p>
        <p class="text-gray-700"><span class="font-semibold">الوقت:</span> <?= htmlspecialchars($trip->trip_time); ?></p>
        <p class="text-gray-700"><span class="font-semibold">الحالة:</span> <?= htmlspecialchars($trip->status); ?></p>
        <!-- You can add additional details (bus, route info) if needed -->
    </div>
    <form action="<?= gotolink('student.book_trip', ['id' => $trip->id]); ?>" method="POST" class="space-y-4">
        <div>
            <label for="booking_date" class="block text-teal-700 font-semibold mb-1">تاريخ الحجز</label>
            <input type="date" id="booking_date" name="booking_date" value="<?= date('Y-m-d'); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
        </div>
        <div class="flex justify-between">
            <a href="<?= gotolink('student.trips'); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">إلغاء</a>
            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">تأكيد الحجز</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
student_layout($content, ['title' => $title, 'active' => $active]);
?>
