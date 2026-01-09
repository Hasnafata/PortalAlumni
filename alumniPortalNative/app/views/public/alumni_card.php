<?php
$base=(require __DIR__.'/../../config/config.php')['base_url'];
$img = $al['foto_path'] ? $base.'/'.htmlspecialchars($al['foto_path']) : $base.'/assets/img/avatar-default.png';
?>
<a href="<?= $base ?>/alumni/detail?id=<?= (int)$al['id'] ?>" class="block bg-white rounded-md shadow-md hover:shadow-lg p-3 w-60">
  <div class="w-full h-40 bg-[#dbe9ff] rounded-t-md overflow-hidden">
    <img src="<?= $img ?>" alt="foto" class="w-full h-full object-cover">
  </div>
  <div class="mt-2">
    <div class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($al['nama_lengkap']) ?></div>
    <div class="text-xs text-gray-500 mt-0.5">Angkatan : <?= htmlspecialchars($al['angkatan'] ?? '-') ?></div>
    <div class="text-xs text-gray-500">Jurusan : <?= htmlspecialchars($al['jurusan'] ?? '-') ?></div>
  </div>
</a>
