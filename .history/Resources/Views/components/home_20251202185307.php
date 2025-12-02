<?php
$sessionUser = $_SESSION['user'] ?? null;
$role = $sessionUser['role'] ?? null;
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
            <div
                class="bg-slate-800 border border-slate-700 p-6 rounded-xl shadow-lg
                       flex items-center gap-4
                       transition-all duration-300 hover:-translate-y-2 hover:shadow-cyan-500/20">
                <i class="fa-solid fa-users text-cyan-400 text-4xl"></i>
                <div>
                    <p class="text-slate-400 text-sm">Total User</p>
                    <h3 class="text-2xl font-bold"><?= $TotalUser ?></h3>
                </div>
            </div>

            <?php foreach($totalbayar as $t):?>
                
            <div
                class="bg-slate-800 border border-slate-700 p-6 rounded-xl shadow-lg
                    flex items-center gap-4
                    transition-all duration-300 hover:-translate-y-2 hover:shadow-cyan-500/20">
                <i class="fa-solid fa-receipt text-cyan-400 text-4xl"></i>
                <div>
                    <p class="text-slate-400 text-sm">Total Transaksi Selesai</p>
                    <h3 class="text-2xl font-bold">Rp <?= number_format($t, 0, ',', '.')?></h3>
                </div>
            </div>
            <?php endforeach?>
        <?php endif; ?>

        <!-- TOTAL MASUK -->
        <div
            class="bg-slate-800 border border-slate-700 p-6 rounded-xl shadow-lg
                   flex items-center gap-4
                   transition-all duration-300 hover:-translate-y-2 hover:shadow-cyan-500/20">
            <i class="fa-solid fa-right-to-bracket text-cyan-400 text-4xl"></i>
            <div>
                <p class="text-slate-400 text-sm">Total Masuk</p>
                <h3 class="text-2xl font-bold"><?= $Totalmasuk ?></h3>
            </div>
        </div>

        <!-- TOTAL KELUAR -->
        <div
            class="bg-slate-800 border border-slate-700 p-6 rounded-xl shadow-lg
                   flex items-center gap-4
                   transition-all duration-300 hover:-translate-y-2 hover:shadow-cyan-500/20">
            <i class="fa-solid fa-right-from-bracket text-cyan-400 text-4xl"></i>
            <div>
                <p class="text-slate-400 text-sm">Total Keluar</p>
                <h3 class="text-2xl font-bold"><?= $Totalkeluar ?></h3>
            </div>
        </div>

        <!-- TOTAL TRANSAKSI -->
        <div
            class="bg-slate-800 border border-slate-700 p-6 rounded-xl shadow-lg
                   flex items-center gap-4
                   transition-all duration-300 hover:-translate-y-2 hover:shadow-cyan-500/20">
            <i class="fa-solid fa-receipt text-cyan-400 text-4xl"></i>
            <div>
                <p class="text-slate-400 text-sm">Jumlah Transaksi</p>
                <h3 class="text-2xl font-bold"><?= $Totaltransaksi ?></h3>
            </div>
        </div>
    </div>

    <!-- =================== TABLE TIKET =================== -->
    <div class="mt-10">
        <h2 class="text-2xl font-semibold text-cyan-400 mb-4">Daftar <span class="text-neutral-400">Tiket</span></h2>
        <div class="overflow-x-auto bg-slate-800 rounded-xl border border-slate-700">
            <table class="min-w-full divide-y divide-slate-700">
                <thead class="bg-slate-900">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">ID Tiket</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Barcode</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">No Polisi</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Jenis Kendaraan</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Tgl Masuk</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Tgl Keluar</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Total Harga</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    <?php foreach($listTiket as $tiket): ?>
                        <tr class="hover:bg-slate-700 transition">
                            <td class="px-4 py-2 text-slate-300"><?= $tiket['id_tiket'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $tiket['barcode'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $tiket['nomor_polisi'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $tiket['jenis_kendaraan'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $tiket['tgl_masuk'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $tiket['tgl_keluar'] ?? '-' ?></td>
                            <td class="px-4 py-2 text-slate-300">Rp <?= number_format($tiket['total_harga'], 0, ',', '.') ?></td>
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

    <!-- =================== TABLE TRANSAKSI =================== -->
    <div class="mt-10">
        <h2 class="text-2xl font-semibold text-cyan-400 mb-4">Daftar <span class="text-neutral-400">Transaksi</span></h2>
        <div class="overflow-x-auto bg-slate-800 rounded-xl border border-slate-700">
            <table class="min-w-full divide-y divide-slate-700">
                <thead class="bg-slate-900">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">ID Transaksi</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">ID Tiket</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Barcode</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">No Polisi</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Total Bayar</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Tanggal Bayar</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    <?php foreach($listTransaksi as $trx): ?>
                        <tr class="hover:bg-slate-700 transition">
                            <td class="px-4 py-2 text-slate-300"><?= $trx['id_transaksi'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $trx['id_tiket'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $trx['barcode'] ?></td>
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
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">#</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">ID User</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Nama Lengkap</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Gender</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Role</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">Dibuat Pada</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    <?php foreach($listUser as $user): ?>
                        <tr class="hover:bg-slate-700 transition">
                            <td class="px-4 py-2 text-slate-300"><?= $p++ ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $user['id_user'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $user['nama_lengkap'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $user['email'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $user['gender'] ?></td>
                            <td class="px-4 py-2 text-slate-300"><?= $user['role'] ?></td>
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