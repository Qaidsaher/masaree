<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? $title : 'صفحة الزائر'; ?></title>
  <!-- Google Fonts for Arabic (Cairo) -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <style> body { font-family: 'Cairo', sans-serif; } </style>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-green-50">
  <!-- Navbar -->
  <header>
    <nav class="bg-gradient-to-r from-green-600 to-green-700 shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
       <a href="<?= gotolink('admin.home'); ?>" class="text-2xl font-bold flex items-center">
            <i class="fas fa-bus-alt ml-2"></i> مسرى
          </a>
      
      </div>
      </div>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="min-h-screen">
    <?= $content; ?>
  </main>

  <!-- Footer -->
  
  <script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    btn.addEventListener('click', () => {
      menu.classList.toggle('hidden');
    });
  </script>
</body>
</html>
