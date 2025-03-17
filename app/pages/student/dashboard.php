<?php
$title = 'لوحة التحكم - لوحة الطالب';
$active = 'student.dashboard';
ob_start();

$studentId = auth()->student()->id;

// Count all bookings for the current student.
$bookedCount = count(\App\Tables\Booking::where(['student_id' => $studentId]));

// Determine an upcoming trip from the student's bookings.
$upcomingTrip = null;
$bookings = \App\Tables\Booking::where(['student_id' => $studentId]);
foreach ($bookings as $booking) {
    $trip = \App\Tables\Trip::find($booking->trip_id);
    if ($trip && strtotime($trip->trip_date) >= strtotime(date('Y-m-d'))) {
        // Choose the earliest upcoming trip.
        if (!$upcomingTrip || strtotime($trip->trip_date) < strtotime($upcomingTrip->trip_date)) {
            $upcomingTrip = $trip;
        }
    }
}
?>

<div class="max-w-7xl mx-auto space-y-8">
  <!-- Welcome Section -->
  <div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold text-teal-700">مرحباً <?= htmlspecialchars(auth()->student()->name); ?>!</h1>
    <p class="text-gray-600 mt-2">استعرض معلومات رحلاتك المحجوزة ورحلتك القادمة.</p>
  </div>
  
  <!-- Dashboard Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Booked Trips Card -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center">
      <i class="fas fa-bus text-teal-600 text-4xl mr-4"></i>
      <div>
        <p class="text-gray-600">عدد الرحلات المحجوزة</p>
        <h2 class="text-3xl font-bold text-teal-700"><?= $bookedCount; ?></h2>
      </div>
    </div>
    <!-- Upcoming Trip Card -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center">
      <i class="fas fa-calendar-alt text-teal-600 text-4xl mr-4"></i>
      <div>
        <p class="text-gray-600">الرحلة القادمة</p>
        <?php if ($upcomingTrip): ?>
          <h2 class="text-2xl font-bold text-teal-700"><?= htmlspecialchars($upcomingTrip->trip_date) . ' ' . htmlspecialchars($upcomingTrip->trip_time); ?></h2>
        <?php else: ?>
          <h2 class="text-2xl font-bold text-teal-700">لا توجد رحلة قادمة</h2>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
student_layout($content, ['title' => $title, 'active' => $active]);
?>
