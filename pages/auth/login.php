<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Andev Web - Validate Form</title>
    <!-- Add Tailwind CSS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
<body class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="container relative w-full max-w-4xl" id="container">
        <!-- Registration Form -->
        <div class="form-container register-container absolute top-0 left-0 w-full h-full bg-white p-8 rounded shadow-md transition-transform duration-300">
            <form class="space-y-6">
                <h1 class="text-2xl font-bold text-center">Register Here</h1>
                <div class="form-control">
                    <input type="text" id="username" placeholder="Name" class="border p-2 w-full rounded" />
                    <small id="username-error" class="text-red-500"></small>
                </div>
                <div class="form-control">
                    <input type="text" id="student-id" placeholder="Student ID" class="border p-2 w-full rounded" />
                    <small id="student-id-error" class="text-red-500"></small>
                </div>
                <div class="form-control">
                    <input type="email" id="email" placeholder="example@pnu.edu.sa" class="border p-2 w-full rounded" />
                    <small id="email-error" class="text-red-500"></small>
                </div>
                <div class="form-control">
                    <input type="password" id="password" placeholder="Password" class="border p-2 w-full rounded" />
                    <small id="password-error" class="text-red-500"></small>
                </div>
                <div class="form-control">
                    <input type="text" id="district" placeholder="District" class="border p-2 w-full rounded" />
                    <small id="district-error" class="text-red-500"></small>
                </div>
                <div class="form-control">
                    <input type="text" id="direction" placeholder="Direction" class="border p-2 w-full rounded" />
                    <small id="direction-error" class="text-red-500"></small>
                </div>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full hover:bg-blue-600">Register</button>
            </form>
        </div>

        <!-- Login Form -->
        <div class="form-container login-container absolute top-0 right-0 w-full h-full bg-white p-8 rounded shadow-md transition-transform duration-300">
            <form class="space-y-6">
                <h1 class="text-2xl font-bold text-center">Login Here</h1>
                <div class="form-control2">
                    <input type="text" id="login-student-id" placeholder="Student ID" class="border p-2 w-full rounded" />
                    <small id="login-student-id-error" class="text-red-500"></small>
                </div>
                <div class="form-control2">
                    <input type="email" id="login-email" placeholder="example@pnu.edu.sa" class="border p-2 w-full rounded" />
                    <small id="login-email-error" class="text-red-500"></small>
                </div>
                <div class="form-control2">
                    <input type="password" id="login-password" placeholder="Password" class="border p-2 w-full rounded" />
                    <small id="login-password-error" class="text-red-500"></small>
                </div>
                <div class="content flex justify-between items-center text-sm">
                    <div class="checkbox flex items-center">
                        <input type="checkbox" name="checkbox" id="checkbox" class="mr-2" />
                        <label for="checkbox">Remember me</label>
                    </div>
                    <div class="pass-link">
                        <a href="forgot your password.html" class="text-blue-500 hover:underline">Forgot your password?</a>
                    </div>
                </div>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full hover:bg-blue-600">Login</button>
            </form>
        </div>

        <!-- Overlay Panels -->
        <div class="overlay-container absolute top-0 left-0 w-full h-full">
            <div class="overlay relative w-full h-full">
                <div class="overlay-panel overlay-left absolute top-0 left-0 w-1/2 h-full bg-gray-200 p-8 text-center transition-transform duration-300">
                    <h1 class="text-2xl font-bold">Hello</h1>
                    <p class="my-4">Welcome back! Ready for a smoother university commute? <br><br> Let Masary take you there!</p>
                    <button class="ghost bg-white text-blue-500 p-2 rounded w-1/2 mx-auto block hover:bg-blue-100" id="login">
                        Login
                        <i class="fa-solid fa-arrow-left ml-2"></i>
                    </button>
                </div>
                <div class="overlay-panel overlay-right absolute top-0 right-0 w-1/2 h-full bg-gray-200 p-8 text-center transition-transform duration-300">
                    <h1 class="text-2xl font-bold">Start Your Journey Now</h1>
                    <p class="my-4">Join Masary and make your university commute easier and faster!</p>
                    <button class="ghost bg-white text-blue-500 p-2 rounded w-1/2 mx-auto block hover:bg-blue-100" id="register">
                        Register
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Section (retained from original) -->
    <div class="mt-4">
        <div>
            <img src="1.png" id="img1" class="max-w-full h-auto">
        </div>
    </div>

    <!-- JavaScript for form switching -->
    <script src="sin.js"></script>
</body>
</html>