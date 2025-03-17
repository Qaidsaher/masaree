<?php
namespace App\Auth;

use App\Tables\Admin;
use App\Tables\Student;
use Exception;

class Auth
{
    /**
     * Holds the single instance.
     *
     * @var Auth
     */
    private static $instance;

    /**
     * Retrieve the single instance of Auth.
     *
     * @return Auth
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Check if any account is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return isset($_SESSION['student_id']) || isset($_SESSION['admin_id']);
    }

    /**
     * Determine if the authenticated account is a student.
     *
     * @return bool
     */
    public function isStudent()
    {
        return isset($_SESSION['student_id']);
    }

    /**
     * Determine if the authenticated account is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return isset($_SESSION['admin_id']);
    }

    /**
     * Get the currently authenticated student.
     *
     * @return Student|null
     */
    public function student()
    {
        if ($this->isStudent()) {
            return Student::find($_SESSION['student_id']);
        }
        return null;
    }

    /**
     * Get the currently authenticated admin.
     *
     * @return Admin|null
     */
    public function admin()
    {
        if ($this->isAdmin()) {
            return Admin::find($_SESSION['admin_id']);
        }
        return null;
    }

    /**
     * Login either a student or an admin.
     * For admin login, pass $asAdmin = true; for student login, pass $asAdmin = false.
     *
     * @param string $email
     * @param string $password
     * @param bool   $asAdmin
     * @return Student|Admin|false
     */
    public function login($email, $password, bool $asAdmin)
    {
        $this->logout();
        if ($asAdmin) {
            $admins = Admin::where(['email' => $email]);
            if (!empty($admins)) {
                $admin = $admins[0];
                if (password_verify($password, $admin->password)) {
                    $_SESSION['admin_id'] = $admin->id;
                    session_regenerate_id(true);
                    return $admin;
                }
            }
        } else {
            $students = Student::where(['email' => $email]);
            if (!empty($students)) {
                $student = $students[0];
                if (password_verify($password, $student->password)) {
                    $_SESSION['student_id'] = $student->id;
                    session_regenerate_id(true);
                    return $student;
                }
            }
        }
        return false;
    }

    /**
     * Register a new student.
     * Registration is for students only.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $phone
     * @param string $address
     * @param string $district
     * @param string $street
     * @return Student
     * @throws Exception If the email is already registered or registration fails.
     */
    public function register($name, $email, $password, $phone, $address, $district, $street)
    {
        $existing = Student::where(['email' => $email]);
        if (!empty($existing)) {
            throw new Exception("A student with this email already exists.");
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $student = new Student([
            'name'     => $name,
            'email'    => $email,
            'password' => $hashedPassword,
            'phone'    => $phone,
            'address'  => $address,
            'district' => $district,
            'street'   => $street
        ]);
        if ($student->save()) {
            $_SESSION['student_id'] = $student->id;
            session_regenerate_id(true);
            return $student;
        }
        throw new Exception("Registration failed.");
    }

    /**
     * Update the profile for the authenticated account.
     *
     * @param array $data For a student, keys may include 'name', 'email', 'phone', etc. For admin, 'username', 'email'.
     * @return bool
     */
    public function updateProfile(array $data)
    {
        if ($this->isStudent()) {
            $student = $this->student();
            if (!$student) return false;
            $student->fill($data);
            return $student->save();
        } elseif ($this->isAdmin()) {
            $admin = $this->admin();
            if (!$admin) return false;
            $admin->fill($data);
            return $admin->save();
        }
        return false;
    }

    /**
     * Update the password for the authenticated account.
     *
     * @param string $oldPassword
     * @param string $newPassword
     * @return bool
     * @throws Exception If the old password is incorrect.
     */
    public function updatePassword($oldPassword, $newPassword)
    {
        if ($this->isStudent()) {
            $student = $this->student();
            if (!$student) return false;
            if (password_verify($oldPassword, $student->password)) {
                $student->password = password_hash($newPassword, PASSWORD_DEFAULT);
                return $student->save();
            }
            throw new Exception("Old password is incorrect.");
        } elseif ($this->isAdmin()) {
            $admin = $this->admin();
            if (!$admin) return false;
            if (password_verify($oldPassword, $admin->password)) {
                $admin->password = password_hash($newPassword, PASSWORD_DEFAULT);
                return $admin->save();
            }
            throw new Exception("Old password is incorrect.");
        }
        return false;
    }

    /**
     * Delete the authenticated account.
     *
     * @return bool
     */
    public function deleteAccount()
    {
        if ($this->isStudent()) {
            $student = $this->student();
            if (!$student) return false;
            $result = $student->delete();
            if ($result) {
                unset($_SESSION['student_id']);
            }
            return $result;
        } elseif ($this->isAdmin()) {
            $admin = $this->admin();
            if (!$admin) return false;
            $result = $admin->delete();
            if ($result) {
                unset($_SESSION['admin_id']);
            }
            return $result;
        }
        return false;
    }

    /**
     * Log out the authenticated account.
     *
     * @return void
     */
    public function logout()
    {
        if (isset($_SESSION['student_id'])) {
            unset($_SESSION['student_id']);
        }
        if (isset($_SESSION['admin_id'])) {
            unset($_SESSION['admin_id']);
        }
        // Optionally: session_destroy();
    }
}