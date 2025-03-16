<?php
namespace App\Controllers;

use App\Auth\Auth;
use App\Tables\Admin;
use App\Tables\Student;

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email']);
            $password = $_POST['password'];
            $userType = $_POST['user_type']; // Expected values: "student" or "admin"

            // Basic validation could be added here

            // Attempt to log in via the Auth instance
            $auth = auth();
            $result = $auth->login($email, $password, $userType);

            if ($result) {
                $_SESSION['success'] = "تم تسجيل الدخول بنجاح";
                // Redirect based on user type
                if ($auth->isAdmin()) {
                    header("Location: " . gotolink('admin.home'));
                } else {
                    header("Location: " . gotolink('student.home'));
                }
                exit;
            } else {
                $_SESSION['error'] = "فشل تسجيل الدخول، يرجى التحقق من البيانات";
                header("Location: " . gotolink('login'));
                exit;
            }
        } else {
            // If GET, display the login page
            page('auth/login');
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName    = trim($_POST['fullName']);
            $email       = trim($_POST['email']);
            $phoneNumber = trim($_POST['phoneNumber']);
            $password    = $_POST['password'];
            $address     = trim($_POST['address']);
            $district    = trim($_POST['district']);
            $street      = trim($_POST['street']);
            $userType    = $_POST['user_type'] ?? 'student'; // Registration allowed only for students

            // Public registration is allowed only for students.
            if ($userType !== 'student') {
                $_SESSION['error'] = "لا يمكن التسجيل كأدمن عبر الواجهة العامة.";
                header("Location: " . gotolink('register'));
                exit;
            }

            // Basic validation: Ensure all fields are filled
            if (empty($fullName) || empty($email) || empty($phoneNumber) || empty($password) ||
                empty($address) || empty($district) || empty($street)) {
                $_SESSION['error'] = "جميع الحقول مطلوبة.";
                header("Location: " . gotolink('register'));
                exit;
            }

            // Use the Auth instance to register the student.
            // Ensure your Auth class has a registerStudent method that handles these fields.
            $auth = Auth::instance();
            try {
                $user = $auth->register(
                    $fullName,
                    $email,
                    $password,
                    $phoneNumber,
                    $address,
                    $district,
                    $street
                );
                $_SESSION['success'] = "تم إنشاء الحساب بنجاح";
                header("Location: " . gotolink('login'));
                exit;
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header("Location: " . gotolink('register'));
                exit;
            }
        } else {
            // If GET, display the registration page
            page('auth/register');
        }
    }
}
