<?php if (!empty($listTransaksi)): ?>
<div id="chart-container"
     class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 lg:ml-35">

    <!-- Pendapatan Harian -->
    <div class="
        bg-surface border border-border
        p-4 rounded-xl
        shadow-md
    ">
        <h3 class="
            text-primary font-semibold mb-2
        ">
            Pendapatan Harian
        </h3>
        <canvas id="chartPendapatan"></canvas>
    </div>

    <!-- Transaksi Harian -->
    <div class="
        bg-surface border border-border
        p-4 rounded-xl
        shadow-md
    ">
        <h3 class="
            text-primary font-semibold mb-2
        ">
            Jumlah Transaksi Harian
        </h3>
        <canvas id="chartTrxHarian"></canvas>
    </div>

    <!-- Status Transaksi -->
    <div class="
        bg-surface border border-border
        p-4 rounded-xl
        shadow-md
    ">
        <h3 class="
            text-primary font-semibold mb-2
        ">
            Status Transaksi
        </h3>
        <canvas id="chartStatus"></canvas>
    </div>

    <!-- Distribusi Nominal -->
    <div class="
        bg-surface border border-border
        p-4 rounded-xl
        shadow-md
    ">
        <h3 class="
            text-primary font-semibold mb-2
        ">
            Distribusi Nominal
        </h3>
        <canvas id="chartNominal"></canvas>
    </div>

</div>

<?php endif; ?>

<div class="mt-10 lg:ml-35">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 flex-wrap">
        <h2 class="text-xl sm:text-2xl font-semibold text-primary">
            Daftar <span class="text-muted">Transaksi</span>
        </h2>

        <div class="flex flex-wrap gap-2">
            <form action="?action=import-transaksi-excel" method="POST" enctype="multipart/form-data">
                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-soft-success border border-success rounded-lg hover-bg-success transition text-sm font-medium">
                    <i class="fa-solid fa-file-import"></i> Import Excel
                    <input type="file" name="file_excel" accept=".xls,.xlsx" class="hidden" onchange="this.form.submit()">
                </label>
            </form>

            <a href="?action=export-transaksi-excel" class="inline-flex items-center gap-2 px-4 py-2 bg-soft-primary border border-primary rounded-lg hover-bg-primary transition text-sm font-medium">
                <i class="fa-solid fa-file-export"></i> Export Excel
            </a>
        </div>
    </div>

    <?php if (empty($listTransaksi)): ?>

    <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 text-center mt-6 lg:ml-35">
        <div class="flex flex-col items-center gap-3">
            <i class="fa-solid fa-file-invoice-dollar text-4xl text-slate-500"></i>

            <h3 class="text-lg font-semibold text-slate-300">
                Data Transaksi Kosong
            </h3>
            <p class="text-sm text-slate-400 max-w-md">
                Belum ada data transaksi yang tercatat.  
                Silakan lakukan 

                <form action="?action=import-transaksi-excel" method="POST" enctype="multipart/form-data" class="inline">
                    <label class="text-emerald-400 font-medium cursor-pointer hover:underline">
                        import Excel
                        <input 
                            type="file" 
                            name="file_excel" 
                            accept=".xls,.xlsx" 
                            class="hidden" 
                            onchange="this.form.submit()">
                    </label>
                </form>

                atau buat transaksi baru.
            </p>
        </div>
    </div>

    <?php else: ?>

