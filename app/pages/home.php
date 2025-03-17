<?php
// تعيين الصفحة النشطة للنافبار وتعيين العنوان
$active = 'home';
$title = 'الرئيسية - الرياض الخضراء';

// بدء تخزين المحتوى
ob_start();
?>

<!-- Hero Section: full width background -->
<div class="p-8">
<a href="<?= gotolink('admin.home'); ?>" class="text-2xl font-bold flex items-center">
            <i class="fas fa-bus-alt ml-2"></i> مسرى
          </a>
</div>


<?php
$content = ob_get_clean();
include __DIR__ . '/layout/guest.php';
?>
