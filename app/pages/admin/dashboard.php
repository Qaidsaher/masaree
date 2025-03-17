<?php
$active = 'admin.home';
$title = 'الرئيسية - لوحة الإدارة';
ob_start();

// Retrieve data from Masaree models
$studentCount = count(\App\Tables\Student::all());
$driverCount  = count(\App\Tables\Driver::all());
$busCount     = count(\App\Tables\Bus::all());
$routeCount   = count(\App\Tables\Route::all());
$tripCount    = count(\App\Tables\Trip::all());
$bookingCount = count(\App\Tables\Booking::all());
$adminCount   = count(\App\Tables\Admin::all());

// For charts: Booking status breakdown
$pendingBookings   = count(array_filter(\App\Tables\Booking::all(), fn($b) => $b->booking_status === 'قيد الانتظار'));
$confirmedBookings = count(array_filter(\App\Tables\Booking::all(), fn($b) => $b->booking_status === 'مؤكد'));
$cancelledBookings = count(array_filter(\App\Tables\Booking::all(), fn($b) => $b->booking_status === 'ملغى'));

// Dummy data for monthly trips (replace with dynamic queries if available)
$months = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
$monthlyTrips = [5, 8, 12, 10, 15, 20, 18, 22, 19, 14, 9, 7];

// Retrieve recent bookings (last 5)
$allBookings = \App\Tables\Booking::all();
$recentBookings = array_slice($allBookings, -5);
?>

