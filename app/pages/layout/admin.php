<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? $title : 'لوحة الإدارة - masary'; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Tailwind CSS output (ensure your CSS uses white and teal as primary colors) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Chart.js (if needed) -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body {
      font-family: 'Cairo', sans-serif;
    }

    /* Apply to all tables */
    table {
      width: 100%;
      border-collapse: collapse;
    }

    /* Header styling (using a teal tone similar to Tailwind's bg-teal-50) */
    /*  */

    /* Common styling for header and data cells */
    table th,
    table td {
      padding: 1rem;
      /* roughly equivalent to Tailwind's px-4 py-2 */
      text-align: right;
      font-size: 0.875rem;
      /* Tailwind text-sm */
      font-weight: 700;
      /* Tailwind font-bold */
      color: #0d9488;
      /* Tailwind text-teal-700 */
    }

    /* Alternate row colors for tbody */
    table tbody tr:nth-child(odd) {
      background-color: #f3f4f6;
      /* Tailwind bg-gray-100 */
    }

    table tbody tr:nth-child(even) {
      background-color: #ffffff;
      /* Tailwind bg-white */
    }

    /* Hover effect for rows */
    table tbody tr:hover {
      background-color: #e5e7eb;
      /* Tailwind bg-gray-200 */
    }
  </style>
</head>

