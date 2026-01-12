<div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6" id="chart-container">
    <div class="
        bg-surface border border-border
        rounded-xl p-4
        shadow-md
    ">
        <h3 class="
            text-lg font-semibold
            text-primary
            mb-4
        ">
            Status Tiket
        </h3>
        <canvas id="chartStatusTiket"></canvas>
    </div>

    <div class="
        bg-surface border border-border
        rounded-xl p-4
        shadow-md
    ">
        <h3 class="
            text-lg font-semibold
            text-primary
            mb-4
        ">
            Jenis Kendaraan
        </h3>
        <canvas id="chartJenisKendaraan"></canvas>
    </div>
</div>

<div class="mt-10">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 flex-wrap">
        <h2 class="text-xl sm:text-2xl font-semibold text-primary">
            Daftar <span class="text-muted">Tiket</span>
        </h2>

        <div class="flex flex-wrap gap-2">
            <form action="?action=import-tiket-excel" method="POST" enctype="multipart/form-data">
                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-soft-success border border-success rounded-lg hover-bg-success transition text-sm font-medium">
                    <i class="fa-solid fa-file-import"></i> Import Excel
                    <input type="file" name="file_excel" accept=".xls,.xlsx" class="hidden" onchange="this.form.submit()">
                </label>
            </form>

            <a href="?action=export-tiket-excel" class="inline-flex items-center gap-2 px-4 py-2 bg-soft-primary border border-primary rounded-lg hover-bg-primary transition text-sm font-medium">
                <i class="fa-solid fa-file-export"></i> Export Excel
            </a>
        </div>
    </div>

    <?php if (empty($listTiket)): ?>

    <div class="bg-surface border border-border rounded-xl p-8 text-center mt-6">
        <div class="flex flex-col items-center gap-3">
            <i class="fa-solid fa-qrcode text-4xl text-muted"></i>

            <h3 class="text-lg font-semibold text-text">
                Data Tiket Kosong
            </h3>

            <p class="text-sm text-muted max-w-md">
                Belum ada data tiket parkir yang tersedia.  
                Silakan lakukan 

                <form action="?action=import-tiket-excel" method="POST" enctype="multipart/form-data" class="inline">
                    <label class="text-success font-medium cursor-pointer hover:underline">
                        import Excel
                        <input 
                            type="file" 
                            name="file_excel" 
                            accept=".xls,.xlsx" 
                            class="hidden" 
                            onchange="this.form.submit()"
                        >
                    </label>
                </form>

                atau buat tiket parkir baru.
            </p>
        </div>
    </div>

    <?php else: ?>
     
