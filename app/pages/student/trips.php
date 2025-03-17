<?php
use App\Tables\Trip;

// Set page variables
$title = 'رحلات متاحة - لوحة الطالب';
$active = 'student.trips';
ob_start();

// Retrieve available trips (you can add conditions to show only upcoming trips, etc.)
$trips = Trip::all();
?>
<div class="mb-6">
  <h1 class="text-3xl font-bold text-teal-700 mb-4 text-center">رحلات متاحة</h1>
  <p class="text-center text-gray-700 mb-8">اختر الرحلة التي تريد حجزها.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  <?php if (!empty($trips)): ?>
    <?php foreach ($trips as $trip): ?>
      <div class="bg-white rounded-lg shadow p-6 flex flex-col justify-between">
        <div>
          <h2 class="text-xl font-bold text-teal-700 mb-2">رحلة #<?= htmlspecialchars($trip->id); ?></h2>
          <p class="text-gray-600">
            <span class="font-semibold">التاريخ:</span> <?= htmlspecialchars($trip->trip_date); ?>
          </p>
          <p class="text-gray-600">
            <span class="font-semibold">الوقت:</span> <?= htmlspecialchars($trip->trip_time); ?>
          </p>
          <p class="text-gray-600">
            <span class="font-semibold">الحالة:</span> <?= htmlspecialchars($trip->status); ?>
          </p>
          <!-- Add additional trip info as needed (e.g., bus, route) -->
        </div>
        <div class="mt-4">
          <a href="<?= gotolink('student.book_trip', ['id' => $trip->id]); ?>"
             class="block text-center bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
            حجز الرحلة
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p class="col-span-full text-center text-gray-600">لا توجد رحلات متاحة حالياً.</p>
  <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
student_layout($content, ['title' => $title, 'active' => $active]);
?>
