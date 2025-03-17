<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Andev Web - Validate Form</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: "Poppins", sans-serif;
        }

        .text-shadow {
            text-shadow: 0 0 10px rgba(16, 64, 74, 0.5);
        }

        .right-panel-active .login-container {
            transform: translateX(100%);
            opacity: 0;
        }

        .right-panel-active .register-container {
            transform: translateX(0%);
            opacity: 1;
        }

        .right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .right-panel-active .overlay {
            transform: translateX(50%);
        }

        .right-panel-active .overlay-panel.overlay-left {
            transform: translateX(0);
        }

        .right-panel-active .overlay-panel.overlay-right {
            transform: translateX(20%);
        }

        .login-container,
        .register-container {
            transition: all 0.6s ease-in-out;
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
        }

        .register-container {
            left: 50%;
            transform: translateX(-100%);
            opacity: 0;
            pointer-events: none;
        }

        .login-container {
            left: 0;
        }

        .right-panel-active .register-container {
            pointer-events: auto;
        }

        .right-panel-active .login-container {
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-cover bg-center flex justify-center items-center flex-col overflow-hidden h-screen " style="background-image:  url('<?php echo asset('images/10.jpeg') ; ?>');">
    <div class="relative w-[768px] max-w-full min-h-[500px] rounded-2xl shadow-2xl overflow-hidden bg-white" id="container">
        <!-- Login Form Container -->
        <div id="loginContainer" class="login-container flex flex-col items-center justify-center px-12 h-full text-center">
            <form id="loginForm" method="post" href="<?= gotolink('login'); ?>" class="w-full max-w-sm mx-auto"  dir="rtl">
                <input type="hidden" name="form_type" value="login">
                <h1 class="font-bold text-4xl text-shadow mb-4">تسجيل الدخول</h1>
                <div class="w-full relative mb-4">
                    <input type="email" name="loginEmail" placeholder="example@pnu.edu.sa" class="w-full bg-white text-black outline-none border-b-2 border-gray-300 py-3 focus:border-[#006c67] transition duration-300" />
                    <small class="text-red-500 text-xs absolute top-full left-0"></small>
                </div>
                <div class="w-full relative mb-4">
                    <input type="password" name="loginPassword" placeholder="كلمة المرور" class="w-full bg-white text-black outline-none border-b-2 border-gray-300 py-3 focus:border-[#006c67] transition duration-300" />
                    <small class="text-red-500 text-xs absolute top-full left-0"></small>
                </div>
                <div class="w-full relative mb-4">
                    <label class="block text-right mb-2">تسجيل الدخول ك:</label>
                    <div class="flex items-center">
                        <input type="radio" id="student" name="userType" value="student" class="ml-2" checked>
                        <label for="student" class="ml-4">طالب</label>
                        <input type="radio" id="admin" name="userType" value="admin" class="ml-2">
                        <label for="admin">مدير</label>
                    </div>
                </div>
                <div class="flex items-center justify-between w-full my-4 text-sm">
                    <div class="flex items-center">
                        <input type="checkbox" id="checkbox" class="w-4 h-4 accent-[#006c67]" />
                        <label for="checkbox" class="mr-1 select-none">تذكرني</label>
                    </div>
                    <div>
                        <span id="forgotPasswordLink" class="text-[#006c67] hover:text-[#2691d9] transition duration-300 cursor-pointer">هل نسيت كلمة المرور؟</span>
                    </div>
                </div>
                <button type="submit" class="relative rounded-full border border-[#006c67] bg-[#006c67] text-white font-bold py-3 px-16 tracking-wide capitalize transition duration-300 ease-in-out hover:tracking-wider active:scale-95 focus:outline-none">
                    تسجيل الدخول
                </button>
            </form>

            <!-- Forgot Password Form -->
            <form id="forgotPasswordForm" method="post" action="" class="w-full max-w-sm mx-auto hidden">
                <input type="hidden" name="form_type" value="forgot_password">
                <h1 class="font-bold text-4xl text-shadow mb-4">إعادة تعيين كلمة المرور</h1>
                <div class="w-full relative mb-4">
                    <input type="email" name="resetEmail" placeholder="أدخل بريدك الإلكتروني" class="w-full bg-white text-black outline-none border-b-2 border-gray-300 py-3 focus:border-[#006c67] transition duration-300" />
                    <small class="text-red-500 text-xs absolute top-full left-0"></small>
                </div>
                <button type="submit" class="relative rounded-full border border-[#006c67] bg-[#006c67] text-white font-bold py-3 px-16 tracking-wide capitalize transition duration-300 ease-in-out hover:tracking-wider active:scale-95 focus:outline-none">
                    إرسال رابط إعادة التعيين
                </button>
                <div class="mt-4">
                    <span id="backToLogin" class="text-[#006c67] hover:text-[#2691d9] transition duration-300 cursor-pointer">العودة إلى تسجيل الدخول</span>
                </div>
            </form>
        </div>

        <!-- Register Form Container -->
        <div id="registerContainer" class="register-container flex flex-col items-center justify-center px-12 h-full text-center" dir="rtl">
            <form id="registerForm" method="post" href="<?= gotolink(name: 'register'); ?>" class="w-full max-w-sm mx-auto" dir="rtl">
                <input type="hidden" name="form_type" value="register">
                <h1 class="font-bold text-4xl text-shadow mb-4">التسجيل هنا</h1>
                <div class="w-full relative mb-4">
                    <input type="text" name="username" placeholder="الاسم" class="w-full bg-white text-black outline-none border-b-2 border-gray-300 py-3 focus:border-[#006c67] transition duration-300" />
                    <small class="text-red-500 text-xs absolute top-full left-0"></small>
                </div>
                <div class="w-full relative mb-4">
                    <input type="phone" name="studentId" placeholder="رقم الهاتف" class="w-full bg-white text-black outline-none border-b-2 border-gray-300 py-3 focus:border-[#006c67] transition duration-300" />
                    <small class="text-red-500 text-xs absolute top-full left-0"></small>
                </div>
                <div class="w-full relative mb-4">
                    <input type="email" name="email" placeholder="example@pnu.edu.sa" class="w-full bg-white text-black outline-none border-b-2 border-gray-300 py-3 focus:border-[#006c67] transition duration-300" />
                    <small class="text-red-500 text-xs absolute top-full left-0"></small>
                </div>
                <div class="w-full relative mb-4">
                    <input type="password" name="password" placeholder="كلمة المرور" class="w-full bg-white text-black outline-none border-b-2 border-gray-300 py-3 focus:border-[#006c67] transition duration-300" />
                    <small class="text-red-500 text-xs absolute top-full left-0"></small>
                </div>
                <div class="w-full mb-4 flex flex-col md:flex-row gap-4">
                    <div class="w-full relative">
                        <input type="text" name="district" placeholder="الحي" class="w-full bg-white text-black outline-none border-b-2 border-gray-300 py-3 focus:border-[#006c67] transition duration-300" />
                        <small class="text-red-500 text-xs"></small>
                    </div>
                    <div class="w-full relative">
                        <input type="text" name="direction" placeholder="الشارع" class="w-full bg-white text-black outline-none border-b-2 border-gray-300 py-3 focus:border-[#006c67] transition duration-300" />
                        <small class="text-red-500 text-xs"></small>
                    </div>
                </div>
                <button type="submit" class="relative rounded-full border border-[#006c67] bg-[#006c67] text-white font-bold py-3 px-16 tracking-wide capitalize transition duration-300 ease-in-out hover:tracking-wider active:scale-95 focus:outline-none">
                    تسجيل
                </button>
            </form>
        </div> 
        <!-- Overlay Container -->
        <div class="absolute top-0 left-1/2 w-1/2 h-full overflow-hidden transition-transform duration-600 ease-in-out overlay-container">
            <div class="relative left-[-100%] w-[200%] h-full transition-transform duration-600 ease-in-out overlay" style="background-image: url('IMG_7038.jpeg'); background-repeat: no-repeat; background-size: cover; background-position: 0 0;">
            <div class="absolute inset-0 bg-gradient-to-t from-[#2e5e6d]/40 via-transparent"></div>
            <div class="absolute top-0 left-0 w-1/2 h-full flex flex-col items-center justify-center px-10 text-center transition-transform duration-600 ease-in-out overlay-panel overlay-left transform -translate-x-[20%]">
                <h1 class="font-bold text-4xl text-shadow mb-4">مرحبًا</h1>
                <p class="text-md text-shadow mb-4">مرحبًا بعودتك! هل أنت جاهز لتجربة تنقل جامعي أكثر سلاسة؟<br /><br />دع Masary يسهل رحلتك!</p>
                <button class="ghost relative rounded-full border-2 border-teal-500 bg-[rgba(255,255,255,0.2)] text-teal-500 font-bold py-3 px-16 tracking-wide capitalize transition duration-300 ease-in-out focus:outline-none" id="loginToggle">
                تسجيل الدخول
                </button>
            </div>
            <div class="absolute top-0 right-0 w-1/2 h-full flex flex-col items-center justify-center px-10 text-center transition-transform duration-600 ease-in-out overlay-panel overlay-right transform translate-x-0">
                <h1 class="font-bold text-4xl text-shadow mb-4">ابدأ رحلتك الآن</h1>
                <p class="text-md text-shadow mb-4">انضم إلى Masary واجعل تنقلك الجامعي أسهل وأسرع!</p>
                <button class="ghost relative rounded-full border-2 border-teal-500 bg-[rgba(255,255,255,0.2)] text-teal-500 font-bold py-3 px-16 tracking-wide capitalize transition duration-300 ease-in-out focus:outline-none" id="registerToggle">
                تسجيل
                </button>
            </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById("container");
        const loginToggle = document.getElementById("loginToggle");
        const registerToggle = document.getElementById("registerToggle");
        const loginForm = document.getElementById("loginForm");
        const forgotPasswordForm = document.getElementById("forgotPasswordForm");
        const forgotPasswordLink = document.getElementById("forgotPasswordLink");
        const backToLogin = document.getElementById("backToLogin");

        function showLogin() {
            container.classList.remove("right-panel-active");
            loginForm.classList.remove("hidden");
            forgotPasswordForm.classList.add("hidden");
        }

        function showRegister() {
            container.classList.add("right-panel-active");
        }

        registerToggle.addEventListener("click", (e) => {
            e.preventDefault();
            showRegister();
        });

        loginToggle.addEventListener("click", (e) => {
            e.preventDefault();
            showLogin();
        });

        forgotPasswordLink.addEventListener("click", () => {
            loginForm.classList.add("hidden");
            forgotPasswordForm.classList.remove("hidden");
        });

        backToLogin.addEventListener("click", () => {
            forgotPasswordForm.classList.add("hidden");
            loginForm.classList.remove("hidden");
        });

        window.onload = () => {
            showLogin();
        };
    </script>
</body>

</html>
