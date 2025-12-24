<div class="mt-10">
    <h2 class="text-2xl font-semibold text-cyan-400 mb-4">Daftar <span class="text-neutral-400">Tiket</span></h2>
    <div class="overflow-x-auto bg-slate-800 rounded-xl border border-slate-700">
        <table class="min-w-full divide-y divide-slate-700">
            <thead class="bg-slate-900">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        ID Tiket
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        Barcode
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        No Polisi
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        Jenis Kendaraan
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        Tgl Masuk
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        Tgl Keluar
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        Total Harga
                    </th>

                    <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                        Status
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700">
                <?php foreach($listTiket as $tiket): ?>
                    <tr class="hover:bg-slate-700 transition">

                        <td class="px-4 py-2 text-slate-300"><?= $tiket['id_tiket'] ?></td>

                        <td class="px-4 py-2 text-slate-300 text-center">
                            <?php
                            $barcodeValue = $tiket['barcode'];
                            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                            $barcodeImage = $generator->getBarcode($barcodeValue, $generator::TYPE_CODE_128);
                            ?>
                            
                            <div class="flex flex-col items-center">
                                <img 
                                    src="data:image/png;base64,<?= base64_encode($barcodeImage) ?>" 
                                    class="w-40 h-auto"
                                >

                                <span class="tracking-[0.25em] text-slate-300 text-xs mt-1">
                                    <?= htmlspecialchars($barcodeValue) ?>
                                </span>
                            </div>
                        </td>


                        <td class="px-4 py-2 text-slate-300"><?= $tiket['nomor_polisi'] ?></td>
                        <?php
                        $kendaraan = $tiket['jenis_kendaraan'] ?? '-';

                        $map = [
                            'motor' => [
                                'class' => 'bg-sky-500/20 text-sky-400',
                                'icon'  => '<i class="fa-solid fa-motorcycle mr-1"></i>'
                            ],
                            'mobil' => [
                                'class' => 'bg-amber-500/20 text-amber-400',
                                'icon'  => '<i class="fa-solid fa-car mr-1"></i>'
                            ],
                        ];

                        $colorClass = $map[$kendaraan]['class'] ?? 'bg-slate-500/20 text-slate-400';
                        $icon       = $map[$kendaraan]['icon']  ?? '';
                        ?>

                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-md text-sm font-medium <?= $colorClass ?>">
                                <?= $icon . $kendaraan ?>
                            </span>
                        </td>
                        <td class="px-4 py-2 text-slate-300">
                            <i class="fa-solid fa-sign-in-alt mr-1 text-emerald-400"></i>
                            <?= $tiket['tgl_masuk'] ? (new DateTime($tiket['tgl_masuk']))->format('d M Y • H:i') : '-' ?>
                        </td>

                        <td class="px-4 py-2 text-slate-300">
                            <?php if ($tiket['tgl_keluar']): ?>
                                <i class="fa-solid fa-sign-out-alt mr-1 text-red-400"></i>
                                <?= (new DateTime($tiket['tgl_keluar']))->format('d M Y • H:i') ?>
                            <?php else: ?>
                                <i class="fa-solid fa-clock text-yellow-400"></i>
                                - Belum keluar
                            <?php endif; ?>
                        </td>

                        <td class="px-4 py-2 text-slate-300">
                        Rp <?= number_format($tiket['total_harga'] ?? 0, 0, ',', '.') ?>
                        </td>


                        <?php
                        $status = $tiket['status'] ?? '-';

                        $colorClass = match ($status) {
                            'masuk' => 'bg-emerald-500/20 text-emerald-400',
                            'keluar' => 'bg-red-500/20 text-red-400',
                            default => 'bg-slate-500/20 text-slate-400',
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
    <?php if ($pageTiket > 1): ?>
        <a href="?page_tiket=<?= $pageTiket - 1 ?>" 
        class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Prev</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPagesTiket; $i++): ?>
        <a href="?page_tiket=<?= $i ?>"
        class="px-3 py-1 rounded 
        <?= ($i == $pageTiket) ? 'bg-cyan-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($pageTiket < $totalPagesTiket): ?>
        <a href="?page_tiket=<?= $pageTiket + 1 ?>" 
        class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Next</a>
    <?php endif; ?>
</div>