<div class="space-y-4">
    <?php foreach($listTransaksi as $trx): ?>
        <?php
        $status = $trx['status'] ?? '-';
        $statusClass = match ($status) {
            'pending' => 'bg-soft-warning',
            'paid'    => 'bg-soft-success',
            default   => 'bg-soft-muted'
        };

        $metode = $trx['metode'] ?? '-';
        $map = [
            'cash' => [
                'class' => 'bg-soft-success',
                'icon' => '<i class="fa-solid fa-money-bill-wave mr-1"></i>'
            ],
            'digital' => [
                'class' => 'bg-soft-primary',
                'icon' => '<i class="fa-solid fa-mobile-screen-button mr-1"></i>'
            ]
        ];
        $colorClass = $map[$metode]['class'] ?? 'bg-soft-muted';
        $icon = $map[$metode]['icon'] ?? '';
        $metodeDisplay = ucfirst($metode);
        ?>

        <div class="bg-surface border border-border rounded-xl p-4 shadow-sm sm:hidden text-xs text-text">
                <div class="grid grid-cols-2 gap-2">
                    <div class="font-medium text-muted">ID Transaksi:</div>
                    <div class="text-right font-semibold text-text">
                        <?= $trx['id_transaksi'] ?>
                    </div>

                    <div class="font-medium text-muted">ID Tiket:</div>
                    <div class="text-right">
                        <?= $trx['id_tiket'] ?>
                    </div>

                    <div class="font-medium text-muted">Metode:</div>
                    <div class="text-right">
                        <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $colorClass ?>">
                            <?= $icon . $metodeDisplay ?>
                        </span>
                    </div>

                    <div class="font-medium text-muted">No Polisi:</div>
                    <div class="text-right">
                        <?= $trx['nomor_polisi'] ?>
                    </div>

                    <div class="font-medium text-muted">Total Bayar:</div>
                    <div class="text-right font-semibold">
                        Rp <?= number_format($trx['jumlah_bayar'] ?? 0, 0, ',', '.') ?>
                    </div>

                    <div class="font-medium text-muted">Tanggal Bayar:</div>
                    <div class="text-right">
                        <?= $trx['tgl_bayar'] ?? '-' ?>
                    </div>

                    <div class="font-medium text-muted">Status:</div>
                    <div class="text-right">
                        <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $statusClass ?>">
                            <?= ucfirst($status) ?>
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
                    <th class="px-3 py-2 text-left">ID Transaksi</th>
                    <th class="px-3 py-2 text-left">ID Tiket</th>
                    <th class="px-3 py-2 text-left">Metode Pembayaran</th>
                    <th class="px-3 py-2 text-left">No Polisi</th>
                    <th class="px-3 py-2 text-right">Total Bayar</th>
                    <th class="px-3 py-2 text-left">Tanggal Bayar</th>
                    <th class="px-3 py-2 text-center">Status</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-neutral-600 text-text">
                <?php foreach($listTransaksi as $trx): ?>
                    <?php
                    $status = $trx['status'] ?? '-';
                    $statusClass = match ($status) {
                        'pending' => 'bg-soft-warning',
                        'paid'    => 'bg-soft-success',
                        default   => 'bg-soft-muted'
                    };

                    $metode = $trx['metode'] ?? '-';
                    $map = [
                        'cash' => [
                            'class' => 'bg-soft-success',
                            'icon' => '<i class="fa-solid fa-money-bill-wave mr-1"></i>'
                        ],
                        'digital' => [
                            'class' => 'bg-soft-primary',
                            'icon' => '<i class="fa-solid fa-mobile-screen-button mr-1"></i>'
                        ]
                    ];
                    $colorClass = $map[$metode]['class'] ?? 'bg-soft-muted';
                    $icon = $map[$metode]['icon'] ?? '';
                    $metodeDisplay = ucfirst($metode);
                    ?>
                    <tr class="hover-bg-primary transition">
                        <td class="px-2 py-2 align-middle">
                            <?= $trx['id_transaksi'] ?>
                        </td>
                        <td class="px-2 py-2 align-middle">
                            <?= $trx['id_tiket'] ?>
                        </td>
                        <td class="px-2 py-2 align-middle">
                            <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $colorClass ?>">
                                <?= $icon . $metodeDisplay ?>
                            </span>
                        </td>
                        <td class="px-2 py-2 align-middle">
                            <?= $trx['nomor_polisi'] ?>
                        </td>
                        <td class="px-3 py-2 text-right font-semibold text-[11px]">
                            Rp <?= number_format($trx['jumlah_bayar'] ?? 0, 0, ',', '.') ?>
                        </td>
                        <td class="px-2 py-2 align-middle">
                            <?= $trx['tgl_bayar'] ?? '-' ?>
                        </td>
                        <td class="px-2 py-2 align-middle text-center">
                            <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $statusClass ?>">
                                <?= ucfirst($status) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="flex flex-wrap justify-center gap-2 mt-4">
        <?php
        $maxButtons = 5;
        $start = max(1, $pageTrx - intdiv($maxButtons, 2));
        $end = min($totalPagesTrx, $start + $maxButtons - 1);
        $start = max(1, $end - $maxButtons + 1);
        ?>

        <?php if ($pageTrx > 1): ?>
            <button onclick="loadTable('transaksi', null, <?= $pageTrx - 1 ?>)"
                class="px-3 py-1 rounded
                    bg-surface text-muted
                    hover-bg-primary hover-text-primary
                    transition">
                Prev
            </button>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <button onclick="loadTable('transaksi', null, <?= $i ?>)"
                class="px-3 py-1 rounded
                <?= $i == $pageTrx 
                    ? 'bg-primary text-bg font-semibold'
                    : 'bg-surface text-muted hover-bg-primary hover-text-primary' ?>">
                <?= $i ?>
            </button>
        <?php endfor; ?>

        <?php if ($pageTrx < $totalPagesTrx): ?>
            <button onclick="loadTable('transaksi', null, <?= $pageTrx + 1 ?>)"
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