<body class="bg-white">
  <div class="flex h-screen overflow-hidden">
    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex md:flex-shrink-0">
      <div class="flex flex-col w-64 bg-teal-700 text-white">
        <div class="flex items-center justify-start h-16 border-b border-teal-800 ">
          <a href="<?= gotolink('admin.home'); ?>" class="px-2 text-2xl font-bold flex items-center">
            <i class="fas fa-bus-alt m-3"></i> مساري
          </a>
        </div>
        <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-1">


          <a href="<?= gotolink('admin.home'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.home') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-home ml-3"></i><span>الرئيسية</span>
          </a>
          <a href="<?= gotolink('admin.admins'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.admins') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-user-shield ml-3"></i><span>المسؤولين</span>
          </a>
          <a href="<?= gotolink('admin.students'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.students') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-user-graduate ml-3"></i><span>الطلاب</span>
          </a>
          <a href="<?= gotolink('admin.drivers'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.drivers') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-truck-loading ml-3"></i><span>السائقين</span>
          </a>
          <a href="<?= gotolink('admin.buses'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.buses') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-bus ml-3"></i><span>الحافلات</span>
          </a>
          <a href="<?= gotolink('admin.routes'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.routes') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-road ml-3"></i><span>الطرق</span>
          </a>
          <a href="<?= gotolink('admin.trips'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.trips') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-calendar-alt ml-3"></i><span>الرحلات</span>
          </a>
          <a href="<?= gotolink('admin.bookings'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.bookings') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-ticket-alt ml-3"></i><span>الحجوزات</span>
          </a>
          <a href="<?= gotolink('logout'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'logout') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-sign-out-alt ml-3"></i><span>تسجيل الخروج</span>
          </a>
        </nav>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 overflow-auto">
      <!-- Mobile Topbar -->
      <header class="md:hidden flex items-center justify-between bg-teal-700 px-4 py-4">
        <a href="<?= gotolink('admin.home'); ?>" class="text-xl font-bold text-white flex items-center">
          <i class="fas fa-bus-alt ml-2"></i>
          مساري
        </a>
        <button id="mobileSidebarToggle" class="text-white focus:outline-none">
          <i class="fas fa-bars text-2xl"></i>
        </button>
      </header>
      <!-- Mobile Sidebar Panel -->
      <div id="mobileSidebar" class="fixed inset-y-0 right-0 w-64 bg-teal-700 text-white transform translate-x-full transition duration-300 ease-in-out md:hidden">
        <div class="flex items-center justify-start h-16 border-b border-teal-800">
          <a href="<?= gotolink('admin.home'); ?>" class="text-2xl font-bold flex items-center">
            <i class="fas fa-bus-alt ml-2"></i> مساري
          </a>
        </div>
        <nav class="px-2 py-4 space-y-2">
          <a href="<?= gotolink('admin.home'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.home') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-home ml-3"></i><span>الرئيسية</span>
          </a>
          <a href="<?= gotolink('admin.admins'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.admins') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-user-shield ml-3"></i><span>المسؤولين</span>
          </a>
          <a href="<?= gotolink('admin.students'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.students') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-user-graduate ml-3"></i><span>الطلاب</span>
          </a>
          <a href="<?= gotolink('admin.drivers'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.drivers') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-truck-loading ml-3"></i><span>السائقين</span>
          </a>
          <a href="<?= gotolink('admin.buses'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.buses') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-bus ml-3"></i><span>الحافلات</span>
          </a>
          <a href="<?= gotolink('admin.routes'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.routes') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-road ml-3"></i><span>الطرق</span>
          </a>
          <a href="<?= gotolink('admin.trips'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.trips') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-calendar-alt ml-3"></i><span>الرحلات</span>
          </a>
          <a href="<?= gotolink('admin.bookings'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'admin.bookings') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-ticket-alt ml-3"></i><span>الحجوزات</span>
          </a>
          <a href="<?= gotolink('logout'); ?>"
            class="flex items-center px-4 py-2 rounded-md <?= ($active == 'logout') ? 'bg-teal-800' : 'hover:bg-teal-800'; ?>">
            <i class="fas fa-sign-out-alt ml-3"></i><span>تسجيل الخروج</span>
          </a>
        </nav>
      </div>
      <!-- Main Content -->
      <main>
        <!-- Desktop Header -->
        <div class="bg-teal-600 text-white px-6 py-4 border-b border-teal-800 hidden md:flex justify-between items-center">
          <h1 class="text-2xl font-bold"><?= isset($title) ? $title : 'لوحة الإدارة'; ?></h1>
        </div>
        <div class="p-6">
          <?= $content; ?>
        </div>
      </main>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-teal-700 text-white">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col md:flex-row justify-between items-center">
      <p class="flex text-center px-8">&copy; <?= date('Y'); ?> لوحة الإدارة - مساري. جميع الحقوق محفوظة.</p>
      <div class="space-x-4">
        <a href="#" class="hover:text-teal-200"><i class="fab fa-facebook-f text-xl mx-2"></i></a>
        <a href="#" class="hover:text-teal-200"><i class="fab fa-twitter text-xl mx-2"></i></a>
        <a href="#" class="hover:text-teal-200"><i class="fab fa-instagram text-xl"></i></a>
      </div>
    </div>
  </footer>

  <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
    <div id="alert-container" class="fixed top-5 left-0 z-50 m-5 p-4">
      <?php if (isset($_SESSION['success'])): ?>
        <div id="success-alert" class="flex items-center p-4 mb-4 text-green-800 border border-green-400 rounded-lg bg-green-50 shadow-lg transition-opacity duration-500 ease-in-out">
          <i class="fas fa-check-circle text-xl mx-2"></i>
          <span class="mx-4"><?= $_SESSION['success']; ?></span>
          <button onclick="closeAlert('success-alert')" class="mx-2 text-lg text-green-800 hover:text-green-900">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>
      <?php if (isset($_SESSION['error'])): ?>
        <div id="error-alert" class="flex items-center p-4 mb-4 text-red-800 border border-red-400 rounded-lg bg-red-50 shadow-lg transition-opacity duration-500 ease-in-out"></div>
        <i class="fas fa-exclamation-circle text-xl mx-2"></i>
        <span class="mx-4"><?= $_SESSION['error']; ?></span>
        <button onclick="closeAlert('error-alert')" class="mx-2 text-lg text-red-800 hover:text-red-900">
          <i class="fas fa-times"></i>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>
  </div>
<?php endif; ?>

<script>
  // Close alert manually
  function closeAlert(id) {
    document.getElementById(id).classList.add("opacity-0");
    setTimeout(() => document.getElementById(id).remove(), 500);
  }

  // Auto-hide alerts after 5 seconds
  setTimeout(() => {
    document.querySelectorAll("#alert-container div").forEach((alert) => {
      alert.classList.add("opacity-0");
      setTimeout(() => alert.remove(), 500);
    });
  }, 5000);
</script>
<script>
  // Mobile sidebar toggle
  const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
  const mobileSidebar = document.getElementById('mobileSidebar');
  mobileSidebarToggle && mobileSidebarToggle.addEventListener('click', () => {
    mobileSidebar.classList.toggle('translate-x-full');
  });
</script>
</body>

</html>