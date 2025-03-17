<?php
use App\Tables\Driver;

$active = 'admin.drivers';
$title = 'إدارة السائقين - لوحة الإدارة';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['form_action'] ?? '';
    $data = [
        'name'  => trim($_POST['name'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'email' => trim($_POST['email'] ?? '')
    ];
    foreach ($data as $key => $value) {
        if ($value === '') {
            $_SESSION['error'] = "جميع الحقول مطلوبة.";
            header("Location: " . gotolink('admin.drivers', ['action' => $action, 'id' => $_POST['id'] ?? null]));
            exit;
        }
    }
    if ($action === 'create') {
        $driver = new Driver($data);
        $_SESSION['success'] = $driver->save() ? "تم إنشاء السائق بنجاح" : "فشل إنشاء السائق";
    } elseif ($action === 'edit') {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $driver = Driver::find($id);
            if ($driver) {
                $driver->fill($data);
                $_SESSION['success'] = $driver->save() ? "تم تعديل بيانات السائق بنجاح" : "فشل تعديل بيانات السائق";
            } else {
                $_SESSION['error'] = "السائق غير موجود";
            }
        }
    }
    header("Location: " . gotolink('admin.drivers'));
    exit;
}

ob_start();
$viewAction = $_GET['action'] ?? 'list';
if ($viewAction === 'edit' && isset($_GET['id'])) {
    $editDriver = Driver::find($_GET['id']);
    if (!$editDriver) {
        $_SESSION['error'] = "السائق غير موجود";
        header("Location: " . gotolink('admin.drivers'));
        exit;
    }
}
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-teal-700">إدارة السائقين</h1>
    <?php if ($viewAction === 'list'): ?>
        <a href="<?= gotolink('admin.drivers', ['action' => 'create']); ?>" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
            <i class="fas fa-plus ml-2"></i> إضافة سائق جديد
        </a>
    <?php else: ?>
        <a href="<?= gotolink('admin.drivers'); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            <i class="fas fa-arrow-left ml-2"></i> الرجوع للقائمة
        </a>
    <?php endif; ?>
</div>

<?php if ($viewAction === 'list'): ?>
    <?php $drivers = Driver::all(); ?>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-teal-50">
                <tr>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الرقم</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الاسم</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الهاتف</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">البريد الإلكتروني</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($drivers)): ?>
                    <?php foreach ($drivers as $driver): ?>
                        <tr>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($driver->id); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($driver->name); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($driver->phone); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($driver->email); ?></td>
                            <td class="px-4 py-2 text-right">
                                <a href="<?= gotolink('admin.drivers', ['action' => 'edit', 'id' => $driver->id]); ?>" class="text-blue-600 hover:underline mr-2">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <a href="<?= gotolink('admin.drivers.delete', ['id' => $driver->id]); ?>" class="text-red-600 hover:underline" onclick="return confirm('هل أنت متأكد من حذف السائق؟');">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-600">لا يوجد سائقين بعد.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($viewAction === 'create' || $viewAction === 'edit'):
    $formTitle = ($viewAction === 'create') ? "إضافة سائق جديد" : "تعديل بيانات السائق";
    $driverData = [
        'id'    => $viewAction === 'edit' ? $editDriver->id : '',
        'name'  => $viewAction === 'edit' ? $editDriver->name : '',
        'phone' => $viewAction === 'edit' ? $editDriver->phone : '',
        'email' => $viewAction === 'edit' ? $editDriver->email : '',
    ];
?>
    <div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-teal-700 mb-4"><?= $formTitle; ?></h2>
        <form action="<?= gotolink('admin.drivers'); ?>" method="POST" class="space-y-4">
            <?php if ($viewAction === 'edit'): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($driverData['id']); ?>">
            <?php endif; ?>
            <input type="hidden" name="form_action" value="<?= $viewAction; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="name">الاسم</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($driverData['name']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="phone">الهاتف</label>
                    <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($driverData['phone']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-teal-700 font-semibold mb-1" for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($driverData['email']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
                    <?= ($viewAction === 'create') ? 'إنشاء السائق' : 'تعديل السائق'; ?>
                </button>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
admin_layout($content, ['title' => $title, 'active' => $active]);
?>
