<?php $base=(require __DIR__.'/../../config/config.php')['base_url']; ?>

<div class="flex flex-col justify-center items-center py-20">

    <!-- Judul -->
    <h1 class="text-3xl font-bold text-black mb-8 tracking-wide">
        ADMIN DASHBOARD
    </h1>

    <!-- Tombol Pendaftar Pending -->
    <a href="<?= $base ?>/admin/pending"
       class="bg-orange-500 hover:bg-orange-600 text-white font-semibold
              px-6 py-3 rounded-lg shadow-md transition mb-4">
        Pendaftar Pending
    </a>

    <!-- Tombol Data Alumni -->
    <a href="<?= $base ?>/admin/alumni"
       class="bg-black hover:bg-gray-900 text-white font-semibold
              px-6 py-3 rounded-lg shadow-md transition">
        Data Alumni
    </a>

</div>
