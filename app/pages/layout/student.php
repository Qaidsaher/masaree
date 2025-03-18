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
                <i class="fas fa-bus-alt m-2 "></i> مساري
            </a>
            <div class="hidden md:flex space-x-6">
                <?php if ($isAuth): ?>
                    <a href="<?= gotolink('student.home'); ?>"
                        class="mx-3 <?= ($active == 'student.home') ? 'text-teal-300' : 'hover:text-teal-300' ?>">
                        الرئيسية
                    </a>

                    <a href="<?= gotolink('student.trips'); ?>"
                        class="mx-3 <?= ($active == 'student.trips') ? 'text-teal-300' : 'hover:text-teal-300' ?>">
                        مواعيد الحفلات
                    </a>

                    <a href="<?= gotolink('student.trips'); ?>"
                        class="mx-3 <?= ($active == 'student.booking') ? 'text-teal-300' : 'hover:text-teal-300' ?>">
                        حجز
                    </a>

                    <a href="<?= gotolink('student.booked_trips'); ?>"
                        class="mx-3 <?= ($active == 'student.booked_trips') ? 'text-teal-300' : 'hover:text-teal-300' ?>">
                        رحلاتي
                    </a>
                <?php else: ?>

                    <a href="#hero" class="hover:text-teal-300 mx-3">الرئيسية</a>
                    <a href="#services" class="hover:text-teal-300">خدماتنا</a>
                    <a href="#how-it-works" class="hover:text-teal-300">كيف نعمل</a>
                    <a href="#featured-trips" class="hover:text-teal-300">رحلات مميزة</a>
                    <a href="#advantages" class="hover:text-teal-300">لماذا تختار مساري؟</a>
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
                        <div id="userMenuDropdown" class="absolute right-[-80px] lgright-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-lg hidden z-50 p-2">
                            <a href="<?= gotolink('student.profile'); ?>" class="flex items-center px-4 py-2 hover:bg-green-100 ">
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

                <nav class="flex flex-col gap-6 p-4">
                    <a href="<?= gotolink('student.home'); ?>"
                       class="block px-4 py-2 rounded transition-colors duration-200 <?= ($active == 'student.home') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-teal-50 hover:text-teal-600' ?>">
                        الرئيسية
                    </a>
                    <a href="<?= gotolink('student.trips'); ?>"
                       class="block px-4 py-2 rounded transition-colors duration-200 <?= ($active == 'student.trips') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-teal-50 hover:text-teal-600' ?>">
                        مواعيد الحفلات
                    </a>
                    <a href="<?= gotolink('student.trips'); ?>"
                       class="block px-4 py-2 rounded transition-colors duration-200 <?= ($active == 'student.booking') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-teal-50 hover:text-teal-600' ?>">
                        حجز
                    </a>
                    <a href="<?= gotolink('student.booked_trips'); ?>"
                       class="block px-4 py-2 rounded transition-colors duration-200 <?= ($active == 'student.booked_trips') ? 'bg-teal-600 text-white' : 'text-gray-700 hover:bg-teal-50 hover:text-teal-600' ?>">
                        رحلاتي
                    </a>
                </nav>


            <?php else: ?>
                <a href="#hero" class="block px-4 py-2 hover:bg-teal-800">الرئيسية</a>
                <a href="#services" class="block px-4 py-2 hover:bg-teal-800">خدماتنا</a>
                <a href="#how-it-works" class="block px-4 py-2 hover:bg-teal-800">كيف نعمل</a>
                <a href="#featured-trips" class="block px-4 py-2 hover:bg-teal-800">رحلات مميزة</a>
                <a href="#advantages" class="block px-4 py-2 hover:bg-teal-800">لماذا تختار مساري؟</a>
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
            <p class="text-center">&copy; <?= date('Y'); ?> مساري. جميع الحقوق محفوظة.</p>
            <div class="flex space-x-4 mt-2 md:mt-0">
                <a href="#" class="hover:text-teal-300"><i class="fab fa-facebook-f text-xl"></i></a>
                <a href="#" class="hover:text-teal-300"><i class="fab fa-twitter text-xl"></i></a>
                <a href="#" class="hover:text-teal-300"><i class="fab fa-instagram text-xl"></i></a>
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