<?php
$title = 'تعديل الملف الشخصي - لوحة الطالب';
$active = 'student.edit_profile';
ob_start();

$user = auth()->student(); // Assuming auth()->student() returns the current student's data
?>
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
  <div class="border-b pb-4 mb-4">
    <h1 class="text-3xl font-bold text-teal-700">تعديل الملف الشخصي</h1>
  </div>
  <form action="<?= gotolink('student.edit_profile'); ?>" method="POST" class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <label for="fullName" class="block text-teal-700 font-semibold mb-1">الاسم</label>
        <input type="text" id="fullName" name="fullName" value="<?= htmlspecialchars($user->name); ?>" required class="w-full px-4 py-2 border rounded focus:outline-none focus:border-teal-600">
      </div>
      <div>
        <label for="email" class="block text-teal-700 font-semibold mb-1">البريد الإلكتروني</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->email); ?>" required class="w-full px-4 py-2 border rounded focus:outline-none focus:border-teal-600">
      </div>
      <div>
        <label for="phone" class="block text-teal-700 font-semibold mb-1">الهاتف</label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($user->phone); ?>" required class="w-full px-4 py-2 border rounded focus:outline-none focus:border-teal-600">
      </div>
      <div>
        <label for="address" class="block text-teal-700 font-semibold mb-1">العنوان</label>
        <input type="text" id="address" name="address" value="<?= htmlspecialchars($user->address); ?>" required class="w-full px-4 py-2 border rounded focus:outline-none focus:border-teal-600">
      </div>
      <div>
        <label for="district" class="block text-teal-700 font-semibold mb-1">الحي/المدينة</label>
        <input type="text" id="district" name="district" value="<?= htmlspecialchars($user->district); ?>" required class="w-full px-4 py-2 border rounded focus:outline-none focus:border-teal-600">
      </div>
      <div>
        <label for="street" class="block text-teal-700 font-semibold mb-1">الشارع</label>
        <input type="text" id="street" name="street" value="<?= htmlspecialchars($user->street); ?>" required class="w-full px-4 py-2 border rounded focus:outline-none focus:border-teal-600">
      </div>
    </div>
    <!-- Optionally add a password field for changing the password -->
    <div>
      <label for="password" class="block text-teal-700 font-semibold mb-1">كلمة المرور <span class="text-sm text-gray-500">(اتركها فارغة إذا لم تريد التغيير)</span></label>
      <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-teal-600">
    </div>
    <div class="flex justify-end">
      <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded">
        حفظ التعديلات
      </button>
    </div>
  </form>
</div>
<?php
$content = ob_get_clean();
student_layout($content, ['title' => $title, 'active' => $active]);
?>
