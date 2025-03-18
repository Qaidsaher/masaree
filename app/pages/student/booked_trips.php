<?php
use App\Tables\Booking;

$title = 'رحلاتي المحجوزة - لوحة الطالب';
$active = 'student.booked_trips';
ob_start();
// Process deletion if requested
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_GET['id'])) {
  $bookingId = $_GET['id'];
  $booking = Booking::find($bookingId);
  if ($booking && $booking->delete()) {
      $_SESSION['success'] = "تم حذف الحجز بنجاح";
  } else {
      $_SESSION['error'] = "فشل في حذف الحجز";
  }
  header("Location: " . gotolink('student.booked_trips'));
  exit;
}


// Retrieve bookings for the authenticated student
$bookings = Booking::where(['student_id' => auth()->student()->id]);
?>

<div class="max-w-5xl mx-auto py-10 px-4">
  <!-- Page Header -->
  <div class="mb-8 text-center">
    <h1 class="text-4xl font-bold text-teal-700">رحلاتي المحجوزة</h1>
    <p class="mt-2 text-lg text-gray-700">راجع رحلاتك المحجوزة أدناه.</p>
  </div>

  <!-- Table Container -->
  <div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gradient-to-r from-teal-500 to-teal-700 text-white">
        <tr>
          <th class="px-6 py-3 text-right text-sm font-semibold">الرقم</th>
          <th class="px-6 py-3 text-right text-sm font-semibold">تاريخ الرحلة</th>
          <th class="px-6 py-3 text-right text-sm font-semibold">وقت الرحلة</th>
          <th class="px-6 py-3 text-right text-sm font-semibold">من</th>
          <th class="px-6 py-3 text-right text-sm font-semibold">إلى</th>
          <th class="px-6 py-3 text-right text-sm font-semibold">حالة الحجز</th>
          <th class="px-6 py-3 text-right text-sm font-semibold">تاريخ الحجز</th>
          <th class="px-6 py-3 text-right text-sm font-semibold">الإجراءات</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <?php if (!empty($bookings)): ?>
          <?php foreach ($bookings as $booking): ?>
            <?php $trip = $booking->getTrip(); ?>
            <tr class="hover:bg-teal-50 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap text-right text-gray-700">
                <?= htmlspecialchars($booking->id); ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-gray-700">
                <?= $trip ? htmlspecialchars($trip->trip_date) : 'غير متوفر'; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-gray-700">
                <?= $trip ? htmlspecialchars($trip->trip_time) : 'غير متوفر'; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-gray-700">
                <?= $trip && !empty($trip->getRoute()->start_location) ? htmlspecialchars($trip->getRoute()->start_location) : 'غير محدد'; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-gray-700">
                <?= $trip && !empty($trip->getRoute()->end_location) ? htmlspecialchars($trip->getRoute()->end_location) : 'غير محدد'; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-gray-700 flex justify-end items-center space-x-2">
                <?php 
                  $status = $booking->booking_status;
                  if ($status === 'مؤكد'):
                ?>
                  <i class="fa-solid fa-circle-check text-green-500 mx-1"></i>
                  <span class="text-green-500">مؤكد</span>
                <?php elseif ($status === 'قيد الانتظار'): ?>
                  <i class="fa-solid fa-hourglass text-yellow-500 mx-1"></i>
                  <span class="text-yellow-500">قيد الانتظار</span>
                <?php else: ?>
                  <i class="fa-solid fa-circle-xmark text-red-500 mx-1"></i>
                  <span class="text-red-500">ملغى</span>
                <?php endif; ?>
                
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-gray-700">
                <?= htmlspecialchars($booking->booking_date); ?>
              </td>
              <!-- Actions Column: Delete Booking -->
              <td class="px-6 py-4 whitespace-nowrap text-right text-gray-700">
                <form action="<?= gotolink('student.booked_trips', ['id' => $booking->id]); ?>" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف الحجز؟');">
                <input type="hidden" name="action" value="delete">
                  <button type="submit" class="text-red-600 hover:text-red-800">
                    <i class="fa-solid fa-trash text-xl"></i>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="px-6 py-4 text-center text-gray-600">
              لم تقم بحجز أي رحلة بعد.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
$content = ob_get_clean();
student_layout($content, ['title' => $title, 'active' => $active]);
?>
