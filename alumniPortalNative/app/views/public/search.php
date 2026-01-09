<?php $base=(require __DIR__.'/../../config/config.php')['base_url']; ?>
<!-- Container utama -->
<div class="min-h-screen bg-[#f9f7ea]">
    <!-- Konten utama -->
    <main class="p-6 max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Cari Alumni</h1>

        <!-- Form pencarian -->
        <form method="get" class="mb-6 bg-white rounded shadow-sm flex">
            <input 
                type="text" 
                name="q" 
                value="<?= htmlspecialchars($q) ?>" 
                placeholder="Nama/angkatan/jurusan" 
                class="flex-grow border rounded-l py-2 px-4 text-gray-700 placeholder-gray-400 focus:outline-none" />
            <button 
                type="submit" 
                class="bg-[#001D3D] text-white px-6 rounded-r hover:bg-gray-800 transition-colors">
                Cari
            </button>
        </form>

        <!-- Daftar hasil pencarian -->
        <?php if(!$list): ?>
            <div class="text-gray-700">Tidak ditemukan.</div>
        <?php else: ?>
            <div class="grid grid-cols-4 gap-6">
                <?php foreach($list as $al): include __DIR__.'/alumni_card.php'; endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>