<div class="mt-10">
    <h2 class="text-2xl font-semibold text-cyan-400 mb-4">Daftar <span class="text-neutral-400">Transaksi</span></h2>
    <div class="overflow-x-auto bg-slate-800 rounded-xl border border-slate-700">
        <table class="min-w-full divide-y divide-slate-700">
            <thead class="bg-slate-900">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        ID Transaksi
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        ID Tiket
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        Metode Pembayaran
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        No Polisi
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        Total Bayar
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        Tanggal Bayar
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                <?php foreach($listTransaksi as $trx): ?>
                    <tr class="hover:bg-slate-700 transition">
                        <td class="px-4 py-2 text-slate-300"><?= $trx['id_transaksi'] ?></td>
                        <td class="px-4 py-2 text-slate-300"><?= $trx['id_tiket'] ?></td>
                        <?php
                        $metode = $trx['metode'] ?? '-';
                        $metodeDisplay = ucfirst($metode);

                        $map = [
                            'cash' => [
                                'class' => 'bg-emerald-500/20 text-emerald-400',
                                'icon'  => '<i class="fa-solid fa-money-bill-wave mr-1"></i>'
                            ],
                            'digital' => [
                                'class' => 'bg-blue-500/20 text-blue-400',
                                'icon'  => '<i class="fa-solid fa-mobile-screen-button mr-1"></i>'
                            ],
                        ];

                        $colorClass = $map[$metode]['class'] ?? 'bg-slate-500/20 text-slate-400';
                        $icon       = $map[$metode]['icon']  ?? '';
                        ?>

                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-md text-sm font-medium <?= $colorClass ?>">
                                <?= $icon . $metodeDisplay ?>
                            </span>
                        </td>
                        <td class="px-4 py-2 text-slate-300"><?= $trx['nomor_polisi'] ?></td>
                        <td class="px-4 py-2 text-slate-300">Rp <?= number_format($trx['jumlah_bayar'], 0, ',', '.') ?? '-' ?></td>
                        <td class="px-4 py-2 text-slate-300"><?= $trx['tgl_bayar'] ?? '-' ?></td>
                        <?php
                        $status = $trx['status'] ?? '-';

                        $colorClass = match ($status) {
                            'pending' => 'bg-yellow-500/20 text-yellow-400',
                            'paid'    => 'bg-emerald-500/20 text-emerald-400',
                            default   => 'bg-slate-500/20 text-slate-400'
                        };
                        ?>

                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-md text-sm font-medium <?= $colorClass ?>">
                                <?= $status ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="flex justify-center gap-2 mt-4">
    <?php if ($pageTrx > 1): ?>
        <a href="?page_trx=<?= $pageTrx - 1 ?>" 
        class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Prev</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPagesTrx; $i++): ?>
        <a href="?page_trx=<?= $i ?>"
        class="px-3 py-1 rounded 
        <?= ($i == $pageTrx) ? 'bg-cyan-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($pageTrx < $totalPagesTrx): ?>
        <a href="?page_trx=<?= $pageTrx + 1 ?>" 
        class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Next</a>
    <?php endif; ?>
</div>