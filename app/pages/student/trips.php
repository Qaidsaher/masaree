<?php 
use App\Tables\Trip;

// Set page variables
$title = 'رحلات متاحة - لوحة الطالب';
$active = 'student.trips';
ob_start();

// Retrieve trips (with relationships as needed)
$trips = Trip::all();
?>


<div class="max-w-7xl mx-auto py-10 px-4">
  <!-- Page Header -->
  <div class="text-center mb-10">
    <h1 class="text-4xl font-bold text-teal-700">رحلات متاحة</h1>
    <p class="mt-2 text-lg text-gray-700">
      اختر الرحلة التي تريد حجزها، واستعرض تفاصيل الحافلة والطريق.
    </p>
  </div>
  
  <!-- Trips Grid -->
  <?php if (!empty($trips)): ?>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php foreach ($trips as $trip): ?>
      <?php 
        // Retrieve relationship details (adjust property names as available)
        $bus = $trip->getBus();     // e.g., may return an object with bus_number, bus_model, etc.
        $route = $trip->getRoute(); // e.g., may return an object with route_name, route_stops, etc.
        $bookings = $trip->getBookings(); // If needed for additional logic
        // Determine status badge color (teal for available, red for full)
        $statusBadgeColor = $trip->is_full ? "bg-red-500" : "bg-teal-500";
      ?>
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-1 transition-all duration-300 flex flex-col">
        <!-- Card Header -->
        <div class="bg-teal-600 px-6 py-4">
            <div class="flex justify-between items-center">
            <h2 class="text-xl text-white font-semibold">
              رحلة #<?= htmlspecialchars($trip->id); ?>
            </h2>
            <?php if ($trip->status === 'مجدول'): ?>
              <span class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded-full">
              مجدول
              </span>
            <?php elseif ($trip->status === 'مكتمل'): ?>
              <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">
              مكتمل
              </span>
            <?php elseif ($trip->status === 'ملغى'): ?>
              <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
              ملغى
              </span>
            <?php endif; ?>
            </div>
        </div>
        <!-- Card Content -->
        <div class="p-6 flex-grow space-y-3">
          <div class="flex justify-between">
            <p class="text-gray-700 flex items-center">
              <i class="fa-regular fa-calendar mr-2"></i>
              <span class="font-semibold mr-2">التاريخ:</span>
              <span class="mr-1"><?= htmlspecialchars($trip->trip_date); ?></span>
            </p>
            <p class="text-gray-700 flex items-center">
              <i class="fa-regular fa-clock mr-2"></i>
              <span class="font-semibold mr-2">الوقت:</span>
              <span class="mr-1"><?= htmlspecialchars($trip->trip_time); ?></span>
            </p>
          </div>
          <div class="flex justify-between">
            <p class="text-gray-700 flex items-center">
              <i class="fa-solid fa-users mr-2"></i>
              <span class="font-semibold mr-2">الحد الأقصى:</span>
              <span class="mr-1"><?= htmlspecialchars($trip->max_students); ?></span>
            </p>
            <p class="flex items-center">
              <?php if ($trip->is_full): ?>
              <span class="bg-red-500 text-white px-2 py-0.5 rounded-md font-semibold">ممتلئة</span>
              <?php else: ?>
              <span class="bg-green-500 text-white px-2 py-0.5 rounded-md font-semibold">متاحة</span>
              <?php endif; ?>
            </p>
          </div>
          
          <!-- Bus Info -->
          <?php if ($bus): ?>
          <div class="text-gray-700 flex items-center">
            <i class="fa-solid fa-bus mr-2"></i>
            <span class="font-semibold mr-2">الحافلة:</span>
            <span class="mr-1">
              <?= htmlspecialchars($bus->bus_number ?? 'غير محدد'); ?>
              <?php if (!empty($bus->getDriver()->name)): ?>
                (<?= htmlspecialchars($bus->getDriver()->name); ?>)
              <?php endif; ?>
            </span>
          </div>
          <?php endif; ?>
          <!-- Route Info -->
          <?php if ($route): ?>
          <div class="text-gray-700 flex items-center">
            <i class="fa-solid fa-road mr-2"></i>
            <span class="font-semibold mr-2">الطريق:</span>
            <span class="mr-1">
              <?= htmlspecialchars($route->start_location ?? 'غير محدد'); ?>
              <?php if (!empty($route->end_location)): ?>
                - <?= htmlspecialchars($route->end_location); ?>
              <?php endif; ?>
            </span>
          </div>
          <?php endif; ?>
        </div>
        <!-- Action Button -->
        <div class="px-6 pb-6">
          <?php if (!$trip->is_full): ?>
          <a
            href="<?= gotolink('student.book_trip', ['id' => $trip->id]); ?>"
            class="w-full inline-block text-center bg-teal-500 hover:bg-teal-700 text-white font-semibold py-3 rounded-full transition-colors duration-300"
          >
            <i class="fa-solid fa-ticket-alt mr-2"></i> حجز الرحلة
          </a>
          <?php else: ?>
          <span class="w-full inline-block text-center bg-gray-400 text-white font-semibold py-3 rounded-full">
            الرحلة ممتلئة
          </span>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
    <p class="text-center text-gray-700 text-xl">لا توجد رحلات متاحة حالياً.</p>
  <?php endif; ?>
</div>
<?php

$content = ob_get_clean();
student_layout($content, ['title' => $title, 'active' => $active]);
?>
