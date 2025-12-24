<?php
use Picqer\Barcode\BarcodeGeneratorPNG;

$tanggal = date("d M Y", strtotime($tiket['tgl_masuk']));
$jam     = date("H:i:s", strtotime($tiket['tgl_masuk']));

$generator = new BarcodeGeneratorPNG();
// Lebar garis (ketebalan)
$barWidth = 2;      // default 1

// Tinggi barcode
$barHeight = 50;    // default 30

$barcode_png = base64_encode(
    $generator->getBarcode($tiket['barcode'], $generator::TYPE_CODE_128)
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Tiket Parkir</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @media print {
            body { margin: 0; padding: 0; }
        }
    </style>
</head>

<body class="p-4 bg-gray-100" onload="window.print()">

<div class="w-[300px] mx-auto bg-white rounded-lg shadow-lg border border-gray-300 p-4 text-sm">

    <div class="text-center mb-3">
        <h2 class="text-lg font-bold tracking-wider text-gray-700">TIKET PARKIR</h2>
        <p class="text-gray-500 text-xs">Sistem Parkir Otomatis</p>
    </div>

    <!-- BARCODE PNG -->
    <div class="flex flex-col items-center mb-2">
        <img src="data:image/png;base64,<?= $barcode_png ?>" class="w-64" />

        <p class="tracking-widest text-gray-700 font-semibold text-base mt-1">
            <?= $tiket['barcode'] ?>
        </p>
    </div>

    <hr class="my-3 border-gray-300">

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
            <span class="text-gray-600">Tanggal:</span>
            <span class="font-semibold"><?= $tanggal ?></span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-600">Jam:</span>
            <span class="font-semibold"><?= $jam ?></span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-600">Petugas:</span>
            <span class="font-semibold"><?= $tiket['petugas_masuk'] ?? '-' ?></span>
        </div>
    </div>

    <hr class="my-3 border-gray-300">

    <p class="text-center text-[11px] text-gray-500">
        JANGAN MENGHILANGKAN TIKET & BARANG BERHARGA.
    </p>
</div>

<script>
    window.onload = function () {
        window.print();
        window.onafterprint = () => window.location.href = "?action=tiket-masuk";
    };
</script>

</body>
</html>
