<?php
include __DIR__ . "/global-modal.php";
$sessionUser = $_SESSION['user'] ?? null;
$role = $sessionUser['role'] ?? null;
use Picqer\Barcode\BarcodeGeneratorPNG;
?>

<?php if(!$sessionUser): ?>

    <!-- TAMPILAN JIKA BELUM LOGIN -->
<section class="pt-24 pb-16 text-center">
    <h1 class="text-4xl md:text-5xl font-bold text-cyan-400 mb-6">
        Sistem Parkir Otomatis
    </h1>
    <p class="max-w-2xl mx-auto text-slate-300 text-lg leading-relaxed">
        Kelola parkir lebih cepat, aman, dan terorganisir.  
        Mulai dari pencetakan tiket otomatis, manajemen transaksi, hingga laporan real-time.
        Semua dalam satu dashboard modern.
    </p>

    <a href="?action=login"
       class="mt-8 inline-block px-8 py-4 bg-cyan-500 hover:bg-cyan-600 text-slate-900 font-bold rounded-xl shadow-lg transition">
        <i class="fa-solid fa-right-to-bracket mr-2"></i> Login untuk Melanjutkan
    </a>
</section>


<!-- FITUR UTAMA -->
<section class="py-20 bg-slate-800/40">
    <h2 class="text-3xl font-bold text-center mb-12 text-cyan-400">Fitur Utama</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto px-6">

        <!-- Box 1 -->
        <div class="p-8 bg-slate-800 rounded-2xl border border-slate-700 shadow-md hover:shadow-cyan-500/20 transition">
            <i class="fa-solid fa-ticket text-4xl text-cyan-400 mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Tiket Masuk Otomatis</h3>
            <p class="text-slate-300 text-sm">
                Cetak tiket sekali klik dan tampilkan barcode langsung siap untuk dipindai.
            </p>
        </div>

        <!-- Box 2 -->
        <div class="p-8 bg-slate-800 rounded-2xl border border-slate-700 shadow-md hover:shadow-cyan-500/20 transition">
            <i class="fa-solid fa-car text-4xl text-cyan-400 mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Manajemen Kendaraan</h3>
            <p class="text-slate-300 text-sm">
                Pantau kendaraan masuk, keluar, dan status tiket secara real-time.
            </p>
        </div>

        <!-- Box 3 -->
        <div class="p-8 bg-slate-800 rounded-2xl border border-slate-700 shadow-md hover:shadow-cyan-500/20 transition">
            <i class="fa-solid fa-money-bill-wave text-4xl text-cyan-400 mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Hitung Tarif Otomatis</h3>
            <p class="text-slate-300 text-sm">
                Sistem menghitung total biaya berdasarkan durasi parkir dan jenis kendaraan.
            </p>
        </div>

    </div>
</section>


<!-- KELEBIHAN -->
<section class="py-20">
    <h2 class="text-3xl font-bold text-center mb-12 text-cyan-400">Kenapa Menggunakan Sistem Ini?</h2>

    <div class="max-w-4xl mx-auto space-y-6 px-6">

        <div class="flex items-start gap-4">
            <i class="fa-solid fa-bolt text-cyan-400 text-2xl"></i>
            <p class="text-slate-300">Akses cepat dan responsif, dirancang untuk kebutuhan petugas lapangan.</p>
        </div>

        <div class="flex items-start gap-4">
            <i class="fa-solid fa-shield text-cyan-400 text-2xl"></i>
            <p class="text-slate-300">Keamanan data terjamin dengan autentikasi login.</p>
        </div>

        <div class="flex items-start gap-4">
            <i class="fa-solid fa-chart-line text-cyan-400 text-2xl"></i>
            <p class="text-slate-300">Laporan transaksi lebih rapi dan mudah dipahami.</p>
        </div>

        <div class="flex items-start gap-4">
            <i class="fa-solid fa-mobile-screen-button text-cyan-400 text-2xl"></i>
            <p class="text-slate-300">Tampilan modern dan mobile-friendly.</p>
        </div>

    </div>
</section>


<!-- FOOTER -->
<footer class="py-6 border-t border-slate-800 text-center text-slate-500 text-sm">
    &copy; <?= date('Y') ?> Sistem Parkir | Dibuat untuk kemudahan operasional
</footer>


<?php else: ?>
        <div class="mb-4">
        <?php
        if(isset($_SESSION['flash'])){
            alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
            unset($_SESSION['flash']); // Hapus flash biar cuma muncul sekali
        }
        ?>
    </div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-20">

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



    <?php endif; ?>
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

                            <!-- Kolom Barcode -->
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

                                    <!-- angka di bawah barcode (copyable) -->
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
                            ID User
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            Nama Lengkap
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            Email
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            Gender
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            Role
                        </th>

                        <th class="px-4 py-2 text-left text-sm font-medium text-slate-300">
                            Dibuat Pada
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