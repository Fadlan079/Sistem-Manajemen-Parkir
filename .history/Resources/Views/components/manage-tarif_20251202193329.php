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
    <?php include __DIR__ . "/header.php"?>

    <div class="max-w-4xl mx-auto space-y-4 mt-20">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-cyan-400">Manage <span class="text-neutral-400">Tarif Parkir</span></h1>
            <div class="flex gap-2">
                <a href="?action=index" 
                   class="bg-slate-600 hover:bg-slate-700 text-slate-200 px-4 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                   <i class="fas fa-arrow-left"></i> Dashboard
                </a>
                <a href="?action=tambah-tarif" 
                   class="bg-cyan-500 hover:bg-cyan-600 text-slate-900 px-4 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                   <i class="fas fa-plus"></i> Tambah Tarif
                </a>
            </div>
        </div>

        <div class="overflow-x-auto bg-slate-800 rounded-xl shadow-lg">
            <table class="min-w-full divide-y divide-slate-700">
                <thead class="bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-slate-300 font-medium uppercase">#</th>
                        <th class="px-6 py-3 text-left text-slate-300 font-medium uppercase">Jenis Kendaraan</th>
                        <th class="px-6 py-3 text-left text-slate-300 font-medium uppercase">Harga Flat</th>
                        <th class="px-6 py-3 text-left text-slate-300 font-medium uppercase">Terakhir Diupdate</th>
                        <th class="px-6 py-3 text-left text-slate-300 font-medium uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-slate-800 divide-y divide-slate-700">
                    <?php $no = 1; foreach($listTarif as $tarif): ?>
                        <tr class="hover:bg-slate-700 transition">
                            <td class="px-6 py-4 text-slate-300"><?= $no++ ?></td>
                            <td class="px-6 py-4 text-slate-300"><?= ucfirst($tarif['jenis_kendaraan']) ?></td>
                            <td class="px-6 py-4 text-slate-300">Rp <?= number_format($tarif['harga_flat'],0,",",".") ?></td>
                            <td class="px-6 py-4 text-slate-300"><?= $tarif['updated_at'] ?></td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="?action=edit-tarif&id=<?= $tarif['id_tarif'] ?>" 
                                   class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-slate-900 rounded flex items-center gap-1 transition">
                                   <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="?action=delete-tarif&id=<?= $tarif['id_tarif'] ?>" 
                                   onclick="return confirm('Yakin ingin menghapus tarif ini?');"
                                   class="px-3 py-1 bg-red-500 hover:bg-red-600 text-slate-900 rounded flex items-center gap-1 transition">
                                   <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(empty($listTarif)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-slate-400 py-4">Belum ada data tarif.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
