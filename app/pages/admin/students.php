<?php
use App\Tables\Student;

$active = 'admin.students';
$title = 'إدارة الطلاب - لوحة الإدارة';

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $action = $_POST['form_action'] ?? '';
    $data = [
        'name'     => trim($_POST['name'] ?? ''),
        'email'    => trim($_POST['email'] ?? ''),
        'phone'    => trim($_POST['phone'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'address'  => trim($_POST['address'] ?? ''),
        'district' => trim($_POST['district'] ?? ''),
        'street'   => trim($_POST['street'] ?? '')
    ];
    
    // Ensure all fields are provided
    foreach ($data as $key => $value) {
        if ($value === '' && $key !== 'password') {  // password may be blank on edit
            $_SESSION['error'] = "جميع الحقول مطلوبة.";
            header("Location: " . gotolink('admin.students', ['action' => $action, 'id' => $_POST['id'] ?? null]));
            exit;
        }
    }
    
    // Hash password if provided
    if ($action === 'create' || ($action === 'edit' && !empty($data['password']))) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    } elseif ($action === 'edit' && empty($data['password'])) {
        // Remove password from data to avoid updating it if left blank
        unset($data['password']);
    }
    
    if ($action === 'create') {
        // Create a new student
        $student = new Student($data);
        if ($student->save()) {
            $_SESSION['success'] = "تم إنشاء الطالب بنجاح";
        } else {
            $_SESSION['error'] = "فشل إنشاء الطالب";
        }
    } elseif ($action === 'edit') {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $student = Student::find($id);
            if ($student) {
                // Update fields
                $student->name = $data['name'];
                $student->email = $data['email'];
                $student->phone = $data['phone'];
                $student->address = $data['address'];
                $student->district = $data['district'];
                $student->street = $data['street'];
                if (isset($data['password'])) {
                    $student->password = $data['password'];
                }
                if ($student->save()) {
                    $_SESSION['success'] = "تم تعديل بيانات الطالب بنجاح";
                } else {
                    $_SESSION['error'] = "فشل تعديل بيانات الطالب";
                }
            } else {
                $_SESSION['error'] = "الطالب غير موجود";
            }
        }
    }
    header("Location: " . gotolink('admin.students'));
    exit;
}

// Start output buffering
ob_start();

$viewAction = $_GET['action'] ?? 'list';

// If editing, retrieve the student data
if ($viewAction === 'edit' && isset($_GET['id'])) {
    $editStudent = Student::find($_GET['id']);
    if (!$editStudent) {
        $_SESSION['error'] = "الطالب غير موجود";
        header("Location: " . gotolink('admin.students'));
        exit;
    }
}
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-teal-700">إدارة الطلاب</h1>
    <?php if ($viewAction === 'list'): ?>
        <a href="<?php echo gotolink('admin.students', ['action' => 'create']); ?>" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
            <i class="fas fa-plus ml-2"></i> إضافة طالب جديد
        </a>
    <?php else: ?>
        <a href="<?php echo gotolink('admin.students'); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            <i class="fas fa-arrow-left ml-2"></i> الرجوع للقائمة
        </a>
    <?php endif; ?>
</div>

<?php if ($viewAction === 'list'): ?>
    <!-- List of Students -->
    <?php $students = Student::all(); ?>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-teal-50">
                <tr>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الرقم</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الاسم</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">البريد الإلكتروني</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الهاتف</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">العنوان</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الحي/المدينة</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الشارع</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($students)): ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td class="px-4 py-2 text-right"><?php echo htmlspecialchars($student->id); ?></td>
                            <td class="px-4 py-2 text-right"><?php echo htmlspecialchars($student->name); ?></td>
                            <td class="px-4 py-2 text-right"><?php echo htmlspecialchars($student->email); ?></td>
                            <td class="px-4 py-2 text-right"><?php echo htmlspecialchars($student->phone); ?></td>
                            <td class="px-4 py-2 text-right"><?php echo htmlspecialchars($student->address); ?></td>
                            <td class="px-4 py-2 text-right"><?php echo htmlspecialchars($student->district); ?></td>
                            <td class="px-4 py-2 text-right"><?php echo htmlspecialchars($student->street); ?></td>
                            <td class="px-4 py-2 text-right">
                                <a href="<?php echo gotolink('admin.students', ['action' => 'edit', 'id' => $student->id]); ?>" class="text-blue-600 hover:underline mr-2">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <a href="<?php echo gotolink('admin.students.delete', ['id' => $student->id]); ?>" class="text-red-600 hover:underline" onclick="return confirm('هل أنت متأكد من حذف الطالب؟');">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="px-4 py-2 text-center text-gray-600">لا يوجد طلاب بعد.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<?php elseif ($viewAction === 'create' || $viewAction === 'edit'): ?>
    <!-- Student Form: Create or Edit -->
    <?php
    $formTitle = ($viewAction === 'create') ? "إضافة طالب جديد" : "تعديل بيانات الطالب";
    $studentData = [
        'id'       => $viewAction === 'edit' ? $editStudent->id : '',
        'name'     => $viewAction === 'edit' ? $editStudent->name : '',
        'email'    => $viewAction === 'edit' ? $editStudent->email : '',
        'phone'    => $viewAction === 'edit' ? $editStudent->phone : '',
        'password' => '', // leave blank on edit
        'address'  => $viewAction === 'edit' ? $editStudent->address : '',
        'district' => $viewAction === 'edit' ? $editStudent->district : '',
        'street'   => $viewAction === 'edit' ? $editStudent->street : '',
    ];
    ?>
    <div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-teal-700 mb-4"><?php echo $formTitle; ?></h2>
        <form action="<?php echo gotolink('admin.students'); ?>" method="POST" class="space-y-4">
            <?php if ($viewAction === 'edit'): ?>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($studentData['id']); ?>">
            <?php endif; ?>
            <input type="hidden" name="form_action" value="<?php echo $viewAction; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Name -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="name">الاسم</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($studentData['name']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Email -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($studentData['email']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Phone -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="phone">الهاتف</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($studentData['phone']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Password -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="password">كلمة المرور <?php echo ($viewAction === 'edit') ? '(اتركها فارغة إذا لم تريد التغيير)' : ''; ?></label>
                    <input type="password" id="password" name="password" <?php echo ($viewAction === 'create') ? 'required' : ''; ?> class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Address -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="address">العنوان</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($studentData['address']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- District -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="district">الحي/المدينة</label>
                    <input type="text" id="district" name="district" value="<?php echo htmlspecialchars($studentData['district']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Street -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="street">الشارع</label>
                    <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($studentData['street']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
                    <?php echo ($viewAction === 'create') ? 'إنشاء الطالب' : 'تعديل الطالب'; ?>
                </button>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
admin_layout($content, ['title' => $title, 'active' => $active]);
?>
