<?php
use App\Tables\Booking;
use App\Tables\Trip;

$title = 'رحلاتي المحجوزة - لوحة الطالب';
$active = 'student.booked_trips';
ob_start();

// Retrieve bookings for the authenticated student
// Assuming auth()->student()->id returns the current student's ID.
$bookings = Booking::where(['student_id' => auth()->student()->id]);
?>
<div class="mb-6">
  <h1 class="text-3xl font-bold text-teal-700 mb-4 text-center">رحلاتي المحجوزة</h1>
  <p class="text-center text-gray-700 mb-8">راجع رحلاتك المحجوزة أدناه.</p>
</div>
<div class="overflow-x-auto bg-white rounded-lg shadow">
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-teal-50">
      <tr>
        <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الرقم</th>
        <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">تاريخ الرحلة</th>
        <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">وقت الرحلة</th>
        <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">حالة الحجز</th>
        <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">تاريخ الحجز</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
      <?php if (!empty($bookings)): ?>
        <?php foreach ($bookings as $booking): ?>
          <?php $trip = Trip::find($booking->trip_id); ?>
          <tr>
            <td class="px-4 py-2 text-right"><?= htmlspecialchars($booking->id); ?></td>
            <td class="px-4 py-2 text-right"><?= $trip ? htmlspecialchars($trip->trip_date) : 'غير متوفر'; ?></td>
            <td class="px-4 py-2 text-right"><?= $trip ? htmlspecialchars($trip->trip_time) : 'غير متوفر'; ?></td>
            <td class="px-4 py-2 text-right"><?= htmlspecialchars($booking->booking_status); ?></td>
            <td class="px-4 py-2 text-right"><?= htmlspecialchars($booking->booking_date); ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="px-4 py-2 text-center text-gray-600">لم تقم بحجز أي رحلة بعد.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?php
$content = ob_get_clean();
student_layout($content, ['title' => $title, 'active' => $active]);
?>
