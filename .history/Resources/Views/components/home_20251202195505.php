<?php
$sessionUser = $_SESSION['user'] ?? null;
$role = $sessionUser['role'] ?? null;
use Picqer\Barcode\BarcodeGeneratorPNG;
?>

<?php if(!$sessionUser): ?>

    <!-- TAMPILAN JIKA BELUM LOGIN -->
    <div class="text-center py-20">
        <i class="fa-solid fa-lock text-cyan-400 text-7xl mb-6"></i>
        <h2 class="text-3xl font-bold text-cyan-400 mb-4">Akses Terbatas</h2>
        <p class="text-slate-300 max-w-lg mx-auto mb-6">
            Anda belum login. Silakan login terlebih dahulu untuk membuka akses penuh ke dashboard, 
            melihat daftar tiket, transaksi, dan fitur lainnya.
        </p>
        <a href="?action=login"
           class="px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-slate-900 font-bold rounded-lg transition">
            <i class="fa-solid fa-right-to-bracket mr-2"></i> Login Sekarang
        </a>
    </div>

<?php else: ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <h2 class="col-span-4 text-3xl font-semibold text-cyan-400 mb-4">
        Dashboard <span class="text-neutral-400">Control Panel</span>
    </h2>

    <?php if($role === 'admin'): ?>

        <!-- TOTAL USER -->
        <div class="relative bg-slate-800 border border-slate-700 p-6 rounded-xl shadow-lg overflow-hidden
                    transition-all duration-300 hover:-translate-y-2 hover:shadow-blue-500/20">

            <i class="fa-solid fa-users text-blue-400 text-4xl"></i>
            <div>
                <p class="text-slate-400 text-sm">Total User</p>
                <h3 class="text-2xl font-bold"><?= $TotalUser ?></h3>
            </div>

            <i class="fa-solid fa-users absolute right-4 top-2 text-7xl text-blue-400/10"></i>
        </div>

        <?php foreach($totalbayar as $t): ?>
        <!-- TOTAL UANG -->
        <div class="relative bg-slate-800 border border-slate-700 p-6 rounded-xl shadow-lg overflow-hidden
                    transition-all duration-300 hover:-translate-y-2 hover:shadow-green-500/20">

            <i class="fa-solid fa-money-bill-wave text-green-400 text-4xl"></i>
            <div>
                <p class="text-slate-400 text-sm">Total Transaksi Selesai</p>
                <h3 class="text-2xl font-bold">Rp <?= number_format($t, 0, ',', '.') ?></h3>
            </div>

            <i class="fa-solid fa-money-bill-wave absolute right-4 top-2 text-7xl text-green-400/10"></i>
        </div>
        <?php endforeach; ?>

    <?php endif; ?>


    <!-- TOTAL MASUK -->
    <div class="relative bg-slate-800 border border-slate-700 p-6 rounded-xl shadow-lg overflow-hidden
                transition-all duration-300 hover:-translate-y-2 hover:shadow-amber-500/20">

        <i class="fa-solid fa-right-to-bracket text-amber-400 text-4xl"></i>
        <div>
            <p class="text-slate-400 text-sm">Total Kendaraan Masuk</p>
            <h3 class="text-2xl font-bold"><?= $Totalmasuk ?></h3>
        </div>

        <i class="fa-solid fa-right-to-bracket absolute right-4 top-2 text-7xl text-amber-400/10"></i>
    </div>

    <!-- TOTAL KELUAR -->
    <div class="relative bg-slate-800 border border-slate-700 p-6 rounded-xl shadow-lg overflow-hidden
                transition-all duration-300 hover:-translate-y-2 hover:shadow-red-500/20">

        <i class="fa-solid fa-right-from-bracket text-red-400 text-4xl"></i>
        <div>
            <p class="text-slate-400 text-sm">Total Kendaraan Keluar</p>
            <h3 class="text-2xl font-bold"><?= $Totalkeluar ?></h3>
        </div>

        <i class="fa-solid fa-right-from-bracket absolute right-4 top-2 text-7xl text-red-400/10"></i>
    </div>

    <!-- JUMLAH TRANSAKSI -->
    <div class="relative bg-slate-800 border border-slate-700 p-6 rounded-xl shadow-lg overflow-hidden
                transition-all duration-300 hover:-translate-y-2 hover:shadow-purple-500/20">

        <i class="fa-solid fa-receipt text-purple-400 text-4xl"></i>
        <div>
            <p class="text-slate-400 text-sm">Jumlah Transaksi</p>
            <h3 class="text-2xl font-bold"><?= $Totaltransaksi ?></h3>
        </div>

        <i class="fa-solid fa-receipt absolute right-4 top-2 text-7xl text-purple-400/10"></i>
    </div>

