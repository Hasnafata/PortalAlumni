<?php
$foto_path = $p['foto_path'] ?? null; 
$img = $foto_path 
    ? $base . '/' . htmlspecialchars($foto_path) 
    : $base . '/assets/img/avatar-default.png';
?>

<div class="bg-[#f9f7ec] px-10 py-8 text-black">

    <h1 class="text-2xl font-bold mb-6">Profil Saya</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- FOTO PROFIL -->

        <div class="flex justify-center md:justify-start">
            <img src="<?= $img ?>"
                 alt="Foto Profil"
                 class="w-full h-full rounded-md object-cover bg-[#3b5998]" />
        </div>

        <!-- DETAIL PROFIL -->
        <div class="md:col-span-2 space-y-2">

            <!-- Nama -->
            <div class="flex items-center gap-4">
                <div class="w-28 font-semibold">Nama</div>
                <div class="flex-1 bg-[#fffcf2] rounded px-3 py-2 rounded w-full">
                    <?= htmlspecialchars($p['nama_lengkap'] ?? '-') ?>
                </div>
            </div>

            <!-- Email -->
            <div class="flex items-center gap-4">
                <div class="w-28 font-semibold">Email</div>
                <div class="flex-1 bg-[#fffcf2] rounded px-3 py-2 rounded w-full">
                    <?= htmlspecialchars(current_user()['email']) ?>
                </div>
            </div>

            <!-- Angkatan -->
            <div class="flex items-center gap-4">
                <div class="w-28 font-semibold">Angkatan</div>
                <div class="flex-1 bg-[#fffcf2] rounded px-3 py-2 rounded w-full">
                    <?= htmlspecialchars($p['angkatan'] ?? '-') ?>
                </div>
            </div>

            <!-- Pekerjaan -->
            <div class="flex items-center gap-4">
                <div class="w-28 font-semibold">Pekerjaan</div>
                <div class="flex-1 bg-[#fffcf2] rounded px-3 py-2 rounded w-full">
                    <?= htmlspecialchars($p['pekerjaan'] ?? '-') ?>
                </div>
            </div>

            <!-- Jurusan -->
            <div class="flex items-center gap-4">
                <div class="w-28 font-semibold">Jurusan</div>
                <div class="flex-1 bg-[#fffcf2] rounded px-3 py-2 rounded w-full">
                    <?= htmlspecialchars($p['jurusan'] ?? '-') ?>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="flex items-start gap-4">
                <div class="w-28 font-semibold">Deskripsi</div>
                <div class="flex-1 bg-[#fffcf2] rounded px-3 py-2 rounded w-full">
                    <?= nl2br(htmlspecialchars($p['deskripsi'] ?? '-')) ?>
                </div>
            </div>

            <!-- Status -->
            <div class="flex items-center gap-4">
                <div class="w-28 font-semibold">Status</div>
                <div class="flex-1">
                    <span class="px-3 py-1 rounded-full text-white text-sm
                        <?= ($p['status_verifikasi'] === 'verified'
                                ? 'bg-emerald-600'
                                : ($p['status_verifikasi'] === 'pending'
                                    ? 'bg-orange-500'
                                    : 'bg-rose-600')) ?>">
                        <?= htmlspecialchars($p['status_verifikasi'] ?? '-') ?>
                    </span>
                </div>
            </div>

            <!-- TOMBOL EDIT -->
            <a href="<?= $base ?>/alumni/profile/edit" 
               class="inline-block bg-black text-white font-semibold px-6 py-2 rounded-md hover:bg-gray-800 transition">
                Edit Profil
            </a>

        </div>
    </div>
</div>