<?php include __DIR__ . "/../components/global-modal.php" ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tarif Parkir</title>
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
          integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body class="bg-slate-900 min-h-screen p-6">
    <?php include __DIR__ . "/../components/header.php"?>

    <div class="max-w-6xl mx-auto space-y-4 mt-20">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-xl sm:text-2xl font-semibold text-cyan-400">
                Daftar <span class="text-neutral-400">Tarif Parkir</span>
            </h2>
        </div>

        <!-- Card Grid (Desktop + Mobile) -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Add Tarif Card -->
            <a href="?action=tambah-tarif" class="flex flex-col justify-center items-center bg-slate-800 border border-cyan-600/40 rounded-xl p-6 shadow-md hover:bg-slate-700 transition text-cyan-400">
                <i class="fas fa-plus text-2xl mb-2"></i>
                <span class="font-medium text-sm">Tambah Tarif</span>
            </a>

            <!-- Existing Tarif Cards -->
            <?php foreach($listTarif as $tarif): ?>
                <div class="bg-slate-800 border border-slate-700 rounded-xl p-6 shadow-md flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="text-sm text-slate-400">Jenis Kendaraan:</div>
                        <div class="text-lg font-semibold text-white"><?= ucfirst($tarif['jenis_kendaraan']) ?></div>

                        <div class="text-sm text-slate-400 mt-2">Harga Flat:</div>
                        <div class="text-lg font-semibold text-white">Rp <?= number_format($tarif['harga_flat'],0,",",".") ?></div>

                        <div class="text-sm text-slate-400 mt-2">Terakhir Diupdate:</div>
                        <div class="text-sm text-slate-300"><?= $tarif['updated_at'] ?? '-' ?></div>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <a href="?action=edit-tarif&id=<?= $tarif['id_tarif'] ?>" 
                           class="flex-1 px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-slate-900 rounded flex items-center justify-center gap-2">
                           <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="?action=delete-tarif&id=<?= $tarif['id_tarif'] ?>" 
                           onclick="return confirm('Yakin ingin menghapus tarif ini?');"
                           class="flex-1 px-3 py-2 bg-red-500 hover:bg-red-600 text-slate-900 rounded flex items-center justify-center gap-2">
                           <i class="fas fa-trash"></i> Hapus
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
