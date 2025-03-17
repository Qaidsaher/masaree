<?php
$title = 'ملفي الشخصي - لوحة الطالب';
$active = 'student.profile';
ob_start();

$user = auth()->student(); // Assuming auth()->student() returns the current student's data
?>
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
  <div class="border-b pb-4 mb-4">
    <h1 class="text-3xl font-bold text-teal-700">ملفي الشخصي</h1>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
    <div class="flex flex-col">
      <span class="font-semibold">الاسم:</span>
      <span><?= htmlspecialchars($user->name); ?></span>
    </div>
    <div class="flex flex-col">
      <span class="font-semibold">البريد الإلكتروني:</span>
      <span><?= htmlspecialchars($user->email); ?></span>
    </div>
    <div class="flex flex-col">
      <span class="font-semibold">الهاتف:</span>
      <span><?= htmlspecialchars($user->phone); ?></span>
    </div>
    <div class="flex flex-col">
      <span class="font-semibold">العنوان:</span>
      <span><?= htmlspecialchars($user->address); ?></span>
    </div>
    <div class="flex flex-col">
      <span class="font-semibold">الحي/المدينة:</span>
      <span><?= htmlspecialchars($user->district); ?></span>
    </div>
    <div class="flex flex-col">
      <span class="font-semibold">الشارع:</span>
      <span><?= htmlspecialchars($user->street); ?></span>
    </div>
  </div>
  <div class="mt-6 text-center">
    <a href="<?= gotolink('student.edit_profile'); ?>" class="inline-block bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded">
      <i class="fas fa-edit mr-2"></i> تعديل الملف
    </a>
  </div>
</div>
<?php
$content = ob_get_clean();
student_layout($content, ['title' => $title, 'active' => $active]);
?>
