<?php
// If student is not authenticated, show a "Login" button.
$isAuth = !isset($_SESSION['student']);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($title) ? $title : 'لوحة المستخدم'; ?></title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Google Fonts for Arabic (Cairo) -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      font-family: 'Cairo', sans-serif;
    }
    /* Optional: Custom pattern background (replace with your desired pattern image) */
    .bg-pattern {
      background-image: url('path/to/your-pattern.png');
      background-repeat: repeat;
      background-size: auto;
    }
  </style>
</head>
<body class="bg-gray-50 dark:bg-gray-800">
  <!-- Navbar -->
  <nav class="bg-teal-600 bg-pattern border-b border-teal-700">
    <div class="max-w-screen-xl mx-auto px-4 py-3 flex items-center justify-between">
      <!-- Logo -->
      <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="your-logo.png" alt="Logo" class="h-10">
        <span class="text-white text-2xl font-bold">اسم الموقع</span>
      </a>
      <?php if ($isAuth): ?>
      <!-- Authenticated Menu -->
      <div class="flex items-center space-x-4 rtl:space-x-reverse">
        <!-- Desktop Navigation -->
        <ul class="hidden md:flex space-x-6 rtl:space-x-reverse">
          <li>
            <a href="<?= gotolink('student.dashboard'); ?>" class="text-white hover:text-teal-200 <?= ($active == 'student.dashboard') ? 'border-b-2 border-white' : ''; ?>">الرئيسية</a>
          </li>
          <li>
            <a href="<?= gotolink('student.trips'); ?>" class="text-white hover:text-teal-200 <?= ($active == 'student.trips') ? 'border-b-2 border-white' : ''; ?>">رحلاتي</a>
          </li>
          <li>
            <a href="<?= gotolink('student.reports'); ?>" class="text-white hover:text-teal-200 <?= ($active == 'student.reports') ? 'border-b-2 border-white' : ''; ?>">بلاغاتي</a>
          </li>
          <li>
            <a href="<?= gotolink('student.reports.create'); ?>" class="text-white hover:text-teal-200 <?= ($active == 'student.reports.create') ? 'border-b-2 border-white' : ''; ?>">تقديم البلاغ</a>
          </li>
          <li>
            <a href="<?= gotolink('student.requests'); ?>" class="text-white hover:text-teal-200 <?= ($active == 'student.requests') ? 'border-b-2 border-white' : ''; ?>">طلباتي</a>
          </li>
          <li>
            <a href="<?= gotolink('student.challenges'); ?>" class="text-white hover:text-teal-200 <?= ($active == 'student.challenges') ? 'border-b-2 border-white' : ''; ?>">التحديات</a>
          </li>
          <li>
            <a href="<?= gotolink('student.profile'); ?>" class="text-white hover:text-teal-200">الملف الشخصي</a>
          </li>
          <li>
            <a href="<?= gotolink('logout'); ?>" class="text-white hover:text-teal-200">تسجيل الخروج</a>
          </li>
        </ul>
        <!-- Mobile User Icon (shows on small screens) -->
        <div class="relative md:hidden">
          <button id="user-menu-button" class="focus:outline-none">
            <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="User Profile">
          </button>
          <!-- Dropdown Menu for Mobile -->
          <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20">
            <a href="<?= gotolink('student.dashboard'); ?>" class="block px-4 py-2 text-gray-800 hover:bg-teal-100">الرئيسية</a>
            <a href="<?= gotolink('student.profile'); ?>" class="block px-4 py-2 text-gray-800 hover:bg-teal-100">الملف الشخصي</a>
            <a href="<?= gotolink('logout'); ?>" class="block px-4 py-2 text-gray-800 hover:bg-teal-100">تسجيل الخروج</a>
          </div>
        </div>
        <!-- Hamburger Icon for Mobile Navigation -->
        <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none">
          <i class="fas fa-bars text-2xl"></i>
        </button>
      </div>
      <?php else: ?>
      <!-- Not Authenticated: Show Login Button -->
      <div>
        <a href="<?= gotolink('login'); ?>" class="px-4 py-2 border border-white text-white rounded hover:bg-white hover:text-teal-600 transition duration-200">تسجيل الدخول</a>
      </div>
      <?php endif; ?>
    </div>
    <!-- Mobile Navigation Menu (for authenticated users) -->
    <?php if ($isAuth): ?>
    <div id="mobile-menu" class="hidden md:hidden bg-teal-600 border-t border-teal-700">
      <ul class="flex flex-col space-y-2 px-4 py-2">
        <li>
          <a href="<?= gotolink('student.dashboard'); ?>" class="text-white hover:text-teal-200">الرئيسية</a>
        </li>
        <li>
          <a href="<?= gotolink('student.trips'); ?>" class="text-white hover:text-teal-200">رحلاتي</a>
        </li>
        <li>
          <a href="<?= gotolink('student.reports'); ?>" class="text-white hover:text-teal-200">بلاغاتي</a>
        </li>
        <li>
          <a href="<?= gotolink('student.reports.create'); ?>" class="text-white hover:text-teal-200">تقديم البلاغ</a>
        </li>
        <li>
          <a href="<?= gotolink('student.requests'); ?>" class="text-white hover:text-teal-200">طلباتي</a>
        </li>
        <li>
          <a href="<?= gotolink('student.challenges'); ?>" class="text-white hover:text-teal-200">التحديات</a>
        </li>
        <li>
          <a href="<?= gotolink('student.profile'); ?>" class="text-white hover:text-teal-200">الملف الشخصي</a>
        </li>
        <li>
          <a href="<?= gotolink('logout'); ?>" class="text-white hover:text-teal-200">تسجيل الخروج</a>
        </li>
      </ul>
    </div>
    <?php endif; ?>
  </nav>

  <!-- Main Content -->
  <main class="max-w-screen-xl mx-auto p-4 py-8 min-h-screen">
    <?= $content; ?>
  </main>

  <!-- Footer -->
  <footer class="bg-teal-600 border-t border-teal-700">
    <div class="max-w-screen-xl mx-auto p-4 flex flex-col md:flex-row items-center justify-between">
      <p class="text-center text-white">&copy; <?= date('Y'); ?> مسرى. جميع الحقوق محفوظة.</p>
      <div class="flex space-x-4 rtl:space-x-reverse mt-4 md:mt-0">
        <a href="#" class="hover:text-teal-200"><i class="fab fa-facebook-f text-xl"></i></a>
        <a href="#" class="hover:text-teal-200"><i class="fab fa-twitter text-xl"></i></a>
        <a href="#" class="hover:text-teal-200"><i class="fab fa-instagram text-xl"></i></a>
      </div>
    </div>
  </footer>

  <script>
    // Toggle mobile menu visibility
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    if(mobileMenuButton){
      mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });
    }
    // Toggle user dropdown (mobile) visibility
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');
    if(userMenuButton){
      userMenuButton.addEventListener('click', () => {
        userDropdown.classList.toggle('hidden');
      });
    }
  </script>
</body>
</html>
