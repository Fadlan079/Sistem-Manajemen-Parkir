<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Preview Tiket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-900 text-white p-6">

<div class="max-w-md mx-auto bg-slate-800 shadow-xl rounded-2xl p-6 border border-slate-700">

    <h2 class="text-2xl font-bold text-cyan-400 mb-4">
        Preview Tiket Parkir
    </h2>

    <div class="space-y-3">

        <p>
            <span class="text-slate-400">Barcode:</span>
            <span class="font-semibold"><?= $tiket['barcode'] ?></span>
        </p>

        <p>
            <span class="text-slate-400">Nomor Polisi:</span>
            <span class="font-semibold"><?= $tiket['nomor_polisi'] ?></span>
        </p>

        <p>
            <span class="text-slate-400">Jenis Kendaraan:</span>
            <span class="font-semibold"><?= $tiket['jenis_kendaraan'] ?></span>
        </p>

        <p>
            <span class="text-slate-400">Tanggal Masuk:</span>
            <span class="font-semibold"><?= $tiket['tgl_masuk'] ?></span>
        </p>

    </div>

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
