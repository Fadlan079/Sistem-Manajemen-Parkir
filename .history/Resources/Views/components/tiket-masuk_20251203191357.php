<?php include __DIR__ . '/../components/global-modal.php'?>

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

    <!-- SUCCESS ALERT -->
    <?php
    if(isset($_SESSION['flash'])){
        alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
        unset($_SESSION['flash']); // Hapus flash biar cuma muncul sekali
    }
    ?>

    <form id="form-tiket-masuk" action="?action=store-tiket-masuk" method="POST" class="space-y-6">

        <!-- Nomor Polisi -->
        <div>
            <label class="block mb-2 text-slate-300">Nomor Polisi</label>
            <input type="text"
                   name="nomor_polisi"
                   required
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600
                          focus:ring-2 focus:ring-cyan-500 outline-none">
        </div>

        <!-- Jenis Kendaraan -->
        <div>
            <label class="block mb-2 text-slate-300">Jenis Kendaraan</label>
            <select id="jenis_kendaraan" name="jenis_kendaraan" required
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600
                           focus:ring-2 focus:ring-cyan-500 outline-none">
                <option value="motor">Motor</option>
                <option value="mobil">Mobil</option>
            </select>
        </div>

        <!-- Tarif -->
        <div>
            <label class="block mb-2 text-slate-300">Tarif Parkir</label>
            <select id="id_tarif" name="id_tarif" required 
                    class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600
                           focus:ring-2 focus:ring-cyan-500 outline-none">
                <?php foreach($data_tarif as $tarif): ?>
                    <!-- tambahkan data-jenis supaya JS bisa mencocokkan -->
                    <option value="<?= $tarif['id_tarif'] ?>" data-jenis="<?= $tarif['jenis_kendaraan'] ?>">
                        <?= ucfirst($tarif['jenis_kendaraan']) ?> - Rp <?= number_format($tarif['harga_flat']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <p id="tarif-note" class="text-sm text-slate-400 mt-2">
                Tarif akan otomatis terpilih berdasarkan jenis kendaraan. Kamu bisa ubah manual jika perlu.
            </p>
        </div>

        <!-- BUTTON -->
        <button type="submit"
                class="w-full py-3 mt-4 bg-cyan-500 hover:bg-cyan-600 text-slate-900 text-lg font-semibold rounded-lg transition">
            <i class="fa-solid fa-save mr-2"></i> Simpan Tiket
        </button>

        <a href="?action=index"
           class="mt-2 w-full text-center border border-cyan-400
                    text-cyan-400 p-2 rounded-lg hover:bg-cyan-500 hover:text-slate-900
                    flex items-center justify-center gap-2 transition">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>

        <a href="?action=print-tiket&id=<?= $id ?>" class="btn btn-primary">Print</a>
<a href="?action=hapus-tiket&id=<?= $id ?>" class="btn btn-danger">Batal</a>
                    
    </form>
</div>

<script>
// pilih elemen
const jenisSelect = document.getElementById('jenis_kendaraan');
const tarifSelect = document.getElementById('id_tarif');

// fungsi untuk memilih option tarif yg pertama cocok data-jenis === jenisSelect.value
function syncTarifToJenis() {
    const jenis = jenisSelect.value;
    const options = Array.from(tarifSelect.options);

    // cari option yang memiliki data-jenis sama (prioritas pertama)
    const matched = options.find(opt => opt.dataset.jenis === jenis);

    if (matched) {
        tarifSelect.value = matched.value;
        // jika mau memblokir perubahan manual: tarifSelect.disabled = true;
    } else {
        // jika tidak ada match, biarkan pilihan default (atau kosongkan)
        // tarifSelect.value = "";
    }
}

// sinkron saat halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
    syncTarifToJenis();
});

// sinkron saat user ganti jenis kendaraan
jenisSelect.addEventListener('change', () => {
    syncTarifToJenis();
});
</script>

</body>
</html>
