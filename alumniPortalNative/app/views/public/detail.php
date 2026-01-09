<?php
$base=(require __DIR__.'/../../config/config.php')['base_url'];
$img=$d['foto_path']?$base.'/'.htmlspecialchars($d['foto_path']):$base.'/assets/img/avatar-default.png';
?>
<h1 class="text-2xl font-semibold mb-4">Detail Alumni</h1>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-[#f9f7ec] p-6 rounded-md">
  <div class="bg-blue-200 w-full h-64 md:h-auto rounded-md flex items-center justify-center overflow-hidden">
    <img src="<?= $img ?>" alt="Foto Alumni" class="object-cover w-full h-full rounded-md" />
  </div>
  <div class="md:col-span-2 space-y-4">
    <div class="flex items-center">
      <div class="w-28 font-semibold">Nama</div>
      <div class="bg-[#fffcf2] px-3 py-2 rounded w-full"><?= htmlspecialchars($d['nama_lengkap'] ?? '-') ?></div>
    </div>
    <div class="flex items-center">
      <div class="w-28 font-semibold">Email</div>
      <div class="bg-[#fffcf2] px-3 py-2 rounded w-full"><?= htmlspecialchars($d['email'] ?? '-') ?></div>
    </div>
    <div class="flex items-center">
      <div class="w-28 font-semibold">Angkatan</div>
      <div class="bg-[#fffcf2] px-3 py-2 rounded w-full"><?= htmlspecialchars($d['angkatan'] ?? '-') ?></div>
    </div>
    <div class="flex items-center">
      <div class="w-28 font-semibold">Pekerjaan</div>
      <div class="bg-[#fffcf2] px-3 py-2 rounded w-full"><?= htmlspecialchars($d['pekerjaan'] ?? '-') ?></div>
    </div>
    <div class="flex items-center">
      <div class="w-28 font-semibold">Jurusan</div>
      <div class="bg-[#fffcf2] px-3 py-2 rounded w-full"><?= htmlspecialchars($d['jurusan'] ?? '-') ?></div>
    </div>
    <div class="flex items-start">
      <div class="w-28 font-semibold">Deskripsi</div>
      <div class="bg-[#fffcf2] px-3 py-2 rounded w-full whitespace-pre-line"><?= htmlspecialchars($d['deskripsi'] ?? '-') ?></div>
    </div>
  </div>
</div>