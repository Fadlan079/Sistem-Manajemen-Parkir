<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Preview Tiket</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Barcode Font -->
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128&display=swap" rel="stylesheet">

    <style>
        .barcode-font {
            font-family: "Libre Barcode 128", cursive;
            line-height: 0.85; /* Supaya tidak offside */
        }
    </style>
</head>

<body class="bg-slate-900 text-white p-6">

<div class="max-w-md mx-auto bg-slate-800 shadow-xl rounded-2xl p-6 border border-slate-700">

    <h2 class="text-2xl font-bold text-cyan-400 mb-5 text-center">
        Preview Tiket Parkir
    </h2>

    <!-- 🔥 TIKET STYLE REAL -->
    <div class="w-[300px] mx-auto bg-white text-black rounded-lg shadow-lg border border-gray-300 p-4 text-sm">

        <!-- Header -->
        <div class="text-center mb-3">
            <h2 class="text-lg font-bold tracking-wider text-gray-700">TIKET PARKIR</h2>
            <p class="text-gray-500 text-xs">Sistem Parkir Otomatis</p>
        </div>

        <!-- Barcode -->
        <div class="flex flex-col items-center mb-3">
            <div class="barcode-font text-[60px]">
                *<?= $tiket['barcode'] ?>*
            </div>
            <p class="tracking-widest text-gray-800 font-semibold text-base mt-1">
                <?= $tiket['barcode'] ?>
            </p>
        </div>

        <hr class="my-3 border-gray-300">

        <!-- Detail -->
        <div class="space-y-1">
            <div class="flex justify-between">
                <span class="text-gray-600">No. Polisi:</span>
                <span class="font-semibold"><?= $tiket['nomor_polisi'] ?></span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-600">Jenis:</span>
                <span class="font-semibold"><?= $tiket['jenis_kendaraan'] ?></span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-600">Masuk:</span>
                <span class="font-semibold"><?= $tiket['tgl_masuk'] ?></span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-600">Petugas:</span>
                <span class="font-semibold"><?= $tiket['id_petugas_masuk'] ?></span>
            </div>
        </div>

        <hr class="my-3 border-gray-300">

        <p class="text-center text-[11px] text-gray-500">
            Simpan tiket ini untuk keluar parkir.
        </p>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="mt-6 flex flex-col gap-3">

        <a href="?action=print-tiket&id=<?= $tiket['id_tiket'] ?>"
           class="w-full py-3 bg-cyan-500 hover:bg-cyan-600 text-slate-900 font-bold rounded-lg text-center">
            Print Tiket
        </a>

        <a href="?action=hapus-tiket&id=<?= $tiket['id_tiket'] ?>"
           class="w-full py-3 bg-red-500 hover:bg-red-600 font-bold rounded-lg text-center">
            Batalkan Tiket
        </a>
    </div>

</div>

</body>
</html>
