<?php 
$u = current_user(); 
$base = (require __DIR__.'/../../config/config.php')['base_url']; 
?>

<!-- BODY WRAPPER: warna cream full -->
<body class="bg-[#F9F8ED] min-h-screen flex flex-col">

  <!-- NAVBAR BIRU STICKY -->
  <nav class="bg-[#001D3D] text-white flex justify-between items-center px-10 py-4 rounded-b-3xl sticky top-0 z-50 shadow-md">
    <div class="flex items-center space-x-4">
      <img src="<?= $base ?>/assets/logo-uns.jpg" 
     class="w-12 h-12 rounded-full object-cover" 
     alt="Logo UNS">
      <div>
        <h1 class="text-sm font-semibold leading-tight">Website Alumni</h1>
        <p class="text-xs">Universitas Sebelas Maret</p>
      </div>
    </div>

    <ul class="flex space-x-8 font-semibold">
      <li><a href="<?= $base ?>/" class="hover:text-gray-300">Home</a></li>
      <li><a href="<?= $base ?>/search" class="hover:text-gray-300">Alumni</a></li>

      <?php if(!$u): ?>
        <li><a href="<?= $base ?>/login" class="hover:text-gray-300">Login</a></li>
        <li><a href="<?= $base ?>/register" class="hover:text-gray-300">Registrasi</a></li>
      <?php else: ?>
        <?php if($u['role']==='admin'): ?>
          <li><a href="<?= $base ?>/admin" class="hover:text-gray-300">Admin</a></li>
        <?php endif; ?>
        <li><a href="<?= $base ?>/alumni/profile" class="hover:text-gray-300">Profil</a></li>
        <li><a href="<?= $base ?>/logout" class="hover:text-gray-300">Logout</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <!-- KONTEN HALAMAN -->
  <main class="flex-grow">
    <div class="max-w-6xl mx-auto px-4 py-6">
      <?php if(!empty($_SESSION['flash'])): ?>
        <div class="mb-4 p-3 rounded bg-amber-100 border border-amber-300">
          <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
        </div>
      <?php endif; ?>
