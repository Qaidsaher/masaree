<?php
use App\Tables\Trip;

$active = 'admin.trips';
$title = 'إدارة الرحلات - لوحة الإدارة';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['form_action'] ?? '';
    $data = [
        'trip_date'    => trim($_POST['trip_date'] ?? ''),
        'trip_time'    => trim($_POST['trip_time'] ?? ''),
        'is_full'      => isset($_POST['is_full']) ? 1 : 0,
        'max_students' => trim($_POST['max_students'] ?? ''),
        'bus_id'       => trim($_POST['bus_id'] ?? ''),
        'route_id'     => trim($_POST['route_id'] ?? ''),
        'status'       => trim($_POST['status'] ?? '')
    ];
    
    foreach ($data as $key => $value) {
        if ($key !== 'is_full' && $value === '') {
            $_SESSION['error'] = "جميع الحقول مطلوبة.";
            header("Location: " . gotolink('admin.trips', ['action' => $action, 'id' => $_POST['id'] ?? null]));
            exit;
        }
    }
    
    if ($action === 'create') {
        $trip = new Trip($data);
        if ($trip->save()) {
            $_SESSION['success'] = "تم إنشاء الرحلة بنجاح";
        } else {
            $_SESSION['error'] = "فشل إنشاء الرحلة";
        }
    } elseif ($action === 'edit') {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $trip = Trip::find($id);
            if ($trip) {
                $trip->trip_date = $data['trip_date'];
                $trip->trip_time = $data['trip_time'];
                $trip->is_full = $data['is_full'];
                $trip->max_students = $data['max_students'];
                $trip->bus_id = $data['bus_id'];
                $trip->route_id = $data['route_id'];
                $trip->status = $data['status'];
                if ($trip->save()) {
                    $_SESSION['success'] = "تم تعديل بيانات الرحلة بنجاح";
                } else {
                    $_SESSION['error'] = "فشل تعديل بيانات الرحلة";
                }
            } else {
                $_SESSION['error'] = "الرحلة غير موجودة";
            }
        }
    }
    header("Location: " . gotolink('admin.trips'));
    exit;
}

ob_start();
$viewAction = $_GET['action'] ?? 'list';
if ($viewAction === 'edit' && isset($_GET['id'])) {
    $editTrip = Trip::find($_GET['id']);
    if (!$editTrip) {
        $_SESSION['error'] = "الرحلة غير موجودة";
        header("Location: " . gotolink('admin.trips'));
        exit;
    }
}
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-teal-700">إدارة الرحلات</h1>
    <?php if ($viewAction === 'list'): ?>
        <a href="<?= gotolink('admin.trips', ['action' => 'create']); ?>" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
            <i class="fas fa-plus ml-2"></i> إضافة رحلة جديدة
        </a>
    <?php else: ?>
        <a href="<?= gotolink('admin.trips'); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            <i class="fas fa-arrow-left ml-2"></i> الرجوع للقائمة
        </a>
    <?php endif; ?>
</div>

<?php if ($viewAction === 'list'): ?>
    <?php $trips = Trip::all(); ?>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-teal-50">
                <tr>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الرقم</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">التاريخ</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الوقت</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الحالة</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الحد الأقصى</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">رقم الحافلة</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">معرف الطريق</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($trips)): ?>
                    <?php foreach ($trips as $trip): ?>
                        <tr>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($trip->id); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($trip->trip_date); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($trip->trip_time); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($trip->status); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($trip->max_students); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($trip->bus_id); ?></td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($trip->route_id); ?></td>
                            <td class="px-4 py-2 text-right">
                                <a href="<?= gotolink('admin.trips', ['action' => 'edit', 'id' => $trip->id]); ?>" class="text-blue-600 hover:underline mr-2">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <a href="<?= gotolink('admin.trips.delete', ['id' => $trip->id]); ?>" class="text-red-600 hover:underline" onclick="return confirm('هل أنت متأكد من حذف الرحلة؟');">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="px-4 py-2 text-center text-gray-600">لا توجد رحلات بعد.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($viewAction === 'create' || $viewAction === 'edit'):
    $formTitle = ($viewAction === 'create') ? "إضافة رحلة جديدة" : "تعديل بيانات الرحلة";
    $tripData = [
        'id'          => $viewAction === 'edit' ? $editTrip->id : '',
        'trip_date'   => $viewAction === 'edit' ? $editTrip->trip_date : '',
        'trip_time'   => $viewAction === 'edit' ? $editTrip->trip_time : '',
        'is_full'     => $viewAction === 'edit' ? $editTrip->is_full : 0,
        'max_students'=> $viewAction === 'edit' ? $editTrip->max_students : '',
        'bus_id'      => $viewAction === 'edit' ? $editTrip->bus_id : '',
        'route_id'    => $viewAction === 'edit' ? $editTrip->route_id : '',
        'status'      => $viewAction === 'edit' ? $editTrip->status : ''
    ];
?>
    <div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-teal-700 mb-4"><?= $formTitle; ?></h2>
        <form action="<?= gotolink('admin.trips'); ?>" method="POST" class="space-y-4">
            <?php if ($viewAction === 'edit'): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($tripData['id']); ?>">
            <?php endif; ?>
            <input type="hidden" name="form_action" value="<?= $viewAction; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Trip Date -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="trip_date">تاريخ الرحلة</label>
                    <input type="date" id="trip_date" name="trip_date" value="<?= htmlspecialchars($tripData['trip_date']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Trip Time -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="trip_time">وقت الرحلة</label>
                    <input type="time" id="trip_time" name="trip_time" value="<?= htmlspecialchars($tripData['trip_time']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Max Students -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="max_students">الحد الأقصى للطلاب</label>
                    <input type="number" id="max_students" name="max_students" value="<?= htmlspecialchars($tripData['max_students']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Bus ID -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="bus_id">رقم الحافلة</label>
                    <input type="number" id="bus_id" name="bus_id" value="<?= htmlspecialchars($tripData['bus_id']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Route ID -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="route_id">معرف الطريق</label>
                    <input type="number" id="route_id" name="route_id" value="<?= htmlspecialchars($tripData['route_id']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Status -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="status">الحالة</label>
                    <select id="status" name="status" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                        <option value="">اختر الحالة</option>
                        <option value="مجدول" <?= ($tripData['status'] === 'مجدول') ? 'selected' : ''; ?>>مجدول</option>
                        <option value="مكتمل" <?= ($tripData['status'] === 'مكتمل') ? 'selected' : ''; ?>>مكتمل</option>
                        <option value="ملغى" <?= ($tripData['status'] === 'ملغى') ? 'selected' : ''; ?>>ملغى</option>
                    </select>
                </div>
                <!-- Is Full Checkbox -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_full" name="is_full" <?= ($viewAction === 'edit' && $tripData['is_full']) ? 'checked' : ''; ?> class="mr-2">
                    <label for="is_full" class="text-teal-700 font-semibold">ممتلئة</label>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
                    <?= ($viewAction === 'create') ? 'إنشاء الرحلة' : 'تعديل الرحلة'; ?>
                </button>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
admin_layout($content, ['title' => $title, 'active' => $active]);
?>
