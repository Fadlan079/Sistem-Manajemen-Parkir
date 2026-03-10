<?php include __DIR__ . '/../../components/global-modal.php' ?>
<div class="max-w-xl mx-auto mt-2 bg-slate-800 border border-slate-700 p-8 rounded-2xl shadow-lg">

    <h2 class="text-3xl font-bold text-cyan-400 mb-6 flex items-center gap-3">
        <i class="fa-solid fa-ticket"></i>
        Tiket Masuk
    </h2>

    <?php
    if (isset($_SESSION['flash'])) {
        alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
        unset($_SESSION['flash']);
    }
    ?>

    <form action="?action=store-tiket-masuk"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6"
          id="tiketForm">
        <div>
            <label class="block mb-3 text-slate-300 font-semibold">
                Foto Kendaraan / Plat Nomor (Opsional)
            </label>

            <div id="uploadBox"
                 class="relative border-2 border-dashed border-slate-600 rounded-xl
                        p-6 text-center cursor-pointer
                        hover:border-cyan-400 transition">

                <input type="file"
                       id="foto_plat"
                       name="foto_plat"
                       accept="image/*"
                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                <div id="uploadPlaceholder">
                    <i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-400 mb-3"></i>
                    <p class="text-slate-300 font-medium">
                        Klik atau tarik foto ke sini
                    </p>
                    <p class="text-sm text-slate-400 mt-1">
                        JPG / PNG – plat harus terlihat jelas
                    </p>
                </div>

                <img id="previewImg"
                     class="hidden mt-4 max-h-40 mx-auto rounded-lg shadow-lg">
            </div>

            <p id="uploadStatus"
               class="mt-3 text-sm text-slate-400 flex items-center gap-2">
                <i class="fa-solid fa-circle-info"></i>
                Belum ada foto diupload
            </p>
        </div>

        <div>
            <label class="block mb-2 text-slate-300 font-semibold">
                Nomor Polisi
            </label>
            <input type="text"
                   name="nomor_polisi"
                   id="nomor_polisi"
                   placeholder="Contoh: B 1234 ABC"
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600">
        </div>

        <div>
            <label class="block mb-2 text-slate-300 font-semibold">
                Jenis Kendaraan
            </label>
            <select id="jenis_kendaraan"
                    name="jenis_kendaraan"
                    required
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600
                           focus:ring-2 focus:ring-cyan-500 outline-none">
                <option value="motor">Motor</option>
                <option value="mobil">Mobil</option>
            </select>

            <p id="autoInfo"
               class="text-sm text-cyan-400 mt-2 hidden">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                Jenis kendaraan terdeteksi otomatis (OCR)
            </p>
        </div>

        <div>
            <label class="block mb-2 text-slate-300 font-semibold">
                Tarif Parkir
            </label>

            <select id="id_tarif"
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600"
                    disabled>
                <option value="">-- Otomatis --</option>
                <?php foreach ($data_tarif as $tarif): ?>
                    <option value="<?= $tarif['id_tarif'] ?>"
                            data-jenis="<?= $tarif['jenis_kendaraan'] ?>">
                        <?= ucfirst($tarif['jenis_kendaraan']) ?>
                        - Rp <?= number_format($tarif['harga_flat'], 0, ',', '.') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="hidden" name="id_tarif" id="id_tarif_hidden">

            <p class="text-sm text-slate-400 mt-2">
                Tarif otomatis sesuai jenis kendaraan
            </p>
        </div>

        <button type="submit"
                class="w-full py-3 bg-cyan-500 hover:bg-cyan-600
                       text-slate-900 font-semibold rounded-lg transition">
            <i class="fa-solid fa-save mr-1"></i>
            Simpan Tiket
        </button>

        <a href="?action=index"
           class="block text-center border border-cyan-400 text-cyan-400
                  p-2 rounded-lg hover:bg-cyan-500 hover:text-slate-900 transition">
            <i class="fa-solid fa-arrow-left mr-1"></i>
            Kembali
        </a>

    </form>
