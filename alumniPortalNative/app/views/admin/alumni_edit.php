<?php 
$base = (require __DIR__.'/../../config/config.php')['base_url']; 
$is_admin = ($_SESSION['role'] ?? null) === 'admin';

// --- [TAMBAHAN 1] Tangkap parameter source dari URL ---
// Jika tidak ada parameter source, default-nya kita anggap dari 'alumni' (list user biasa)
$source = $_GET['source'] ?? 'alumni'; 
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<div class="w-full min-h-screen px-6 py-10">
    
    <h1 class="text-center text-2xl font-bold text-[#0d1b4c] mb-10 tracking-wide">
        EDIT ALUMNI
    </h1>

    <form action="<?= $base ?>/admin/alumni/update" method="post" enctype="multipart/form-data"
          class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">

        <input type="hidden" name="id_alumni" value="<?= htmlspecialchars($p['id'] ?? '') ?>">

        <input type="hidden" name="redirect_source" value="<?= htmlspecialchars($source) ?>">
        <?php if ($is_admin): ?>
        <div class="flex flex-col">
            <label class="font-semibold mb-1">NIM (Hanya Admin yang Bisa Lihat)</label>
            <input name="nim"
                value="<?= htmlspecialchars($p['nim'] ?? '') ?>"
                class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 ring-blue-300 shadow-sm bg-yellow-50">
        </div>
        <?php endif; ?>
        <div class="flex flex-col">
            <label class="font-semibold mb-1">Nama Lengkap</label>
            <input name="nama_lengkap"
                value="<?= htmlspecialchars($p['nama_lengkap'] ?? '') ?>"
                required
                class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 ring-blue-300 shadow-sm">
        </div>

        <div class="flex flex-col">
            <label class="font-semibold mb-1">Tempat Lahir</label>
            <input name="tempat_lahir"
                value="<?= htmlspecialchars($p['tempat_lahir'] ?? '') ?>"
                class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 ring-blue-300 shadow-sm">
        </div>

        <div class="flex flex-col">
            <label class="font-semibold mb-1">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir"
                value="<?= htmlspecialchars($p['tanggal_lahir'] ?? '') ?>"
                class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 ring-blue-300 shadow-sm">
        </div>

        <div class="flex flex-col">
            <label class="font-semibold mb-1">Angkatan (Tahun)</label>
            <input type="number" name="angkatan"
                value="<?= htmlspecialchars($p['angkatan'] ?? '') ?>"
                class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 ring-blue-300 shadow-sm">
        </div>

        <div class="flex flex-col">
            <label class="font-semibold mb-1">Pekerjaan</label>
            <input name="pekerjaan"
                value="<?= htmlspecialchars($p['pekerjaan'] ?? '') ?>"
                class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 ring-blue-300 shadow-sm">
        </div>

        <div class="flex flex-col">
            <label class="font-semibold mb-1">Jurusan</label>
            <input name="jurusan"
                value="<?= htmlspecialchars($p['jurusan'] ?? '') ?>"
                class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 ring-blue-300 shadow-sm">
        </div>

        <div class="flex flex-col md:col-span-2">
            <label class="font-semibold mb-1">Detail Pekerjaan</label>
            <textarea name="pekerjaan_detail" rows="3"
                class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 ring-blue-300 shadow-sm"><?= htmlspecialchars($p['pekerjaan_detail'] ?? '') ?></textarea>
        </div>

        <div class="flex flex-col md:col-span-2">
            <label class="font-semibold mb-1">Deskripsi Alumni</label>
            <textarea name="deskripsi" rows="4"
                class="border rounded-md px-3 py-2 focus:outline-none focus:ring-2 ring-blue-300 shadow-sm"><?= htmlspecialchars($p['deskripsi'] ?? '') ?></textarea>
        </div>

        <div class="flex flex-col md:col-span-2">
            <label class="font-semibold mb-1">Foto Profil (JPG/PNG/WebP, maks 2MB)</label>

            <input type="file" id="fotoInput" accept="image/*"
                class="border rounded-md px-3 py-2 bg-white shadow-sm">

            <div class="mt-3">
                <img id="previewImage" class="max-w-xs border rounded-md hidden">
            </div>
            <input type="hidden" name="foto_cropped" id="fotoCropped">
        </div>

        <div class="md:col-span-2 flex justify-center mt-4">
            <button type="submit" 
                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-8 py-2 rounded-full shadow-md transition">
                SIMPAN
            </button>
        </div>
    </form>
</div>

<script>
let cropper;
document.getElementById('fotoInput').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = function(event) {
    const img = document.getElementById('previewImage');
    img.src = event.target.result;
    img.classList.remove('hidden');
    if (cropper) cropper.destroy();
    cropper = new Cropper(img, {
      aspectRatio: 1,
      viewMode: 1,
      dragMode: 'move',
      background: false,
      zoomable: true
    });
  };
  reader.readAsDataURL(file);
});

document.querySelector('form').addEventListener('submit', function() {
  if (cropper) {
    const canvas = cropper.getCroppedCanvas({ width: 512, height: 512 });
    document.getElementById('fotoCropped').value = canvas.toDataURL('image/jpeg');
  }
});
</script>