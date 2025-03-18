<?php
use App\Tables\Bus;
use App\Tables\Driver; // Make sure this exists and returns all drivers.
$active = 'admin.buses';
$title = 'إدارة الحافلات - لوحة الإدارة';

// Process form submission for create/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['form_action'] ?? '';
    $data = [
        'bus_number'    => trim($_POST['bus_number'] ?? ''),
        'capacity'      => trim($_POST['capacity'] ?? ''),
        'license_plate' => trim($_POST['license_plate'] ?? ''),
        'driver_id'     => trim($_POST['driver_id'] ?? '')
    ];
    foreach ($data as $key => $value) {
        if ($value === '') {
            $_SESSION['error'] = "جميع الحقول مطلوبة.";
            header("Location: " . gotolink('admin.buses', ['action' => $action, 'id' => $_POST['id'] ?? null]));
            exit;
        }
    }
    
    if ($action === 'create') {
        $bus = new Bus($data);
        $_SESSION['success'] = $bus->save() ? "تم إنشاء الحافلة بنجاح" : "فشل إنشاء الحافلة";
    } elseif ($action === 'edit') {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $bus = Bus::find($id);
            if ($bus) {
                $bus->bus_number    = $data['bus_number'];
                $bus->capacity      = $data['capacity'];
                $bus->license_plate = $data['license_plate'];
                $bus->driver_id     = $data['driver_id'];
                $_SESSION['success'] = $bus->save() ? "تم تعديل بيانات الحافلة بنجاح" : "فشل تعديل بيانات الحافلة";
            } else {
                $_SESSION['error'] = "الحافلة غير موجودة";
            }
        }
    }
    header("Location: " . gotolink('admin.buses'));
    exit;
}

ob_start();
$viewAction = $_GET['action'] ?? 'list';
if ($viewAction === 'edit' && isset($_GET['id'])) {
    $editBus = Bus::find($_GET['id']);
    if (!$editBus) {
        $_SESSION['error'] = "الحافلة غير موجودة";
        header("Location: " . gotolink('admin.buses'));
        exit;
    }
}

// Retrieve drivers list for the select dropdown in the form.
$drivers = Driver::all();
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-teal-700">إدارة الحافلات</h1>
    <?php if ($viewAction === 'list'): ?>
        <a href="<?= gotolink('admin.buses', ['action' => 'create']); ?>" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
            <i class="fas fa-plus ml-2"></i> إضافة حافلة جديدة
        </a>
    <?php else: ?>
        <a href="<?= gotolink('admin.buses'); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            <i class="fas fa-arrow-left ml-2"></i> الرجوع للقائمة
        </a>
    <?php endif; ?>
</div>

<?php if ($viewAction === 'list'): ?>
    <?php $buses = Bus::all(); ?>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-teal-50">
                <tr>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الرقم</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">رقم الحافلة</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">السعة</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">لوحة الترخيص</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">السائق</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($buses)): ?>
                    <?php foreach ($buses as $bus): ?>
                        <tr>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($bus->id); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($bus->bus_number); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($bus->capacity); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($bus->license_plate); ?></td>
                            <td class="px-4 py-2 text-right">
                                <?php 
                                    $driver = $bus->getDriver(); // This should return the driver object.
                                    echo htmlspecialchars($driver->name ?? 'غير محدد'); 
                                ?>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <a href="<?= gotolink('admin.buses', ['action' => 'edit', 'id' => $bus->id]); ?>" class="text-blue-600 hover:underline mr-2">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <a href="<?= gotolink('admin.buses.delete', ['id' => $bus->id]); ?>" class="text-red-600 hover:underline" onclick="return confirm('هل أنت متأكد من حذف الحافلة؟');">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center text-gray-600">لا توجد حافلات بعد.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($viewAction === 'create' || $viewAction === 'edit'):
    $formTitle = ($viewAction === 'create') ? "إضافة حافلة جديدة" : "تعديل بيانات الحافلة";
    $busData = [
        'id'            => $viewAction === 'edit' ? $editBus->id : '',
        'bus_number'    => $viewAction === 'edit' ? $editBus->bus_number : '',
        'capacity'      => $viewAction === 'edit' ? $editBus->capacity : '',
        'license_plate' => $viewAction === 'edit' ? $editBus->license_plate : '',
        'driver_id'     => $viewAction === 'edit' ? $editBus->driver_id : ''
    ];
?>
    <div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-teal-700 mb-4"><?= $formTitle; ?></h2>
        <form action="<?= gotolink('admin.buses'); ?>" method="POST" class="space-y-4">
            <?php if ($viewAction === 'edit'): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($busData['id']); ?>">
            <?php endif; ?>
            <input type="hidden" name="form_action" value="<?= $viewAction; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="bus_number" class="block text-teal-700 font-semibold mb-1">رقم الحافلة</label>
                    <input type="text" id="bus_number" name="bus_number" value="<?= htmlspecialchars($busData['bus_number']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <div>
                    <label for="capacity" class="block text-teal-700 font-semibold mb-1">السعة</label>
                    <input type="number" id="capacity" name="capacity" value="<?= htmlspecialchars($busData['capacity']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <div>
                    <label for="license_plate" class="block text-teal-700 font-semibold mb-1">لوحة الترخيص</label>
                    <input type="text" id="license_plate" name="license_plate" value="<?= htmlspecialchars($busData['license_plate']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <div>
                    <label for="driver_id" class="block text-teal-700 font-semibold mb-1">السائق</label>
                    <select id="driver_id" name="driver_id" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                        <option value="">اختر السائق</option>
                        <?php foreach ($drivers as $driver): ?>
                            <option value="<?= htmlspecialchars($driver->id); ?>" <?= ($busData['driver_id'] == $driver->id) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($driver->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
                    <?= ($viewAction === 'create') ? 'إنشاء الحافلة' : 'تعديل الحافلة'; ?>
                </button>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
admin_layout($content, ['title' => $title, 'active' => $active]);
?>
