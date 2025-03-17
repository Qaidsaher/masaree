<?php
use App\Tables\Admin;

$active = 'admin.admins';
$title = 'إدارة المسؤولين - لوحة الإدارة';

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['form_action'] ?? '';
    $data = [
       'username' => trim($_POST['username'] ?? ''),
       'email'    => trim($_POST['email'] ?? ''),
       'password' => $_POST['password'] ?? '',
    ];
    
    // Check required fields (except password on edit)
    foreach ($data as $key => $value) {
        if ($value === '' && $key !== 'password') {
            $_SESSION['error'] = "جميع الحقول مطلوبة.";
            header("Location: " . gotolink('admin.admins', ['action' => $action, 'id' => $_POST['id'] ?? null]));
            exit;
        }
    }
    
    // Hash password if provided
    if ($action === 'create' || ($action === 'edit' && !empty($data['password']))) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    } elseif ($action === 'edit' && empty($data['password'])) {
        unset($data['password']);
    }
    
    if ($action === 'create') {
        $admin = new Admin($data);
        if ($admin->save()) {
            $_SESSION['success'] = "تم إنشاء المسؤول بنجاح";
        } else {
            $_SESSION['error'] = "فشل إنشاء المسؤول";
        }
    } elseif ($action === 'edit') {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $admin = Admin::find($id);
            if ($admin) {
                $admin->username = $data['username'];
                $admin->email = $data['email'];
                if (isset($data['password'])) {
                    $admin->password = $data['password'];
                }
                if ($admin->save()) {
                    $_SESSION['success'] = "تم تعديل بيانات المسؤول بنجاح";
                } else {
                    $_SESSION['error'] = "فشل تعديل بيانات المسؤول";
                }
            } else {
                $_SESSION['error'] = "المسؤول غير موجود";
            }
        }
    }
    header("Location: " . gotolink('admin.admins'));
    exit;
}

ob_start();
$viewAction = $_GET['action'] ?? 'list';
if ($viewAction === 'edit' && isset($_GET['id'])) {
    $editAdmin = Admin::find($_GET['id']);
    if (!$editAdmin) {
        $_SESSION['error'] = "المسؤول غير موجود";
        header("Location: " . gotolink('admin.admins'));
        exit;
    }
}
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-teal-700">إدارة المسؤولين</h1>
    <?php if ($viewAction === 'list'): ?>
        <a href="<?= gotolink('admin.admins', ['action' => 'create']); ?>" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
            <i class="fas fa-plus ml-2"></i> إضافة مسؤول جديد
        </a>
    <?php else: ?>
        <a href="<?= gotolink('admin.admins'); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            <i class="fas fa-arrow-left ml-2"></i> الرجوع للقائمة
        </a>
    <?php endif; ?>
</div>

<?php if ($viewAction === 'list'): ?>
    <?php $admins = Admin::all(); ?>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-teal-50">
                <tr>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الرقم</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">اسم المسؤول</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">البريد الإلكتروني</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($admins)): ?>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($admin->id); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($admin->username); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($admin->email); ?></td>
                            <td class="px-4 py-2 text-right">
                                <a href="<?= gotolink('admin.admins', ['action' => 'edit', 'id' => $admin->id]); ?>" class="text-blue-600 hover:underline mr-2">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <a href="<?= gotolink('admin.admins.delete', ['id' => $admin->id]); ?>" class="text-red-600 hover:underline" onclick="return confirm('هل أنت متأكد من حذف المسؤول؟');">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-600">لا يوجد مسؤولين بعد.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<?php elseif ($viewAction === 'create' || $viewAction === 'edit'):
    $formTitle = ($viewAction === 'create') ? "إضافة مسؤول جديد" : "تعديل بيانات المسؤول";
    $adminData = [
        'id'       => $viewAction === 'edit' ? $editAdmin->id : '',
        'username' => $viewAction === 'edit' ? $editAdmin->username : '',
        'email'    => $viewAction === 'edit' ? $editAdmin->email : '',
        'password' => '',
    ];
?>
    <div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-teal-700 mb-4"><?= $formTitle; ?></h2>
        <form action="<?= gotolink('admin.admins'); ?>" method="POST" class="space-y-4">
            <?php if ($viewAction === 'edit'): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($adminData['id']); ?>">
            <?php endif; ?>
            <input type="hidden" name="form_action" value="<?= $viewAction; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Username -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="username">اسم المسؤول</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($adminData['username']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Email -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($adminData['email']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Password -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="password">
                        كلمة المرور <?php echo ($viewAction === 'edit') ? '(اتركها فارغة إذا لم تريد التغيير)' : ''; ?>
                    </label>
                    <input type="password" id="password" name="password" <?= ($viewAction === 'create') ? 'required' : ''; ?> class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
                    <?= ($viewAction === 'create') ? 'إنشاء المسؤول' : 'تعديل المسؤول'; ?>
                </button>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
admin_layout($content, ['title' => $title, 'active' => $active]);
?>
