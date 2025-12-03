<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Tiket Parkir</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Barcode font -->
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128&display=swap" rel="stylesheet">

    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
        }
        .barcode-font {
            font-family: "Libre Barcode 128", cursive;
        }
    </style>
</head>

<body class="p-4 bg-gray-100" onload="window.print()">

<div class="w-[300px] mx-auto bg-white rounded-lg shadow-lg border border-gray-300 p-4 text-sm">

    <!-- Header -->
    <div class="text-center mb-3">
        <h2 class="text-lg font-bold tracking-wider text-gray-700">TIKET PARKIR</h2>
        <p class="text-gray-500 text-xs">Sistem Parkir Otomatis</p>
    </div>

    <!-- Barcode -->
    <div class="text-center mb-2">
        <div class="barcode-font text-[60px] leading-none">
            *<?= $tiket['barcode'] ?>*
        </div>
        <p class="tracking-widest text-gray-700 font-semibold text-base mt-1">
            <?= $tiket['barcode'] ?>
        </p>
    </div>

    <hr class="my-3 border-gray-300">

    <!-- Detail Tiket -->
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

    <!-- Footer -->
    <p class="text-center text-[11px] text-gray-500">
        Simpan tiket ini untuk keluar parkir.
    </p>
</div>

</body>
</html>
