<div class="mt-10">
    <!-- Header & Tombol Import/Export -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 flex-wrap">
        <h2 class="text-xl sm:text-2xl font-semibold text-cyan-400">
            Daftar <span class="text-neutral-400">Transaksi</span>
        </h2>

        <div class="flex flex-wrap gap-2">
            <!-- Import Excel -->
            <form action="?action=import-transaksi-excel" method="POST" enctype="multipart/form-data">
                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-emerald-600/20 text-emerald-400 border border-emerald-600/40 rounded-lg hover:bg-emerald-600/30 transition text-sm font-medium">
                    <i class="fa-solid fa-file-import"></i> Import Excel
                    <input type="file" name="file_excel" accept=".xls,.xlsx" class="hidden" onchange="this.form.submit()">
                </label>
            </form>

            <!-- Export Excel -->
            <a href="?action=export-transaksi-excel" class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600/20 text-cyan-400 border border-cyan-600/40 rounded-lg hover:bg-cyan-600/30 transition text-sm font-medium">
                <i class="fa-solid fa-file-export"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Card Style Mobile -->
    <div class="space-y-4">
        <?php foreach($listTransaksi as $trx): ?>
            <?php
            $status = $trx['status'] ?? '-';
            $statusClass = match ($status) {
                'pending' => 'bg-yellow-500/20 text-yellow-400',
                'paid'    => 'bg-emerald-500/20 text-emerald-400',
                default   => 'bg-slate-500/20 text-slate-400'
            };

            $metode = $trx['metode'] ?? '-';
            $map = [
                'cash' => ['class' => 'bg-emerald-500/20 text-emerald-400', 'icon' => '<i class="fa-solid fa-money-bill-wave mr-1"></i>'],
                'digital' => ['class' => 'bg-blue-500/20 text-blue-400', 'icon' => '<i class="fa-solid fa-mobile-screen-button mr-1"></i>']
            ];
            $colorClass = $map[$metode]['class'] ?? 'bg-slate-500/20 text-slate-400';
            $icon = $map[$metode]['icon'] ?? '';
            $metodeDisplay = ucfirst($metode);
            ?>
            <div class="bg-slate-800 border border-slate-700 rounded-xl p-4 shadow-sm sm:hidden text-sm text-slate-300">
                <div class="grid grid-cols-2 gap-2">
                    <div class="font-medium text-slate-400">ID Transaksi:</div>
                    <div class="text-right font-semibold text-white"><?= $trx['id_transaksi'] ?></div>

                    <div class="font-medium text-slate-400">ID Tiket:</div>
                    <div class="text-right"><?= $trx['id_tiket'] ?></div>

                    <div class="font-medium text-slate-400">Metode:</div>
                    <div class="text-right"><span class="px-2 py-1 rounded-md font-medium <?= $colorClass ?>"><?= $icon . $metodeDisplay ?></span></div>

                    <div class="font-medium text-slate-400">No Polisi:</div>
                    <div class="text-right"><?= $trx['nomor_polisi'] ?></div>

                    <div class="font-medium text-slate-400">Total Bayar:</div>
                    <div class="text-right font-semibold">Rp <?= number_format($trx['jumlah_bayar'] ?? 0, 0, ',', '.') ?></div>

                    <div class="font-medium text-slate-400">Tanggal Bayar:</div>
                    <div class="text-right"><?= $trx['tgl_bayar'] ?? '-' ?></div>

                    <div class="font-medium text-slate-400">Status:</div>
                    <div class="text-right"><span class="px-2 py-1 rounded text-xs font-medium <?= $statusClass ?>"><?= $status ?></span></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Desktop Table -->
    <div class="overflow-x-auto bg-slate-800 rounded-xl border border-slate-700 p-4 hidden sm:block">
        <table class="min-w-full divide-y divide-slate-700 text-sm">
            <thead class="bg-slate-900 text-slate-400">
                <tr>
                    <th class="px-6 py-3 text-left">ID Transaksi</th>
                    <th class="px-6 py-3 text-left">ID Tiket</th>
                    <th class="px-6 py-3 text-left">Metode Pembayaran</th>
                    <th class="px-6 py-3 text-left">No Polisi</th>
                    <th class="px-6 py-3 text-left">Total Bayar</th>
                    <th class="px-6 py-3 text-left">Tanggal Bayar</th>
                    <th class="px-6 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700 text-slate-300">
                <?php foreach($listTransaksi as $trx): ?>
                    <?php
                    $status = $trx['status'] ?? '-';
                    $statusClass = match ($status) {
                        'pending' => 'bg-yellow-500/20 text-yellow-400',
                        'paid'    => 'bg-emerald-500/20 text-emerald-400',
                        default   => 'bg-slate-500/20 text-slate-400'
                    };

                    $metode = $trx['metode'] ?? '-';
                    $map = [
                        'cash' => ['class' => 'bg-emerald-500/20 text-emerald-400', 'icon' => '<i class="fa-solid fa-money-bill-wave mr-1"></i>'],
                        'digital' => ['class' => 'bg-blue-500/20 text-blue-400', 'icon' => '<i class="fa-solid fa-mobile-screen-button mr-1"></i>']
                    ];
                    $colorClass = $map[$metode]['class'] ?? 'bg-slate-500/20 text-slate-400';
                    $icon = $map[$metode]['icon'] ?? '';
                    $metodeDisplay = ucfirst($metode);
                    ?>
                    <tr class="hover:bg-slate-700 transition">
                        <td class="px-6 py-3"><?= $trx['id_transaksi'] ?></td>
                        <td class="px-6 py-3"><?= $trx['id_tiket'] ?></td>
                        <td class="px-6 py-3"><span class="px-2 py-1 rounded-md font-medium <?= $colorClass ?>"><?= $icon . $metodeDisplay ?></span></td>
                        <td class="px-6 py-3"><?= $trx['nomor_polisi'] ?></td>
                        <td class="px-6 py-3 font-semibold">Rp <?= number_format($trx['jumlah_bayar'] ?? 0, 0, ',', '.') ?></td>
                        <td class="px-6 py-3"><?= $trx['tgl_bayar'] ?? '-' ?></td>
                        <td class="px-6 py-3"><span class="px-2 py-1 rounded-md font-medium <?= $statusClass ?>"><?= $status ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Maks 5 tombol -->
<div class="flex flex-wrap justify-center gap-2 mt-4">
<?php
$maxButtons = 5;
$start = max(1, $pageTrx - intdiv($maxButtons, 2));
$end = min($totalPagesTrx, $start + $maxButtons - 1);
$start = max(1, $end - $maxButtons + 1);
?>

<?php if ($pageTrx > 1): ?>
    <button onclick="loadTable('transaksi', null, <?= $pageTrx - 1 ?>)"
        class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">
        Prev
    </button>
<?php endif; ?>

<?php for ($i = $start; $i <= $end; $i++): ?>
    <button onclick="loadTable('transaksi', null, <?= $i ?>)"
        class="px-3 py-1 rounded
        <?= $i == $pageTrx ? 'bg-cyan-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>">
        <?= $i ?>
    </button>
<?php endfor; ?>

<?php if ($pageTrx < $totalPagesTrx): ?>
    <button onclick="loadTable('transaksi', null, <?= $pageTrx + 1 ?>)"
        class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">
        Next
    </button>
<?php endif; ?>
</div>

</div>
