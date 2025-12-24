<?php include __DIR__ . '/../../components/global-modal.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tiket Masuk</title>

    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
          crossorigin="anonymous"/>
</head>

<body class="bg-slate-900 text-white">

<div class="max-w-xl mx-auto mt-16 bg-slate-800 border border-slate-700 p-8 rounded-2xl shadow-lg">

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

    <form action="?action=store-tiket-masuk" method="POST" class="space-y-6">

        <!-- Nomor Polisi -->
        <div>
            <label class="block mb-2 text-slate-300 font-semibold">
                Nomor Polisi
            </label>
            <input type="text"
                   name="nomor_polisi"
                   required
                   placeholder="Contoh: B 1234 ABC"
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600
                          focus:ring-2 focus:ring-cyan-500 outline-none">
        </div>

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

        <div>
            <label class="block mb-2 text-slate-300 font-semibold">
                Tarif Parkir
            </label>

            <select id="id_tarif"
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600
                           focus:ring-2 focus:ring-cyan-500 outline-none"
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

            <!-- hidden input supaya tetap terkirim -->
            <input type="hidden" name="id_tarif" id="id_tarif_hidden">

            <p class="text-sm text-slate-400 mt-2">
                Tarif otomatis sesuai jenis kendaraan
            </p>
        </div>

        <!-- Submit -->
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
        tarifSelect.value = "";
        tarifHidden.value = "";
        console.warn("Tarif tidak ditemukan untuk:", jenis);
    }
}

document.addEventListener('DOMContentLoaded', syncTarif);
jenisSelect.addEventListener('change', syncTarif);
</script>

</body>
</html>