<div class="space-y-4">
    <?php foreach($listTiket as $tiket): ?>
        <div class="bg-surface border border-border rounded-xl p-4 shadow-sm sm:hidden">
            <?php
            $status = $tiket['status'] ?? '-';
            $statusClass = match ($status) {
                'masuk'  => 'bg-soft-primary',
                'keluar' => 'bg-soft-danger',
                default  => 'bg-soft-muted',
            };

            $kendaraan = $tiket['jenis_kendaraan'] ?? '-';
            $map = [
                'motor' => [
                    'class' => 'bg-soft-primary',
                    'icon'  => '<i class="fa-solid fa-motorcycle mr-1"></i>'
                ],
                'mobil' => [
                    'class' => 'bg-soft-warning',
                    'icon'  => '<i class="fa-solid fa-car mr-1"></i>'
                ],
            ];
            $colorClass = $map[$kendaraan]['class'] ?? 'bg-soft-muted';
            $icon = $map[$kendaraan]['icon'] ?? '';
            ?>

            <div class="grid grid-cols-2 gap-2 text-xs text-text">
                <div class="font-medium text-muted">ID Tiket:</div>
                <div class="text-right font-semibold">
                    <?= $tiket['id_tiket'] ?>
                </div>

                <div class="font-medium text-muted">No Polisi:</div>
                <div class="text-right">
                    <?= $tiket['nomor_polisi'] ?>
                </div>

                <div class="font-medium text-muted">Jenis Kendaraan:</div>
                <div class="text-right">
                    <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $colorClass ?>">
                        <?= $icon . $kendaraan ?>
                    </span>
                </div>

                <div class="font-medium text-muted">Tgl Masuk:</div>
                <div class="text-right">
                    <?= $tiket['tgl_masuk'] ? (new DateTime($tiket['tgl_masuk']))->format('d M Y • H:i') : '-' ?>
                </div>

                <div class="font-medium text-muted">Petugas Masuk:</div>
                <div class="text-right">
                    <?= $tiket['petugas_masuk'] ?>
                </div>

                <div class="font-medium text-muted">Tgl Keluar:</div>
                <div class="text-right">
                    <?php if ($tiket['tgl_keluar']): ?>
                        <?= (new DateTime($tiket['tgl_keluar']))->format('d M Y • H:i') ?>
                    <?php else: ?>
                        <span class="text-muted italic">Belum keluar</span>
                    <?php endif; ?>
                </div>

                <div class="font-medium text-muted">Petugas Keluar:</div>
                <div class="text-right">
                    <?= $tiket['petugas_keluar'] ?>
                </div>

                <div class="font-medium text-muted">Total Harga:</div>
                <div class="text-right font-semibold">
                    Rp <?= number_format($tiket['total_harga'] ?? 0, 0, ',', '.') ?>
                </div>

                <div class="font-medium text-muted">Status:</div>
                <div class="text-right">
                    <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $statusClass ?>">
                        <?= $status ?>
                    </span>
                </div>
            </div>

            <div class="flex justify-center mt-3">
                <?php
                $barcodeValue = $tiket['barcode'];
                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                $barcodeImage = $generator->getBarcode($barcodeValue, $generator::TYPE_CODE_128);
                ?>
                <div class="flex flex-col items-center">
                    <img src="data:image/png;base64,<?= base64_encode($barcodeImage) ?>" class="w-36 h-auto mb-1">
                    <span class="tracking-[0.25em] text-text text-xs">
                        <?= htmlspecialchars($barcodeValue) ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

    <div class="overflow-x-auto bg-surface rounded-xl border border-border p-4 hidden sm:block">
        <table class="min-w-full text-xs">
            <thead class="bg-bg text-text">
                <tr>
                    <th class="px-3 py-2 ">ID</th>
                    <th class="px-3 py-2  text-center">Barcode</th>
                    <th class="px-3 py-2 ">No Polisi</th>
                    <th class="px-3 py-2 ">Kendaraan</th>
                    <th class="px-3 py-2 ">Tgl Masuk</th>
                    <th class="px-3 py-2  text-center">Petugas Masuk</th>
                    <th class="px-3 py-2 ">Tgl Keluar</th>
                    <th class="px-3 py-2 text-center">Petugas Keluar</th>
                    <th class="px-3 py-2  text-right">Total</th>
                    <th class="px-3 py-2  text-center">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-neutral-600 text-text">
                <?php foreach($listTiket as $tiket): ?>
                    <tr class="hover-bg-primary transition">
                        <td class="px-2 py-2 align-middle"><?= $tiket['id_tiket'] ?></td>
                        <td class="px-2 py-2 align-middle">
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
                        <td class="px-2 py-1 align-middle"><?= $tiket['nomor_polisi'] ?></td>
                        <?php
                        $kendaraan = $tiket['jenis_kendaraan'] ?? '-';
                        $map = [
                            'motor' => ['class' => 'bg-soft-primary', 'icon' => '<i class="fa-solid fa-motorcycle mr-1"></i>'],
                            'mobil' => ['class' => 'bg-soft-warning', 'icon' => '<i class="fa-solid fa-car mr-1"></i>'],
                        ];
                        $colorClass = $map[$kendaraan]['class'] ?? 'bg-soft-muted';
                        $icon = $map[$kendaraan]['icon'] ?? '';
                        $status = $tiket['status'] ?? '-';
                        $statusClass = match ($status) {
                            'masuk' => 'bg-soft-success',
                            'keluar' => 'bg-soft-danger',
                            default => 'bg-soft-muted',
                        };
                        ?>
                        <td class="px-2 py-1 align-middle"><span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $colorClass ?>">
                            <?= $icon ?><?= ucfirst($kendaraan) ?>
                        </span>
                        </td>
                        <?php
                        $dt = $tiket['tgl_masuk'] ? new DateTime($tiket['tgl_masuk']) : null;
                        ?>

                        <td class="px-2 py-1 align-middle">
                            <?php if ($dt): ?>
                            <span class="relative group cursor-help">
                                <?= $dt->format('d M Y') ?>

                                <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1
                                            hidden group-hover:block
                                            bg-bg text-text text-[10px]
                                            px-2 py-1 rounded shadow-lg whitespace-nowrap">
                                    <?= $dt->format('H:i') ?>
                                </span>
                            </span>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>

                        <td class="px-2 py-1 align-middle">
                            <span class="px-2 py-0.5 rounded text-text text-[11px]">
                                <?= $tiket['petugas_masuk'] ?? '-' ?>
                            </span>
                        </td>
                        <?php
                        $dt = $tiket['tgl_keluar'] ? new DateTime($tiket['tgl_keluar']) : null;
                        ?>

                        <td class="px-2 py-1 align-middle">
                            <?php if ($dt): ?>
                            <span class="relative group cursor-help">
                                <?= $dt->format('d M Y') ?>
                                <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1
                                            hidden group-hover:block
                                            bg-bg text-text text-[10px]
                                            px-2 py-1 rounded shadow-lg">
                                    <?= $dt->format('H:i') ?>
                                </span>
                            </span>
                            <?php else: ?>
                                <span class="text-muted italic">Belum keluar</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-2 py-1 align-middle">
                            <span class="px-2 py-0.5 rounded text-text text-[11px]">
                                <?= $tiket['petugas_keluar'] ?? '-' ?>
                            </span>
                        </td>
                        <td class="px-3 py-2 text-right font-semibold text-[11px]">
                            Rp <?= number_format($tiket['total_harga'] ?? 0, 0, ',', '.') ?>
                        </td>

                        <td class="px-2 py-1 align-middle">
                            <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $statusClass ?>"><?= ucfirst($status) ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

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
                class="px-3 py-1 rounded
                    bg-surface text-muted
                    hover-bg-primary hover-text-primary
                    transition">
                Prev
            </button>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <button
                onclick="loadTable('tiket', null, <?= $i ?>)"
                class="px-3 py-1 rounded transition
                <?= $i == $pageTiket
                    ? 'bg-primary text-bg font-semibold'
                    : 'bg-surface text-muted hover-bg-primary hover-text-primary' ?>">
                <?= $i ?>
            </button>
        <?php endfor; ?>

        <?php if ($pageTiket < $totalPagesTiket): ?>
            <button
                onclick="loadTable('tiket', null, <?= $pageTiket + 1 ?>)"
                class="px-3 py-1 rounded
                    bg-surface text-muted
                    hover-bg-primary hover-text-primary
                    transition">
                Next
            </button>
        <?php endif; ?>
        </div>
    </div>
<?php endif?>