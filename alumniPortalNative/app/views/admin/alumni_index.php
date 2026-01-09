<?php 
$base = (require __DIR__.'/../../config/config.php')['base_url']; 
?>

<div class="min-h-screen px-6 py-10">

    <!-- Judul -->
    <h1 class="text-3xl font-bold text-[#0d1b4c] mb-6">Semua Alumni</h1>

    <!-- Header total data -->
    <div class="bg-[#001D3D] text-white font-semibold w-full max-w-6xl mx-auto rounded-t-md px-4 py-2 shadow">
        Total : <?= count($list) ?> data
    </div>

    <!-- Table -->
    <div class="overflow-x-auto w-full max-w-6xl mx-auto shadow-lg">
        <table class="w-full border-collapse bg-white">
            <thead>
                <tr class="bg-[#001D3D] text-white text-left">
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Angkatan</th>
                    <th class="px-4 py-2">NIM</th>
                    <th class="px-4 py-2">Jurusan</th>
                    <th class="px-4 py-2">Pekerjaan</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if(empty($list)): ?>

                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">
                            Tidak ada data.
                        </td>
                    </tr>

                <?php else: ?>

                    <?php foreach($list as $r): ?>

                        <?php 
                            $status = htmlspecialchars($r['status_verifikasi']);

                            // WARNA BADGE SESUAI GAMBAR
                            if ($status === "verified") {
                              $badgeColor = "bg-emerald-500 text-white";
                            } elseif ($status === "pending") {
                              $badgeColor = "bg-orange-500 text-white";
                            } else {
                              $badgeColor = "bg-gray-300 text-white";
                            }
                        
                        ?>

                        <tr class="border-b hover:bg-gray-50">
                            
                            <td class="px-4 py-2"><?= htmlspecialchars($r['nama_lengkap']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($r['email']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($r['angkatan'] ?? '-') ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($r['nim'] ?? '-') ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($r['jurusan'] ?? '-') ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($r['pekerjaan'] ?? '-') ?></td>

                            <!-- STATUS BADGE -->
                            <td class="px-3 py-1">
                                <span class="px-3 py-1 rounded-full text-sm font-normal <?= $badgeColor ?>">
                                    <?= $status ?>
                                </span>
                            </td>

                            <!-- AKSI -->
                            <td class="px-4 py-2 flex gap-2">
                                
                                <!-- Edit button -->
                                <a href="<?= $base ?>/admin/alumni/edit?id=<?= (int)$r['id'] ?>&source=alumni"
                                   class="bg-black text-white px-4 py-1 rounded-full text-sm hover:bg-gray-800">
                                    Edit
                                </a>
-
                                <!-- Delete button -->
                                <form action="<?= $base ?>/admin/alumni/delete" method="post"
                                      onsubmit="return confirm('Yakin hapus alumni ini? Tindakan ini tidak bisa dibatalkan.');">
                                    
                                    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">

                                    <button class="bg-red-500 text-white px-4 py-1 rounded-full text-sm hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>