<?php include __DIR__ . "/../components/global-modal.php" ?>

<div class="max-w-6xl mx-auto space-y-4 lg:ml-30 px-6 pt-6">
    <div class="mb-6">
        <h2 class="text-xl sm:text-2xl font-semibold text-primary">
            Daftar <span class="text-muted">Tarif Parkir</span>
        </h2>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="?action=tambah-tarif" class="flex flex-col justify-center items-center bg-surface border border-primary rounded-xl p-6 shadow-md hover:bg-bg transition text-primary">
            <i class="fas fa-plus text-2xl mb-2"></i>
            <span class="font-medium text-sm">Tambah Tarif</span>
        </a>

        <?php foreach($listTarif as $tarif): ?>
            <div class="bg-surface border border-border rounded-xl p-6 shadow-md flex flex-col justify-between">
                <div class="space-y-2">
                    <div class="text-sm text-muted">Jenis Kendaraan:</div>
                    <div class="text-lg font-semibold text-text"><?= ucfirst($tarif['jenis_kendaraan']) ?></div>

                    <div class="text-sm text-muted mt-2">Harga Flat:</div>
                    <div class="text-lg font-semibold text-text">Rp <?= number_format($tarif['harga_flat'],0,",",".") ?></div>

                    <div class="text-sm text-muted mt-2">Terakhir Diupdate:</div>
                    <div class="text-sm text-text"><?= $tarif['updated_at'] ?? '-' ?></div>
                </div>

                <div class="mt-4 flex gap-2">
                    <a href="?action=edit-tarif&id=<?= $tarif['id_tarif'] ?>" 
                       class="flex-1 px-3 py-2 bg-warning hover:opacity-90 text-text rounded flex items-center justify-center gap-2">
                       <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="?action=delete-tarif&id=<?= $tarif['id_tarif'] ?>" 
                       onclick="return confirm('Yakin ingin menghapus tarif ini?');"
                       class="flex-1 px-3 py-2 bg-danger hover:opacity-90 text-text rounded flex items-center justify-center gap-2">
                       <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>