</div>

<script>
const jenisSelect = document.getElementById('jenis_kendaraan');
const tarifSelect = document.getElementById('id_tarif');
const tarifHidden = document.getElementById('id_tarif_hidden');
const autoInfo    = document.getElementById('autoInfo');

function syncTarif() {
    const jenis = jenisSelect.value;
    let found = false;

    [...tarifSelect.options].forEach(opt => {
        if (opt.dataset.jenis === jenis) {
            opt.selected = true;
            tarifHidden.value = opt.value;
            found = true;
        }
    });

    if (!found) {
        tarifHidden.value = "";
    }
}

document.addEventListener('DOMContentLoaded', syncTarif);
jenisSelect.addEventListener('change', () => {
    autoInfo.classList.add('hidden');
    syncTarif();
});

const fileInput   = document.getElementById('foto_plat');
const platInput   = document.getElementById('nomor_polisi');
const previewImg  = document.getElementById('previewImg');
const uploadBox   = document.getElementById('uploadBox');
const statusText  = document.getElementById('uploadStatus');
const placeholder = document.getElementById('uploadPlaceholder');

fileInput.addEventListener('change', async function () {
    if (!this.files.length) return;

    const file = this.files[0];

    const reader = new FileReader();
    reader.onload = e => {
        previewImg.src = e.target.result;
        previewImg.classList.remove('hidden');
        placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(file);

    statusText.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> Memproses OCR...`;
    statusText.className = 'mt-3 text-sm text-cyan-400 flex items-center gap-2';

    const formData = new FormData();
    formData.append('foto_plat', file);

    try {
        const res = await fetch('ajax/ocr-plat.php', {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        if (data.status === 'success') {
            platInput.value = data.plate;

            if (data.vehicle_type) {
                jenisSelect.value = data.vehicle_type;
                autoInfo.classList.remove('hidden');
                syncTarif();
            }

            statusText.innerHTML = `<i class="fa-solid fa-circle-check"></i> OCR berhasil`;
            statusText.className = 'mt-3 text-sm text-green-400 flex items-center gap-2';
        } else {
            statusText.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> OCR gagal, isi manual`;
            statusText.className = 'mt-3 text-sm text-red-400 flex items-center gap-2';
        }

    } catch (err) {
        statusText.innerHTML = `<i class="fa-solid fa-xmark"></i> Gagal menjalankan OCR`;
        statusText.className = 'mt-3 text-sm text-red-400 flex items-center gap-2';
    }
});

document.getElementById('tiketForm').addEventListener('submit', e => {
    if (!fileInput.files.length && platInput.value.trim() === '') {
        e.preventDefault();
        alert('Upload foto atau isi nomor polisi manual');
    }
});

function detectVehicleFromPlate(plate) {
    plate = plate.replace(/[^A-Z0-9]/gi, '').toUpperCase();

    const m = plate.match(/^([A-Z]{1,2})(\d{1,5})([A-Z]{0,3})$/);
    if (!m) return null;

    const numberLen = m[2].length;
    const suffixLen = (m[3] || '').length;

    // RULE REALISTIS
    if (numberLen >= 4 && suffixLen >= 2) return 'mobil';
    if (numberLen >= 5) return 'mobil';

    return 'motor';
}

let manualDetected = false;

platInput.addEventListener('blur', () => {
    if (fileInput.files.length) return;

    const plate = platInput.value.trim();
    if (!plate) return;

    const detected = detectVehicleFromPlate(plate);
    if (!detected) return;

    jenisSelect.value = detected;
    autoInfo.innerHTML = `
        <i class="fa-solid fa-wand-magic-sparkles"></i>
        Jenis kendaraan terdeteksi otomatis (Nomor Plat)
    `;
    autoInfo.classList.remove('hidden');

    syncTarif();
    manualDetected = true;
});

jenisSelect.addEventListener('change', () => {
    if (manualDetected) {
        autoInfo.classList.add('hidden');
        manualDetected = false;
    }
});
</script>