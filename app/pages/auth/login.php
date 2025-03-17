<?php
use App\Tables\Route;

$active = 'admin.routes';
$title = 'إدارة الطرق - لوحة الإدارة';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['form_action'] ?? '';
    $data = [
        'start_location' => trim($_POST['start_location'] ?? ''),
        'end_location'   => trim($_POST['end_location'] ?? ''),
        'description'    => trim($_POST['description'] ?? '')
    ];
    foreach ($data as $key => $value) {
        if ($value === '') {
            $_SESSION['error'] = "جميع الحقول مطلوبة.";
            header("Location: " . gotolink('admin.routes', ['action' => $action, 'id' => $_POST['id'] ?? null]));
            exit;
        }
    }
    
    if ($action === 'create') {
        $route = new Route($data);
        $_SESSION['success'] = $route->save() ? "تم إنشاء الطريق بنجاح" : "فشل إنشاء الطريق";
    } elseif ($action === 'edit') {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $route = Route::find($id);
            if ($route) {
                $route->start_location = $data['start_location'];
                $route->end_location = $data['end_location'];
                $route->description = $data['description'];
                $_SESSION['success'] = $route->save() ? "تم تعديل بيانات الطريق بنجاح" : "فشل تعديل بيانات الطريق";
            } else {
                $_SESSION['error'] = "الطريق غير موجود";
            }
        }
    }
    header("Location: " . gotolink('admin.routes'));
    exit;
}

ob_start();
$viewAction = $_GET['action'] ?? 'list';
if ($viewAction === 'edit' && isset($_GET['id'])) {
    $editRoute = Route::find($_GET['id']);
    if (!$editRoute) {
        $_SESSION['error'] = "الطريق غير موجود";
        header("Location: " . gotolink('admin.routes'));
        exit;
    }
}
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-teal-700">إدارة الطرق</h1>
    <?php if ($viewAction === 'list'): ?>
        <a href="<?= gotolink('admin.routes', ['action' => 'create']); ?>" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
            <i class="fas fa-plus ml-2"></i> إضافة طريق جديد
        </a>
    <?php else: ?>
        <a href="<?= gotolink('admin.routes'); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            <i class="fas fa-arrow-left ml-2"></i> الرجوع للقائمة
        </a>
    <?php endif; ?>
</div>

<?php if ($viewAction === 'list'): ?>
    <?php $routes = Route::all(); ?>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-teal-50">
                <tr>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الرقم</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الموقع الابتدائي</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الموقع النهائي</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الوصف</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($routes)): ?>
                    <?php foreach ($routes as $route): ?>
                        <tr>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($route->id); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($route->start_location); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($route->end_location); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($route->description); ?></td>
                            <td class="px-4 py-2 text-right">
                                <a href="<?= gotolink('admin.routes', ['action' => 'edit', 'id' => $route->id]); ?>" class="text-blue-600 hover:underline mr-2">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <a href="<?= gotolink('admin.routes.delete', ['id' => $route->id]); ?>" class="text-red-600 hover:underline" onclick="return confirm('هل أنت متأكد من حذف الطريق؟');">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-600">لا توجد طرق بعد.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($viewAction === 'create' || $viewAction === 'edit'):
    $formTitle = ($viewAction === 'create') ? "إضافة طريق جديد" : "تعديل بيانات الطريق";
    $routeData = [
        'id'            => $viewAction === 'edit' ? $editRoute->id : '',
        'start_location'=> $viewAction === 'edit' ? $editRoute->start_location : '',
        'end_location'  => $viewAction === 'edit' ? $editRoute->end_location : '',
        'description'   => $viewAction === 'edit' ? $editRoute->description : ''
    ];
?>
    <div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-teal-700 mb-4"><?= $formTitle; ?></h2>
        <form action="<?= gotolink('admin.routes'); ?>" method="POST" class="space-y-4">
            <?php if ($viewAction === 'edit'): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($routeData['id']); ?>">
            <?php endif; ?>
            <input type="hidden" name="form_action" value="<?= $viewAction; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="start_location">الموقع الابتدائي</label>
                    <input type="text" id="start_location" name="start_location" value="<?= htmlspecialchars($routeData['start_location']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="end_location">الموقع النهائي</label>
                    <input type="text" id="end_location" name="end_location" value="<?= htmlspecialchars($routeData['end_location']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-teal-700 font-semibold mb-1" for="description">الوصف</label>
                    <textarea id="description" name="description" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600"><?= htmlspecialchars($routeData['description']); ?></textarea>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
                    <?= ($viewAction === 'create') ? 'إنشاء الطريق' : 'تعديل الطريق'; ?>
                </button>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
user_layout($content, ['title' => $title, 'active' => $active]);
?>