<!-- Chart Initialization Script -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Bar Chart: Overall Statistics
    const dashboardBarChartEl = document.getElementById('dashboardBarChart');
    if (dashboardBarChartEl) {
      const ctxBar = dashboardBarChartEl.getContext('2d');
      new Chart(ctxBar, {
        type: 'bar',
        data: {
          labels: ['الطلاب', 'السائقين', 'الحافلات', 'الطرق', 'الرحلات', 'الحجوزات', 'المسؤولين'],
          datasets: [{
            label: 'الإحصائيات',
            data: [<?= $studentCount; ?>, <?= $driverCount; ?>, <?= $busCount; ?>, <?= $routeCount; ?>, <?= $tripCount; ?>, <?= $bookingCount; ?>, <?= $adminCount; ?>],
            backgroundColor: [
              'rgba(16,185,129,0.8)',
              'rgba(5,150,105,0.8)',
              'rgba(16,185,129,0.8)',
              'rgba(5,150,105,0.8)',
              'rgba(16,185,129,0.8)',
              'rgba(5,150,105,0.8)',
              'rgba(16,185,129,0.8)'
            ],
            borderColor: [
              'rgba(16,185,129,1)',
              'rgba(5,150,105,1)',
              'rgba(16,185,129,1)',
              'rgba(5,150,105,1)',
              'rgba(16,185,129,1)',
              'rgba(5,150,105,1)',
              'rgba(16,185,129,1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }

    // Doughnut Chart: Booking Status Breakdown
    const bookingStatusChartEl = document.getElementById('bookingStatusChart');
    if (bookingStatusChartEl) {
      const ctxDoughnut = bookingStatusChartEl.getContext('2d');
      new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
          labels: ['قيد الانتظار', 'مؤكد', 'ملغى'],
          datasets: [{
            data: [<?= $pendingBookings; ?>, <?= $confirmedBookings; ?>, <?= $cancelledBookings; ?>],
            backgroundColor: [
              'rgba(255,193,7,0.8)',
              'rgba(23,162,184,0.8)',
              'rgba(40,167,69,0.8)'
            ],
            borderColor: [
              'rgba(255,193,7,1)',
              'rgba(23,162,184,1)',
              'rgba(40,167,69,1)'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }

    // Line Chart: Monthly Trips
    const monthlyTripsChartEl = document.getElementById('monthlyTripsChart');
    if (monthlyTripsChartEl) {
      const ctxLine = monthlyTripsChartEl.getContext('2d');
      new Chart(ctxLine, {
        type: 'line',
        data: {
          labels: <?= json_encode($months); ?>,
          datasets: [{
            label: 'رحلات شهرية',
            data: <?= json_encode($monthlyTrips); ?>,
            backgroundColor: 'rgba(16,185,129,0.4)',
            borderColor: 'rgba(16,185,129,1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }
  });
</script>

<!-- KPI Cards Section -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
  <!-- Students Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-user-graduate text-teal-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-teal-700"><?= $studentCount; ?></h3>
        <p class="text-gray-600">الطلاب</p>
      </div>
    </div>
  </div>
  <!-- Drivers Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-truck-loading text-teal-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-teal-700"><?= $driverCount; ?></h3>
        <p class="text-gray-600">السائقين</p>
      </div>
    </div>
  </div>
  <!-- Buses Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-bus text-teal-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-teal-700"><?= $busCount; ?></h3>
        <p class="text-gray-600">الحافلات</p>
      </div>
    </div>
  </div>
  <!-- Routes Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-road text-teal-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-teal-700"><?= $routeCount; ?></h3>
        <p class="text-gray-600">الطرق</p>
      </div>
    </div>
  </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
  <!-- Trips Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-calendar-alt text-teal-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-teal-700"><?= $tripCount; ?></h3>
        <p class="text-gray-600">الرحلات</p>
      </div>
    </div>
  </div>
  <!-- Bookings Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-ticket-alt text-teal-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-teal-700"><?= $bookingCount; ?></h3>
        <p class="text-gray-600">الحجوزات</p>
      </div>
    </div>
  </div>
  <!-- Admins Card -->
  <div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
      <i class="fas fa-user-shield text-teal-600 text-4xl ml-3"></i>
      <div>
        <h3 class="text-2xl font-bold text-teal-700"><?= $adminCount; ?></h3>
        <p class="text-gray-600">المسؤولين</p>
      </div>
    </div>
  </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
  <!-- Bar Chart: Overall Statistics -->
  <div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-2xl font-bold text-teal-700 mb-4">إحصائيات عامة</h3>
    <div class="relative">
      <canvas id="dashboardBarChart" style="width:100%; height:100%;"></canvas>
    </div>
  </div>
  <!-- Doughnut Chart: Booking Status Breakdown -->
  <div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-2xl font-bold text-teal-700 mb-4">حالة الحجوزات</h3>
    <div class="relative h-[300px]">
      <canvas id="bookingStatusChart" style="width:100%; height:100%;"></canvas>
    </div>
  </div>
</div>

<!-- Line Chart: Monthly Trips -->
<div class="bg-white p-6 rounded-lg shadow mb-10">
  <h3 class="text-2xl font-bold text-teal-700 mb-4 text-center">رحلات شهرية</h3>
  <div class="relative h-[300px]">
    <canvas id="monthlyTripsChart" style="width:100%; height:100%;"></canvas>
  </div>
</div>

<!-- Recent Bookings Table -->
<div class="mt-10 bg-white p-6 rounded-lg shadow mb-10">
  <h3 class="text-2xl font-bold text-teal-700 mb-4">آخر الحجوزات</h3>
  <?php if (!empty($recentBookings)): ?>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-teal-50">
          <tr>
            <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الرقم</th>
            <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الطالب</th>
            <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الرحلة</th>
            <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الحالة</th>
            <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">التاريخ</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php foreach ($recentBookings as $booking): ?>
            <tr>
              <td class="px-4 py-2 text-right"><?= htmlspecialchars($booking->id); ?></td>
              <td class="px-4 py-2 text-right">
                <?php
                  $student = \App\Tables\Student::find($booking->student_id);
                  echo $student ? htmlspecialchars($student->name) : 'غير متوفر';
                ?>
              </td>
              <td class="px-4 py-2 text-right"><?= htmlspecialchars($booking->trip_id); ?></td>
              <td class="px-4 py-2 text-right">
                <?php
                  $status = htmlspecialchars($booking->booking_status);
                  if ($status == 'قيد الانتظار') {
                    echo '<span class="bg-yellow-300 text-yellow-800 px-2 py-1 rounded-full text-xs font-bold">قيد الانتظار</span>';
                  } else if ($status == 'مؤكد') {
                    echo '<span class="bg-green-300 text-green-800 px-2 py-1 rounded-full text-xs font-bold">مؤكد</span>';
                  } else if ($status == 'ملغى') {
                    echo '<span class="bg-red-300 text-red-800 px-2 py-1 rounded-full text-xs font-bold">ملغى</span>';
                  } else {
                    echo $status;
                  }
                ?>
              </td>
              <td class="px-4 py-2 text-right"><?= htmlspecialchars($booking->booking_date); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="mt-4 text-left">
      <a href="<?= gotolink('admin.bookings'); ?>" class="text-blue-600 hover:underline">عرض المزيد من الحجوزات</a>
    </div>
  <?php else: ?>
    <p class="text-gray-600 text-center">لا توجد حجوزات حديثة.</p>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
admin_layout($content, ['title' => $title, 'active' => $active]);
?>
