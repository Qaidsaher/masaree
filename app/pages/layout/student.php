<?php
// Check if student is authenticated. If not, you can either redirect or show a login button.
$isAuth = isset($_SESSION['student_id']); // adjust as needed
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= isset($title) ? $title : 'لوحة الطالب'; ?></title>
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

        html,
        body {
            overflow-x: hidden;
        }

        /* Floating mobile menu button styling */
        #floating-menu-button {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            background-color: #047857;
            /* teal-700 */
            color: white;
            border: none;
            border-radius: 9999px;
            padding: 0.75rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }
    </style>
</head>

<body class="bg-green-50 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-teal-700 text-white shadow fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="#hero" class="text-2xl font-bold flex items-center">
                <i class="fas fa-bus-alt mr-2"></i> مسرى
            </a>
            <div class="hidden md:flex space-x-6">
                <?php if ($isAuth): ?>
                    <a href="<?= gotolink('student.dashboard'); ?>" class="block px-4 py-2 hover:bg-teal-800">الرئيسية</a>
                    <a href="<?= gotolink('student.trips'); ?>" class="block px-4 py-2 hover:bg-teal-800">رحلاتي</a>
                    <a href="<?= gotolink('student.booked_trips'); ?>" class="block px-4 py-2 hover:bg-teal-800">بلاغاتي</a>

                <?php else: ?>

                    <a href="#hero" class="hover:text-teal-300 mx-3">الرئيسية</a>
                    <a href="#services" class="hover:text-teal-300">خدماتنا</a>
                    <a href="#how-it-works" class="hover:text-teal-300">كيف نعمل</a>
                    <a href="#featured-trips" class="hover:text-teal-300">رحلات مميزة</a>
                    <a href="#advantages" class="hover:text-teal-300">لماذا تختار مسرى؟</a>
                    <a href="#faq" class="hover:text-teal-300">الأسئلة الشائعة</a>
                    <a href="#contact" class="hover:text-teal-300">تواصل معنا</a>
                <?php endif; ?>


            </div>
            <div class="hidden md:block">
                <?php if ($isAuth): ?>

                    <!-- User Menu Dropdown -->
                    <div class="relative hidden md:block">
                        <button id="userMenuButton" class="flex items-center focus:outline-none">
                            <i class="fas fa-user-circle text-3xl text-blue-300"></i>
                            <span class="mx-1"><?= auth()->student()->fullName ?? 'حسابي'; ?></span>
                            <i class="fas fa-chevron-down ml-1"></i>
                        </button>
                        <div id="userMenuDropdown" class="absolute right-0 mt-2 w-56 bg-white text-gray-800 rounded shadow-lg hidden z-50">
                            <a href="<?= gotolink('student.profile'); ?>" class="flex items-center px-4 py-2 hover:bg-green-100">
                                <i class="fas fa-user text-blue-500 ml-2"></i> ملفي
                            </a>
                            <a href="<?= gotolink('student.edit_profile'); ?>" class="flex items-center px-4 py-2 hover:bg-green-100">
                                <i class="fas fa-edit text-purple-500 ml-2"></i> تعديل الملف
                            </a>
                           
                            <a href="<?= gotolink('student.delete_account'); ?>" class="flex items-center px-4 py-2 hover:bg-green-100">
                                <i class="fas fa-trash-alt text-red-500 ml-2"></i> حذف الحساب
                            </a>
                            <a href="<?= gotolink('logout'); ?>" class="flex items-center px-4 py-2 hover:bg-green-100">
                                <i class="fas fa-sign-out-alt text-gray-500 ml-2"></i> تسجيل الخروج
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= gotolink('login'); ?>" class="px-4 py-2 bg-teal-600 hover:bg-teal-800 rounded">تسجيل الدخول</a>

                <?php endif; ?>
            </div>
            <div class="md:hidden">
                <button id="menu-toggle" class="focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-teal-700">
            <?php if ($isAuth): ?>
                <a href="<?= gotolink('student.dashboard'); ?>" class="block px-4 py-2 hover:bg-teal-800">الرئيسية</a>
                <a href="<?= gotolink('student.trips'); ?>" class="block px-4 py-2 hover:bg-teal-800">رحلاتي</a>
                <a href="<?= gotolink('student.booked_trips'); ?>" class="block px-4 py-2 hover:bg-teal-800">بلاغاتي</a>

            <?php else: ?>
                <a href="#hero" class="block px-4 py-2 hover:bg-teal-800">الرئيسية</a>
                <a href="#services" class="block px-4 py-2 hover:bg-teal-800">خدماتنا</a>
                <a href="#how-it-works" class="block px-4 py-2 hover:bg-teal-800">كيف نعمل</a>
                <a href="#featured-trips" class="block px-4 py-2 hover:bg-teal-800">رحلات مميزة</a>
                <a href="#advantages" class="block px-4 py-2 hover:bg-teal-800">لماذا تختار مسرى؟</a>
                <a href="#faq" class="block px-4 py-2 hover:bg-teal-800">الأسئلة الشائعة</a>
                <a href="#contact" class="block px-4 py-2 hover:bg-teal-800">تواصل معنا</a>
                <a href="login.html" class="block px-4 py-2 hover:bg-teal-800">تسجيل الدخول</a>
            <?php endif; ?>

        </div>
    </nav>

    <!-- Floating Menu Button for Mobile -->
    <?php if ($isAuth): ?>
        <button id="floating-menu-button" class="md:hidden">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="container mx-auto px-4 pt-24 min-h-screen">
        <?= $content; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-teal-800 text-white">
        <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col md:flex-row justify-between items-center">
            <p class="text-center">&copy; <?= date('Y'); ?> مسرى. جميع الحقوق محفوظة.</p>
            <div class="flex space-x-4 mt-2 md:mt-0">
                <a href="#" class="hover:text-teal-300"><i class="fab fa-facebook-f text-xl"></i></a>
                <a href="#" class="hover:text-teal-300"><i class="fab fa-twitter text-xl"></i></a>
                <a href="#" class="hover:text-teal-300"><i class="fab fa-instagram text-xl"></i></a>
            </div>
        </div>
    </footer>

    <script>
        // Toggle mobile menu
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
         // User menu dropdown toggle
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenuDropdown = document.getElementById('userMenuDropdown');
    userMenuButton && userMenuButton.addEventListener('click', (e) => {
      e.stopPropagation();
      userMenuDropdown.classList.toggle('hidden');
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!userMenuDropdown.classList.contains('hidden')) {
        userMenuDropdown.classList.add('hidden');
      }
    });
    </script>
</body>

</html>