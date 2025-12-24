<?php include __DIR__ . '/../components/global-modal.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tiket Keluar</title>

    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
          integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>

<body class="bg-slate-900 text-white">

<div class="max-w-xl mx-auto mt-16 bg-slate-800 border border-slate-700 p-8 rounded-2xl shadow-lg">

    <h2 class="text-3xl font-bold text-cyan-400 mb-6 flex items-center gap-3">
        <i class="fa-solid fa-ticket"></i>
        Tiket Keluar
    </h2>

    <!-- SUCCESS ALERT -->
    <?php
    if(isset($_SESSION['flash'])){
        alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
        unset($_SESSION['flash']); // Hapus flash biar cuma muncul sekali
    }
    ?>

    <form action="?action=update-tiket-keluar" method="POST" class="space-y-6">

        <!-- BARCODE -->
        <div>
            <label class="block mb-2 text-slate-300">Scan / Masukkan Barcode</label>
            <input type="text" name="barcode" required autofocus
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600
                          focus:ring-2 focus:ring-cyan-500 outline-none">
        </div>

        <!-- DATA OTOMATIS (READONLY) -->
        <div>
            <label class="block text-slate-300 mb-1">Nomor Polisi</label>
            <input type="text" name="nomor_polisi" readonly
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600">
        </div>

        <div>
            <label class="block text-slate-300 mb-1">Jenis Kendaraan</label>
            <input type="text" name="jenis_kendaraan" readonly
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600">
        </div>

        <div>
            <label class="block text-slate-300 mb-1">Tarif (Rp)</label>
            <input type="text" name="tarif" readonly
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600">
        </div>

        <div>
            <label class="block text-slate-300 mb-1">Durasi Parkir</label>
            <input type="text" name="durasi" readonly
                   class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600">
        </div>

        <div>
            <label class="block text-slate-300 mb-1">Total Harga (Rp)</label>
<input type="text" name="total_harga" readonly
class="w-full px-4 py-2 rounded-lg bg-slate-700 border border-slate-600">

        </div>

        <!-- HIDDEN untuk ke PHP -->
        <input type="hidden" name="id_tarif">
        <input type="hidden" name="tgl_keluar">

        <!-- BUTTON -->
        <button type="submit"
                class="w-full py-3 mt-4 bg-green-500 hover:bg-green-600 text-slate-900 text-lg font-semibold rounded-lg transition">
            <i class="fa-solid fa-door-open mr-2"></i> Selesaikan Tiket
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

</body>
</html>
<script>
document.addEventListener("DOMContentLoaded", () => {

    const form = document.querySelector("form");
    const barcodeInput = document.querySelector('input[name="barcode"]');

    // field otomatis
    const noPolInput = document.querySelector('input[name="nomor_polisi"]');
    const jenisInput = document.querySelector('input[name="jenis_kendaraan"]');
    const tarifInput = document.querySelector('input[name="tarif"]');
    const durasiInput = document.querySelector('input[name="durasi"]');
    const totalInput = document.querySelector('input[name="total_harga"]'); // hidden

    const idTarifHidden = document.querySelector('input[name="id_tarif"]');
    const tglKeluarHidden = document.querySelector('input[name="tgl_keluar"]');

    // fungsi hitung durasi parkir
    function hitungDurasi(tglMasuk) {

        // FIX parsing tanggal agar tidak dianggap UTC
        const [datePart, timePart] = tglMasuk.split(" ");
        const [year, month, day] = datePart.split("-");
        const [hour, minute, second] = timePart.split(":");

        const masuk = new Date(year, month - 1, day, hour, minute, second); // WITA lokal
        const keluar = new Date(); // Waktu lokal real

        const diff = Math.floor((keluar - masuk) / 1000);
        const jam = Math.floor(diff / 3600);
        const menit = Math.floor((diff % 3600) / 60);

        return `${jam} jam ${menit} menit`;
    }


    // reset semua field
    function resetFields() {
        noPolInput.value = "";
        jenisInput.value = "";
        tarifInput.value = "";
        durasiInput.value = "";
        totalInput.value = "";
        idTarifHidden.value = "";
        tglKeluarHidden.value = "";

        noPolInput.disabled = false;
        jenisInput.disabled = false;
        tarifInput.disabled = false;
        durasiInput.disabled = false;
    }

    // EVENT SCAN BARCODE — REALTIME
    barcodeInput.addEventListener("input", () => {
        const barcode = barcodeInput.value.trim();

        // barcode scanner biasanya menembakkan 10–20 karakter sekaligus
        if (barcode.length < 8) return;

        fetch(`?action=get-tiket-by-barcode&barcode=${barcode}`)
            .then(res => res.json())
            .then(res => {
                if (res.status === "success") {

                    const d = res.data;

                    // isi field otomatis
                    noPolInput.value = d.nomor_polisi;
                    jenisInput.value = d.jenis_kendaraan;
                    tarifInput.value = d.harga_flat;
                    durasiInput.value = hitungDurasi(d.tgl_masuk);
                    totalInput.value = d.harga_flat;

                    // hidden tambahan
                    idTarifHidden.value = d.id_tarif;
                    tglKeluarHidden.value = new Date().toISOString().slice(0,19).replace("T"," ");

                    // DISABLE agar tidak diubah
                    noPolInput.disabled = true;
                    jenisInput.disabled = true;
                    tarifInput.disabled = true;
                    durasiInput.disabled = true;

                    // AUTOMATIC SUBMIT — langsung update tiket keluar
                    // setTimeout(() => {
                    //     form.submit();
                    // }, 300);

                } else {
                    alert("❌ Barcode tidak ditemukan!");
                    resetFields();
                }

            })
            .catch(() => {
                alert("❌ Terjadi kesalahan koneksi!");
                resetFields();
            });
    });

});
</script>