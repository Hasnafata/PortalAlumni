  <?php
  $config = require __DIR__ . '/../../config/config.php';
  $base = $config['base_url']; 
  ?>

  <div class="min-h-screen bg-[#F9F8ED] flex justify-center items-center px-4">
    <div class="bg-white shadow-md rounded-md p-8 w-full max-w-sm text-center">
      <h2 class="text-lg font-semibold mb-4 text-[#001D3D]">Login dengan Email dan Password anda</h2>
      <?php if (isset($_SESSION['flash'])): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm text-left">
              <?= $_SESSION['flash'] ?>
              <?php unset($_SESSION['flash']);?>
          </div>
      <?php endif; ?>
      <form action="<?= $base ?>/login" method="POST" class="text-left space-y-4">
        <input type="hidden" name="action" value="do_login">
        <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
        <div>
          <label for="email" class="block text-sm font-medium text-[#001D3D]">Email</label>
          <input type="email" id="email" name="email" required class="w-full p-2 bg-blue-50 rounded-md border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#001D3D]">
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-[#001D3D]">Password</label>
          <input type="password" id="password" name="password" required class="w-full p-2 bg-blue-50 rounded-md border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#001D3D]">
        </div>
        <button type="submit" class="w-full bg-[#E36414] hover:bg-[#C6530E] text-white font-semibold py-2 rounded-md transition duration-200">MASUK</button>
      </form>
      <p class="mt-4 text-sm">Belum punya akun? <a href="<?= $base ?>/register" class="text-[#001D3D] font-semibold hover:underline">Registrasi</a></p>
    </div>
  </div>