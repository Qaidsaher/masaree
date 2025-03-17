<?php
// تعيين الصفحة النشطة للنافبار وتعيين العنوان
$active = 'home';
$title = 'الرئيسية - الرياض الخضراء';

// بدء تخزين المحتوى
ob_start();
?>

  <!-- Hero Section -->
  <section id="hero" class="pt-24 pb-0 bg-cover bg-center min-h-[70vh] flex flex-col justify-center items-end" style="background-image: url('<?php echo asset('images/10.jpeg')?>');">
    <div class="bg-teal-900 bg-opacity-60  w-full">
      <div class="max-w-7xl mx-auto p-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">تجربة نقل مبتكرة مع مسرى</h1>
        <p class="text-xl md:text-2xl text-gray-200 mb-8">حلول ذكية للنقل تجمع بين الأمان، الراحة، والسرعة.</p>
        <a href="#contact" class="bg-white text-teal-700 font-bold py-1 px-6 rounded-full hover:bg-gray-100 transition">ابدأ الآن</a>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
      <h2 class="text-3xl font-bold text-center text-teal-700 mb-12">خدماتنا</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Each service card -->
        <div class="bg-gray-100 p-6 rounded-lg shadow">
          <div class="text-teal-700 text-4xl mb-4">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">أمان عالي</h3>
          <p class="text-gray-700">نضمن أعلى معايير الأمان والخصوصية لراحتك.</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg shadow">
          <div class="text-teal-700 text-4xl mb-4">
            <i class="fas fa-bolt"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">سرعة فائقة</h3>
          <p class="text-gray-700">تجربة نقل سريعة باستخدام أحدث التقنيات.</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg shadow">
          <div class="text-teal-700 text-4xl mb-4">
            <i class="fas fa-mobile-alt"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">تطبيق متجاوب</h3>
          <p class="text-gray-700">سهولة الوصول لخدماتنا من جميع الأجهزة.</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg shadow">
          <div class="text-teal-700 text-4xl mb-4">
            <i class="fas fa-route"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">شبكة واسعة</h3>
          <p class="text-gray-700">تغطية شاملة لتلبية كافة احتياجات التنقل.</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg shadow">
          <div class="text-teal-700 text-4xl mb-4">
            <i class="fas fa-headset"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">دعم فني متواصل</h3>
          <p class="text-gray-700">فريق دعم جاهز لمساعدتك في كل وقت.</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg shadow">
          <div class="text-teal-700 text-4xl mb-4">
            <i class="fas fa-cogs"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">تقنيات متقدمة</h3>
          <p class="text-gray-700">نستخدم أحدث التقنيات لتحسين تجربتك.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section id="how-it-works" class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4">
      <h2 class="text-3xl font-bold text-center text-teal-700 mb-12">كيف نعمل</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="flex flex-col items-center text-center">
          <div class="bg-teal-700 text-white rounded-full w-16 h-16 flex items-center justify-center mb-4">
            <i class="fas fa-search text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">البحث عن الرحلات</h3>
          <p class="text-gray-700">تصفح قائمة الرحلات واختر الأنسب لك.</p>
        </div>
        <div class="flex flex-col items-center text-center">
          <div class="bg-teal-700 text-white rounded-full w-16 h-16 flex items-center justify-center mb-4">
            <i class="fas fa-bookmark text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">حجز الرحلة</h3>
          <p class="text-gray-700">استخدم نظام الحجز السهل لحجز رحلتك.</p>
        </div>
        <div class="flex flex-col items-center text-center">
          <div class="bg-teal-700 text-white rounded-full w-16 h-16 flex items-center justify-center mb-4">
            <i class="fas fa-smile text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold mb-2">الاستمتاع بالتجربة</h3>
          <p class="text-gray-700">استمتع برحلة آمنة ومريحة مع خدماتنا.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Trips Section (Replaces Partners) -->
  <section id="featured-trips" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
      <h2 class="text-3xl font-bold text-center text-teal-700 mb-12">رحلات مميزة</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Featured Trip 1 -->
        <div class="bg-gray-100 rounded-lg shadow overflow-hidden">
          <img src="https://source.unsplash.com/600x400/?bus,city" alt="Featured Trip 1" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-bold text-teal-700 mb-2">رحلة سريعة</h3>
            <p class="text-gray-700 mb-4">تاريخ: 2025-04-01 | وقت: 08:00</p>
            <a href="<?= gotolink('student.book_trip', ['id' => 1]); ?>" class="block bg-teal-600 hover:bg-teal-700 text-white text-center px-4 py-2 rounded">
              حجز الرحلة
            </a>
          </div>
        </div>
        <!-- Featured Trip 2 -->
        <div class="bg-gray-100 rounded-lg shadow overflow-hidden">
          <img src="https://source.unsplash.com/600x400/?bus,road" alt="Featured Trip 2" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-bold text-teal-700 mb-2">رحلة اقتصادية</h3>
            <p class="text-gray-700 mb-4">تاريخ: 2025-04-03 | وقت: 10:00</p>
            <a href="<?= gotolink('student.book_trip', ['id' => 2]); ?>" class="block bg-teal-600 hover:bg-teal-700 text-white text-center px-4 py-2 rounded">
              حجز الرحلة
            </a>
          </div>
        </div>
        <!-- Featured Trip 3 -->
        <div class="bg-gray-100 rounded-lg shadow overflow-hidden">
          <img src="https://source.unsplash.com/600x400/?bus,night" alt="Featured Trip 3" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-bold text-teal-700 mb-2">رحلة مميزة</h3>
            <p class="text-gray-700 mb-4">تاريخ: 2025-04-05 | وقت: 12:00</p>
            <a href="<?= gotolink('student.book_trip', ['id' => 3]); ?>" class="block bg-teal-600 hover:bg-teal-700 text-white text-center px-4 py-2 rounded">
              حجز الرحلة
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Advantages Section (Instead of Testimonials) -->
  <section id="advantages" class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4">
      <h2 class="text-3xl font-bold text-center text-teal-700 mb-12">لماذا تختار مسرى؟</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-xl font-bold text-teal-700 mb-2">تجربة نقل متكاملة</h3>
          <p class="text-gray-700">تقدم مسرى خدمات شاملة تضمن لك تنقلاً سريعًا وآمنًا مع دعم فني على مدار الساعة.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-xl font-bold text-teal-700 mb-2">سهولة الاستخدام</h3>
          <p class="text-gray-700">تصميم تطبيق متجاوب وبسيط يتيح لك حجز الرحلات بسهولة ويسر.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-xl font-bold text-teal-700 mb-2">تقنيات متقدمة</h3>
          <p class="text-gray-700">نعتمد على أحدث التقنيات لتحسين جودة الخدمة وتجربة المستخدم.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-xl font-bold text-teal-700 mb-2">أسعار تنافسية</h3>
          <p class="text-gray-700">نوفر أفضل الأسعار مع عروض مميزة وخدمات عالية الجودة.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
      <h2 class="text-3xl font-bold text-center text-teal-700 mb-12">الأسئلة الشائعة</h2>
      <div class="space-y-6">
        <div class="bg-gray-100 p-6 rounded-lg shadow">
          <h3 class="font-bold text-teal-700">ما هي خدمات مسرى؟</h3>
          <p class="mt-2 text-gray-700">مسرى يوفر حلول نقل مبتكرة تجمع بين الأمان والسرعة وسهولة الاستخدام.</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg shadow">
          <h3 class="font-bold text-teal-700">كيف أحجز رحلة؟</h3>
          <p class="mt-2 text-gray-700">يمكنك حجز رحلة عن طريق اختيار الرحلة من القائمة ثم النقر على زر "حجز الرحلة".</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg shadow">
          <h3 class="font-bold text-teal-700">ما هي طرق الدفع المتاحة؟</h3>
          <p class="mt-2 text-gray-700">ندعم الدفع الإلكتروني عبر بطاقات الائتمان والتحويلات البنكية.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 text-center text-teal-600">
      <h2 class="text-4xl font-bold mb-4">تواصل معنا</h2>
      <p class="text-lg mb-8">إذا كان لديك أي استفسار أو طلب، الرجاء ملء النموذج أدناه للتواصل معنا.</p>
      <form action="#" method="POST" class="max-w-xl mx-auto space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input type="text" name="name" placeholder="الاسم" required class="px-4 py-2 rounded focus:outline-none border border-blue-300">
          <input type="email" name="email" placeholder="البريد الإلكتروني" required class="px-4 py-2 rounded focus:outline-none border border-blue-300">
        </div>
        <textarea name="message" placeholder="رسالتك" rows="4" required class="w-full px-4 py-2 rounded focus:outline-none border border-blue-300"></textarea>
        <button type="submit" class="bg-white text-blue-600 font-bold py-3" ></button>
      </form>
    </div>
    </section>

<?php
$content = ob_get_clean();
student_layout($content, ['title' => $title, 'active' => $active]);
?>
