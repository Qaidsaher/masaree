<?php
use App\Tables\Booking;
use App\Tables\Student;
use App\Tables\Trip;

$active = 'admin.bookings';
$title = 'إدارة الحجوزات - لوحة الإدارة';

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['form_action'] ?? '';
    $data = [
        'student_id'     => trim($_POST['student_id'] ?? ''),
        'trip_id'        => trim($_POST['trip_id'] ?? ''),
        'booking_date'   => trim($_POST['booking_date'] ?? ''),
        'booking_status' => trim($_POST['booking_status'] ?? '')
    ];
    foreach ($data as $key => $value) {
        if ($value === '') {
            $_SESSION['error'] = "جميع الحقول مطلوبة.";
            header("Location: " . gotolink('admin.bookings', ['action' => $action, 'id' => $_POST['id'] ?? null]));
            exit;
        }
    }
    
    if ($action === 'create') {
        $booking = new Booking($data);
        $_SESSION['success'] = $booking->save() ? "تم إنشاء الحجز بنجاح" : "فشل إنشاء الحجز";
    } elseif ($action === 'edit') {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $booking = Booking::find($id);
            if ($booking) {
                $booking->student_id = $data['student_id'];
                $booking->trip_id = $data['trip_id'];
                $booking->booking_date = $data['booking_date'];
                $booking->booking_status = $data['booking_status'];
                $_SESSION['success'] = $booking->save() ? "تم تعديل بيانات الحجز بنجاح" : "فشل تعديل بيانات الحجز";
            } else {
                $_SESSION['error'] = "الحجز غير موجود";
            }
        }
    }
    header("Location: " . gotolink('admin.bookings'));
    exit;
}

ob_start();
$viewAction = $_GET['action'] ?? 'list';
if ($viewAction === 'edit' && isset($_GET['id'])) {
    $editBooking = Booking::find($_GET['id']);
    if (!$editBooking) {
        $_SESSION['error'] = "الحجز غير موجود";
        header("Location: " . gotolink('admin.bookings'));
        exit;
    }
}

// Get lists for drop-downs
$students = Student::all();
$trips = Trip::all();
?>

<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-teal-700">إدارة الحجوزات</h1>
    <?php if ($viewAction === 'list'): ?>
        <a href="<?= gotolink('admin.bookings', ['action' => 'create']); ?>" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
            <i class="fas fa-plus ml-2"></i> إضافة حجز جديد
        </a>
    <?php else: ?>
        <a href="<?= gotolink('admin.bookings'); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            <i class="fas fa-arrow-left ml-2"></i> الرجوع للقائمة
        </a>
    <?php endif; ?>
</div>

<?php if ($viewAction === 'list'): ?>
    <?php $bookings = Booking::all(); ?>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-teal-50">
                <tr>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الرقم</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الطالب</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الرحلة</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">تاريخ الحجز</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الحالة</th>
                    <th class="px-4 py-2 text-right text-sm font-bold text-teal-700">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr class="hover:bg-teal-50 transition-colors">
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($booking->id); ?></td>
                            <td class="px-4 py-2 text-right">
                                <?php
                                    $student = Student::find($booking->student_id);
                                    echo $student ? htmlspecialchars($student->name) : 'غير متوفر';
                                ?>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <?php
                                    $trip = Trip::find($booking->trip_id);
                                    echo $trip ? htmlspecialchars($trip->trip_date . ' ' . $trip->trip_time) : 'غير متوفر';
                                ?>
                            </td>
                            <td class="px-4 py-2 text-right"><?= htmlspecialchars($booking->booking_date); ?></td>
                            <td class="px-4 py-2 text-right">
                                <?php 
                                    $status = $booking->booking_status;
                                    // Set badge class based on Arabic status
                                    if ($status === 'قيد الانتظار') {
                                        $badgeClass = 'bg-yellow-500';
                                    } elseif ($status === 'مؤكد') {
                                        $badgeClass = 'bg-green-500';
                                    } elseif ($status === 'ملغى') {
                                        $badgeClass = 'bg-red-500';
                                    } else {
                                        $badgeClass = 'bg-gray-500';
                                    }
                                ?>
                                <span class="inline-block px-3 py-1 rounded-full text-white text-sm <?= $badgeClass; ?>">
                                    <?= htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <a href="<?= gotolink('admin.bookings', ['action' => 'edit', 'id' => $booking->id]); ?>" class="text-blue-600 hover:underline mr-2">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <a href="<?= gotolink('admin.bookings.delete', ['id' => $booking->id]); ?>" class="text-red-600 hover:underline" onclick="return confirm('هل أنت متأكد من حذف الحجز؟');">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center text-gray-600">لا توجد حجوزات بعد.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php elseif ($viewAction === 'create' || $viewAction === 'edit'):
    $formTitle = ($viewAction === 'create') ? "إضافة حجز جديد" : "تعديل بيانات الحجز";
    $bookingData = [
        'id'             => $viewAction === 'edit' ? $editBooking->id : '',
        'student_id'     => $viewAction === 'edit' ? $editBooking->student_id : '',
        'trip_id'        => $viewAction === 'edit' ? $editBooking->trip_id : '',
        'booking_date'   => $viewAction === 'edit' ? $editBooking->booking_date : '',
        'booking_status' => $viewAction === 'edit' ? $editBooking->booking_status : ''
    ];
?>
    <div class="bg-white p-6 rounded-lg shadow max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-teal-700 mb-4"><?= $formTitle; ?></h2>
        <form action="<?= gotolink('admin.bookings'); ?>" method="POST" class="space-y-4">
            <?php if ($viewAction === 'edit'): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($bookingData['id']); ?>">
            <?php endif; ?>
            <input type="hidden" name="form_action" value="<?= $viewAction; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Student Selection -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="student_id">الطالب</label>
                    <select id="student_id" name="student_id" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                        <option value="">اختر الطالب</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student->id; ?>" <?= ($viewAction === 'edit' && $bookingData['student_id'] == $student->id) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($student->name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Trip Selection -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="trip_id">الرحلة</label>
                    <select id="trip_id" name="trip_id" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                        <option value="">اختر الرحلة</option>
                        <?php foreach ($trips as $trip): ?>
                            <option value="<?= $trip->id; ?>" <?= ($viewAction === 'edit' && $bookingData['trip_id'] == $trip->id) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($trip->trip_date . ' ' . $trip->trip_time); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Booking Date -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="booking_date">تاريخ الحجز</label>
                    <input type="date" id="booking_date" name="booking_date" value="<?= htmlspecialchars($bookingData['booking_date']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                </div>
                <!-- Booking Status -->
                <div>
                    <label class="block text-teal-700 font-semibold mb-1" for="booking_status">الحالة</label>
                    <select id="booking_status" name="booking_status" required class="w-full px-3 py-2 border rounded focus:outline-none focus:border-teal-600">
                        <option value="">اختر الحالة</option>
                        <option value="قيد الانتظار" <?= ($viewAction === 'edit' && $bookingData['booking_status'] === 'قيد الانتظار') ? 'selected' : ''; ?>>قيد الانتظار</option>
                        <option value="مؤكد" <?= ($viewAction === 'edit' && $bookingData['booking_status'] === 'مؤكد') ? 'selected' : ''; ?>>مؤكد</option>
                        <option value="ملغى" <?= ($viewAction === 'edit' && $bookingData['booking_status'] === 'ملغى') ? 'selected' : ''; ?>>ملغى</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded">
                    <?= ($viewAction === 'create') ? 'إنشاء الحجز' : 'تعديل الحجز'; ?>
                </button>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
admin_layout($content, ['title' => $title, 'active' => $active]);
?>
