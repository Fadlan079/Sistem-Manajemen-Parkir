<div class="mt-10">
    <!-- Header & Tombol Import/Export -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 flex-wrap">
        <h2 class="text-xl sm:text-2xl font-semibold text-cyan-400">
            Daftar <span class="text-neutral-400">Tiket</span>
        </h2>

        <div class="flex flex-wrap gap-2">
            <!-- Import Excel -->
            <form action="?action=import-tiket-excel" method="POST" enctype="multipart/form-data">
                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-emerald-600/20 text-emerald-400 border border-emerald-600/40 rounded-lg hover:bg-emerald-600/30 transition text-sm font-medium">
                    <i class="fa-solid fa-file-import"></i> Import Excel
                    <input type="file" name="file_excel" accept=".xls,.xlsx" class="hidden" onchange="this.form.submit()">
                </label>
            </form>

            <!-- Export Excel -->
            <a href="?action=export-tiket-excel" class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600/20 text-cyan-400 border border-cyan-600/40 rounded-lg hover:bg-cyan-600/30 transition text-sm font-medium">
                <i class="fa-solid fa-file-export"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Card Style Mobile -->
    <div class="space-y-4">
        <?php foreach($listTiket as $tiket): ?>
            <div class="bg-slate-800 border border-slate-700 rounded-xl p-4 shadow-sm sm:hidden">
                <?php
                $status = $tiket['status'] ?? '-';
                $statusClass = match ($status) {
                    'masuk' => 'bg-emerald-500/20 text-emerald-400',
                    'keluar' => 'bg-red-500/20 text-red-400',
                    default => 'bg-slate-500/20 text-slate-400',
                };
                $kendaraan = $tiket['jenis_kendaraan'] ?? '-';
                $map = [
                    'motor' => ['class' => 'bg-sky-500/20 text-sky-400', 'icon' => '<i class="fa-solid fa-motorcycle mr-1"></i>'],
                    'mobil' => ['class' => 'bg-amber-500/20 text-amber-400', 'icon' => '<i class="fa-solid fa-car mr-1"></i>'],
                ];
                $colorClass = $map[$kendaraan]['class'] ?? 'bg-slate-500/20 text-slate-400';
                $icon = $map[$kendaraan]['icon'] ?? '';
                ?>
                <div class="grid grid-cols-2 gap-2 text-sm text-slate-300">
                    <div class="font-medium text-slate-400">ID Tiket:</div>
                    <div class="text-right font-semibold text-white"><?= $tiket['id_tiket'] ?></div>

                    <div class="font-medium text-slate-400">No Polisi:</div>
                    <div class="text-right"><?= $tiket['nomor_polisi'] ?></div>

                    <div class="font-medium text-slate-400">Jenis Kendaraan:</div>
                    <div class="text-right"><span class="px-2 py-1 rounded-md text-sm font-medium <?= $colorClass ?>"><?= $icon . $kendaraan ?></span></div>

                    <div class="font-medium text-slate-400">Tgl Masuk:</div>
                    <div class="text-right"><?= $tiket['tgl_masuk'] ? (new DateTime($tiket['tgl_masuk']))->format('d M Y • H:i') : '-' ?></div>

                    <div class="font-medium text-slate-400">Tgl Keluar:</div>
                    <div class="text-right">
                        <?php if ($tiket['tgl_keluar']): ?>
                            <?= (new DateTime($tiket['tgl_keluar']))->format('d M Y • H:i') ?>
                        <?php else: ?>
                            - Belum keluar
                        <?php endif; ?>
                    </div>

                    <div class="font-medium text-slate-400">Total Harga:</div>
                    <div class="text-right font-semibold">Rp <?= number_format($tiket['total_harga'] ?? 0, 0, ',', '.') ?></div>

                    <div class="font-medium text-slate-400">Status:</div>
                    <div class="text-right"><span class="px-2 py-1 rounded text-xs font-medium <?= $statusClass ?>"><?= $status ?></span></div>
                </div>

                <!-- Barcode di bawah -->
                <div class="flex justify-center mt-3">
                    <?php
                    $barcodeValue = $tiket['barcode'];
                    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                    $barcodeImage = $generator->getBarcode($barcodeValue, $generator::TYPE_CODE_128);
                    ?>
                    <div class="flex flex-col items-center">
                        <img src="data:image/png;base64,<?= base64_encode($barcodeImage) ?>" class="w-36 h-auto mb-1">
                        <span class="tracking-[0.25em] text-slate-300 text-xs"><?= htmlspecialchars($barcodeValue) ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Desktop Table -->
    <div class="overflow-x-auto bg-slate-800 rounded-xl border border-slate-700 p-4 hidden sm:block">
        <table class="min-w-full divide-y divide-slate-700 text-sm">
            <thead class="bg-slate-900 text-slate-400">
                <tr>
                    <th class="px-6 py-3 text-left">ID Tiket</th>
                    <th class="px-6 py-3 text-left">Barcode</th>
                    <th class="px-6 py-3 text-left">No Polisi</th>
                    <th class="px-6 py-3 text-left">Jenis Kendaraan</th>
                    <th class="px-6 py-3 text-left">Tgl Masuk</th>
                    <th class="px-6 py-3 text-left">Tgl Keluar</th>
                    <th class="px-6 py-3 text-left">Total Harga</th>
                    <th class="px-6 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700 text-slate-300">
                <?php foreach($listTiket as $tiket): ?>
                    <tr class="hover:bg-slate-700 transition">
                        <td class="px-6 py-3"><?= $tiket['id_tiket'] ?></td>
                        <td class="px-6 py-3 text-center">
                            <?php
                            $barcodeValue = $tiket['barcode'];
                            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                            $barcodeImage = $generator->getBarcode($barcodeValue, $generator::TYPE_CODE_128);
                            ?>
                            <div class="flex flex-col items-center">
                                <img src="data:image/png;base64,<?= base64_encode($barcodeImage) ?>" class="w-36 h-auto">
                                <span class="tracking-[0.25em] text-xs mt-1"><?= htmlspecialchars($barcodeValue) ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-3"><?= $tiket['nomor_polisi'] ?></td>
                        <?php
                        $kendaraan = $tiket['jenis_kendaraan'] ?? '-';
                        $map = [
                            'motor' => ['class' => 'bg-sky-500/20 text-sky-400', 'icon' => '<i class="fa-solid fa-motorcycle mr-1"></i>'],
                            'mobil' => ['class' => 'bg-amber-500/20 text-amber-400', 'icon' => '<i class="fa-solid fa-car mr-1"></i>'],
                        ];
                        $colorClass = $map[$kendaraan]['class'] ?? 'bg-slate-500/20 text-slate-400';
                        $icon = $map[$kendaraan]['icon'] ?? '';
                        $status = $tiket['status'] ?? '-';
                        $statusClass = match ($status) {
                            'masuk' => 'bg-emerald-500/20 text-emerald-400',
                            'keluar' => 'bg-red-500/20 text-red-400',
                            default => 'bg-slate-500/20 text-slate-400',
                        };
                        ?>
                        <td class="px-6 py-3"><span class="px-2 py-1 rounded-md font-medium <?= $colorClass ?>"><?= $icon . $kendaraan ?></span></td>
                        <td class="px-6 py-3"><?= $tiket['tgl_masuk'] ? (new DateTime($tiket['tgl_masuk']))->format('d M Y • H:i') : '-' ?></td>
                        <td class="px-6 py-3"><?= $tiket['tgl_keluar'] ? (new DateTime($tiket['tgl_keluar']))->format('d M Y • H:i') : '- Belum keluar' ?></td>
                        <td class="px-6 py-3 font-semibold">Rp <?= number_format($tiket['total_harga'] ?? 0, 0, ',', '.') ?></td>
                        <td class="px-6 py-3"><span class="px-2 py-1 rounded-md font-medium <?= $statusClass ?>"><?= $status ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Maksimal 7 tombol -->
<div class="flex flex-wrap justify-center gap-2 mt-4">
<?php
$maxButtons = 5;
$start = max(1, $pageTiket - intdiv($maxButtons, 2));
$end = min($totalPagesTiket, $start + $maxButtons - 1);
$start = max(1, $end - $maxButtons + 1);
?>

<?php if ($pageTiket > 1): ?>
    <button
        onclick="loadTable('tiket', null, <?= $pageTiket - 1 ?>)"
        class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">
        Prev
    </button>
<?php endif; ?>

<?php for ($i = $start; $i <= $end; $i++): ?>
    <button
        onclick="loadTable('tiket', null, <?= $i ?>)"
        class="px-3 py-1 rounded
        <?= $i == $pageTiket
            ? 'bg-cyan-500 text-white'
            : 'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>">
        <?= $i ?>
    </button>
<?php endfor; ?>

<?php if ($pageTiket < $totalPagesTiket): ?>
    <button
        onclick="loadTable('tiket', null, <?= $pageTiket + 1 ?>)"
        class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">
        Next
    </button>
<?php endif; ?>
</div>

    
</div>