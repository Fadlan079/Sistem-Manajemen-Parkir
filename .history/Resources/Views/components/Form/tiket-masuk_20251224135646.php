<?php include __DIR__ . '/../../components/'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tiket Masuk</title>
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
          integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body class="bg-slate-900 text-white">

<div class="max-w-xl mx-auto mt-16 bg-slate-800 border border-slate-700 p-8 rounded-2xl shadow-lg">

    <h2 class="text-3xl font-bold text-cyan-400 mb-6 flex items-center gap-3">
        <i class="fa-solid fa-ticket"></i>
        Tiket Masuk
    </h2>

    <form id="form-tiket-masuk" action="?action=store-tiket-masuk" method="POST" class="space-y-6">

        <!-- OCR Section -->
        <!-- <div class="bg-slate-700 p-4 rounded-lg border border-slate-600">
            <label class="block mb-2 text-slate-300 font-semibold">
                Scan Plat Nomor (Opsional)
            </label>

            <div class="flex flex-col sm:flex-row gap-2">
                <input type="file" id="foto_plat" accept="image/*"
                       class="flex-1 px-3 py-2 rounded-lg bg-slate-800 border border-slate-600
                              focus:ring-2 focus:ring-emerald-500 outline-none text-white">
                <button type="button" id="btnScan"
                        class="bg-emerald-500 hover:bg-emerald-600 px-4 py-2 rounded-lg font-semibold flex items-center justify-center gap-2 transition">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span id="btnText">Scan</span>
                    <span id="btnSpinner" class="hidden animate-spin border-2 border-t-white rounded-full w-4 h-4"></span>
                </button>
            </div> -->

            <!-- Preview Gambar -->
            <!-- <img id="preview" class="mt-2 rounded-lg border border-slate-600 hidden" style="max-height:150px; object-fit:contain;">

            <p id="ocr-status" class="text-sm text-slate-400 mt-1">Hasil scan akan otomatis masuk ke input Nomor Polisi.</p>
        </div> -->

        <!-- Input Manual -->
        <div>
            <label class="block mb-2 text-slate-300 font-semibold">
                Nomor Polisi (Manual)
            </label>
            <input type="text"
                   name="nomor_polisi"
                   placeholder="Ketik nomor polisi manual..."
                   required
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600
                          focus:ring-2 focus:ring-cyan-500 outline-none">
        </div>

        <!-- Jenis Kendaraan -->
        <div>
            <label class="block mb-2 text-slate-300 font-semibold">
                Jenis Kendaraan
            </label>
            <select id="jenis_kendaraan" name="jenis_kendaraan" required
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600
                           focus:ring-2 focus:ring-cyan-500 outline-none">
                <option value="motor">Motor</option>
                <option value="mobil">Mobil</option>
            </select>
        </div>

        <!-- Tarif -->
        <div>
            <label class="block mb-2 text-slate-300 font-semibold">
                Tarif Parkir
            </label>
            <select id="id_tarif" name="id_tarif" required
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600
                           focus:ring-2 focus:ring-cyan-500 outline-none">
                <?php foreach($data_tarif as $tarif): ?>
                    <option value="<?= $tarif['id_tarif'] ?>" data-jenis="<?= $tarif['jenis_kendaraan'] ?>">
                        <?= ucfirst($tarif['jenis_kendaraan']) ?> - Rp <?= number_format($tarif['harga_flat']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <p id="tarif-note" class="text-sm text-slate-400 mt-2">
                Tarif akan otomatis terpilih berdasarkan jenis kendaraan. Bisa diubah manual jika perlu.
            </p>
        </div>

        <!-- Button Simpan -->
        <button type="submit"
                class="w-full py-3 mt-4 bg-cyan-500 hover:bg-cyan-600 text-slate-900 text-lg font-semibold rounded-lg transition flex items-center justify-center gap-2">
            <i class="fa-solid fa-save"></i> Simpan Tiket
        </button>

        <a href="?action=index"
           class="mt-2 w-full text-center border border-cyan-400
                    text-cyan-400 p-2 rounded-lg hover:bg-cyan-500 hover:text-slate-900
                    flex items-center justify-center gap-2 transition">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>

    </form>
</div>

<script>
// Preview Foto sebelum OCR
const fileInput = document.getElementById('foto_plat');
const preview = document.getElementById('preview');

fileInput.addEventListener('change', () => {
    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(fileInput.files[0]);
    } else {
        preview.src = '';
        preview.classList.add('hidden');
    }
});

// Sinkronisasi tarif otomatis sesuai jenis kendaraan
const jenisSelect = document.getElementById('jenis_kendaraan');
const tarifSelect = document.getElementById('id_tarif');

function syncTarifToJenis() {
    const jenis = jenisSelect.value;
    const options = Array.from(tarifSelect.options);
    const matched = options.find(opt => opt.dataset.jenis === jenis);
    if (matched) tarifSelect.value = matched.value;
}

document.addEventListener('DOMContentLoaded', () => syncTarifToJenis());
jenisSelect.addEventListener('change', () => syncTarifToJenis());

// OCR Scan dengan animasi tombol & pesan error
async function scanOCR() {
    const status = document.getElementById('ocr-status');
    const nomorInput = document.querySelector('input[name="nomor_polisi"]');
    const btn = document.getElementById('btnScan');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');

    if (!fileInput.files.length) {
        alert("Pilih foto plat nomor dulu!");
        return;
    }

    const formData = new FormData();
    formData.append("gambar", fileInput.files[0]);

    // Disable tombol + show spinner
    btn.disabled = true;
    btnText.innerText = "Scanning...";
    btnSpinner.classList.remove('hidden');
    status.innerText = "⏳ Memproses OCR...";

    try {
        const res = await fetch("ocr-scan.php", { method: "POST", body: formData });

        if (!res.ok) throw new Error("Gagal menghubungi server OCR");

        const data = await res.text();

        if (!data.trim()) throw new Error("OCR tidak mengenali plat nomor, silakan coba lagi.");

        nomorInput.value = data.trim();
        status.innerText = "✅ OCR berhasil!";
    } catch (err) {
        console.error(err);
        status.innerText = `❌ ${err.message}`;
    } finally {
        btn.disabled = false;
        btnText.innerText = "Scan";
        btnSpinner.classList.add('hidden');
    }
}

// Pasang event listener tombol Scan
document.getElementById('btnScan').addEventListener('click', scanOCR);
</script>

</body>
</html>
