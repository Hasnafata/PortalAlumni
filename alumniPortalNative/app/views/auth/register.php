<?php $base = (require __DIR__.'/../../config/config.php')['base_url']; ?>

<div class="min-h-screen bg-[#F9F8ED] flex flex-col">


  <!-- FORM CARD -->
  <div class="flex-grow flex justify-center items-center">
    <div class="bg-white shadow-md rounded-md p-8 w-full max-w-sm text-center">
      <h2 class="text-lg font-semibold mb-6">Registrasi Alumni</h2>

      <?php if (!empty($_SESSION['flash'])): ?>
        <div class="bg-yellow-100 text-yellow-800 text-sm p-2 mb-4 rounded">
          <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
        </div>
      <?php endif; ?>

      <form action="<?= $base ?>/register" method="post" class="text-left space-y-4">
        <input type="hidden" name="action" value="do_register">
        <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
          <input name="nama_lengkap" required placeholder="Misal: Vella"
            class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-[#001D3D] focus:outline-none" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">NIM (hanya dilihat admin)</label>
          <input name="nim" placeholder="K1234567"
            class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-[#001D3D] focus:outline-none" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email (@uns.ac.id)</label>
          <input name="email" type="email" required placeholder="nama@uns.ac.id"
            class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-[#001D3D] focus:outline-none" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input name="password" type="password" required placeholder="********"
            class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-[#001D3D] focus:outline-none" />
        </div>

        <button type="submit"
          class="w-full bg-[#E36414] text-white font-semibold py-2 rounded-md hover:bg-[#c95410] transition">
          DAFTAR
        </button>

        <p class="text-center text-sm mt-2">
          Sudah punya akun?
          <a href="<?= $base ?>/login" class="text-[#001D3D] underline hover:text-[#E36414]">login disini</a>
        </p>
      </form>
    </div>
  </div>
</div>
