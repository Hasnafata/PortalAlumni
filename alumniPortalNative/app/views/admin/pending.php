<?php $base=(require __DIR__.'/../../config/config.php')['base_url']; ?>

<h1 class="text-3xl font-bold text-gray-900 mb-6">Pendaftar Pending</h1>

<?php if(!$list): ?>
  <div class="text-gray-600">Tidak ada.</div>
<?php else: ?>
  <div class="overflow-x-auto">
    <table class="w-full border-collapse rounded-lg overflow-hidden shadow-sm">
      <thead>
        <tr class="bg-[#001D3D] text-white text-sm">
          <th class="py-3 px-4 text-left font-semibold">Nama</th>
          <th class="py-3 px-4 text-left font-semibold">Email</th>
          <th class="py-3 px-4 text-left font-semibold">Status</th>
          <th class="py-3 px-4 text-left font-semibold">Aksi</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach($list as $r): ?>
          <tr class="border-b bg-white">
            <td class="py-3 px-4"><?= htmlspecialchars($r['nama_lengkap']) ?></td>
            <td class="py-3 px-4"><?= htmlspecialchars($r['email']) ?></td>

            <td class="py-3 px-4">
              <span class="bg-yellow-100 text-yellow-700 text-sm px-3 py-1 rounded-full">
                <?= htmlspecialchars($r['status_verifikasi']) ?>
              </span>
            </td>

            <td class="py-3 px-4 flex gap-2">
              <a href="<?= $base ?>/admin/alumni/edit?id=<?= $r['id'] ?> &source=pending"
                 class="bg-black text-white text-sm py-1 px-4 rounded-full hover:opacity-80 transition">
                Lihat / Edit
              </a>

              <a href="<?= $base ?>/admin/approve/?id=<?= $r['id'] ?>"
                 class="bg-green-500 text-white text-sm py-1 px-4 rounded-full hover:bg-green-600 transition">
                Approve
              </a>

              <a href="<?= $base ?>/admin/reject?id=<?= $r['id'] ?>"
                 class="bg-red-500 text-white text-sm py-1 px-4 rounded-full hover:bg-red-600 transition">
                Reject
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