</div>


    <!-- =================== TABLE TIKET =================== -->
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
                            <i class="fa-solid fa-money-bill-wave mr-1"></i> Total Harga
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-check-circle mr-1"></i> Status
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    <?php foreach($listTiket as $tiket): ?>
                        <tr class="hover:bg-slate-700 transition">

                            <td class="px-4 py-2 text-slate-300"><?= $tiket['id_tiket'] ?></td>

                            <!-- Kolom Barcode -->
                            <td class="px-4 py-2 text-slate-300">
                                <?php
                                $barcodeValue = $tiket['barcode'];

                                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                $barcodeImage = $generator->getBarcode($barcodeValue, $generator::TYPE_CODE_128
);
                                ?>
                                <img 
                                    src="data:image/png;base64,<?= base64_encode($barcodeImage) ?>" 
                                    alt="barcode"
                                    class="h-auto w-40"
                                >
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
                                <i class="fa-solid fa-sign-in-alt mr-1"></i>
                                <?= $tiket['tgl_masuk'] ? (new DateTime($tiket['tgl_masuk']))->format('d M Y • H:i') : '-' ?>
                            </td>

                            <td class="px-4 py-2 text-slate-300">
                                <?php if ($tiket['tgl_keluar']): ?>
                                    <i class="fa-solid fa-sign-out-alt mr-1"></i>
                                    <?= (new DateTime($tiket['tgl_keluar']))->format('d M Y • H:i') ?>
                                <?php else: ?>
                                    <i class="fa-solid fa-clock text-yellow-400"></i>
                                    - Belum keluar
                                <?php endif; ?>
                            </td>

                            <td class="px-4 py-2 text-slate-300">Rp <?= number_format($tiket['total_harga'], 0, ',', '.') ?></td>

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
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" 
            class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>"
            class="px-3 py-1 rounded 
            <?= ($i == $page) ? 'bg-cyan-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>" 
            class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Next</a>
        <?php endif; ?>
    </div>

    <!-- =================== TABLE TRANSAKSI =================== -->
    <div class="mt-10">
        <h2 class="text-2xl font-semibold text-cyan-400 mb-4">Daftar <span class="text-neutral-400">Transaksi</span></h2>
        <div class="overflow-x-auto bg-slate-800 rounded-xl border border-slate-700">
            <table class="min-w-full divide-y divide-slate-700">
                <thead class="bg-slate-900">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-receipt mr-1"></i> ID Transaksi
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-ticket mr-1"></i> ID Tiket
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-credit-card mr-1"></i> Metode Pembayaran
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-car-side mr-1"></i> No Polisi
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-money-bill-wave mr-1"></i> Total Bayar
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-calendar-check mr-1"></i> Tanggal Bayar
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-circle-info mr-1"></i> Status
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
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" 
            class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>"
            class="px-3 py-1 rounded 
            <?= ($i == $page) ? 'bg-cyan-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>" 
            class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Next</a>
        <?php endif; ?>
    </div>

<?php if($role === 'admin'): ?>
    <!-- =================== TABLE USER =================== -->
    <div class="mt-10">
        <h2 class="text-2xl font-semibold text-cyan-400 mb-4">Daftar <span class="text-neutral-400">User</span></h2>
        <div class="overflow-x-auto bg-slate-800 rounded-xl border border-slate-700">
            <table class="min-w-full divide-y divide-slate-700">
                <thead class="bg-slate-900">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-hashtag mr-1 text-cyan-400"></i> 
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-id-card mr-1 text-cyan-400"></i> ID User
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-user mr-1 text-cyan-400"></i> Nama Lengkap
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-envelope mr-1 text-cyan-400"></i> Email
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-venus-mars mr-1 text-cyan-400"></i> Gender
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-user-gear mr-1 text-cyan-400"></i> Role
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            <i class="fa-solid fa-calendar-days mr-1 text-cyan-400"></i> Dibuat Pada
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    <?php foreach($listUser as $user): ?>
                        <tr class="hover:bg-slate-700 transition">
                            <td class="px-4 py-2 text-slate-300"><?= $p++ ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $user['id_user'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $user['nama_lengkap'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $user['email'] ?></td>
                            <?php
                            $gender = $user['gender'] ?? '-';

                            if ($gender === 'L') {
                                $colorClass = 'bg-blue-500/20 text-blue-400';
                                $icon = '<i class="fa-solid fa-mars"></i>';        // laki-laki
                                $label = 'Laki-laki';
                            } elseif ($gender === 'P') {
                                $colorClass = 'bg-pink-500/20 text-pink-400';
                                $icon = '<i class="fa-solid fa-venus"></i>';       // perempuan
                                $label = 'Perempuan';
                            } else {
                                $colorClass = 'bg-slate-500/20 text-slate-400';
                                $icon = '<i class="fa-solid fa-circle-question"></i>';
                                $label = '-';
                            }
                            ?>

                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-md text-sm font-medium flex items-center gap-1 <?= $colorClass ?>">
                                    <?= $icon ?> <?= $label ?>
                                </span>
                            </td>

                            <?php
                            $role = $user['role'] ?? '-';
                            $roleDisplay = ucfirst($role); // Huruf depan jadi besar

                            $roleMap = [
                                'admin' => [
                                    'class' => 'bg-purple-500/20 text-purple-400',
                                    'icon'  => '<i class="fa-solid fa-user-shield mr-1"></i>'
                                ],
                                'petugas' => [
                                    'class' => 'bg-cyan-500/20 text-cyan-400',
                                    'icon'  => '<i class="fa-solid fa-id-badge mr-1"></i>'
                                ],
                            ];

                            $colorClass = $roleMap[$role]['class'] ?? 'bg-slate-500/20 text-slate-400';
                            $icon       = $roleMap[$role]['icon']  ?? '';
                            ?>

                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-md text-sm font-medium <?= $colorClass ?>">
                                    <?= $icon . $roleDisplay ?>
                                </span>
                            </td>
                            <td class="px-4 py-2 text-slate-300"><?= $user['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center gap-2 mt-4">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" 
            class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>"
            class="px-3 py-1 rounded 
            <?= ($i == $page) ? 'bg-cyan-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>" 
            class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Next</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php endif; ?>