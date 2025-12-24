<?php
    use Picqer\Barcode\BarcodeGeneratorPNG;
    $sessionUser = $_SESSION['user'] ?? null;
    $role = $sessionUser['role'] ?? null;

    $statCards = [];

    if ($role === 'admin') {
        $statCards[] = [
            'icon'  => 'fa-users',
            'color' => 'blue',
            'label' => 'Total User',
            'value' => $TotalUser
        ];
    }

    foreach ($totalbayar as $t) {
        $statCards[] = [
            'icon'  => 'fa-money-bill-wave',
            'color' => 'green',
            'label' => 'Total Transaksi Selesai',
            'value' => 'Rp ' . number_format($t, 0, ',', '.')
        ];
    }

    $statCards[] = [
        'icon'  => 'fa-right-to-bracket',
        'color' => 'amber',
        'label' => 'Total Kendaraan Masuk',
        'value' => $Totalmasuk
    ];

    $statCards[] = [
        'icon'  => 'fa-right-from-bracket',
        'color' => 'red',
        'label' => 'Total Kendaraan Keluar',
        'value' => $Totalkeluar
    ];

    $statCards[] = [
        'icon'  => 'fa-receipt',
        'color' => 'purple',
        'label' => 'Jumlah Transaksi',
        'value' => $Totaltransaksi
    ];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Parkir Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-900 text-white min-h-screen antialiased">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-20">
        <h2 class="col-span-4 text-3xl font-semibold text-cyan-400 mb-4">
            Dashboard <span class="text-neutral-400">Control Panel</span>
        </h2>

        <?php foreach ($statCards as $card): ?>
            <?php
                $icon  = $card['icon'];
                $color = $card['color'];
                $label = $card['label'];
                $value = $card['value'];

                include __DIR__ . '/../components/stat-card.php';
            ?>
        <?php endforeach; ?>
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
    <?php if ($pageUser > 1): ?>
        <a href="?page_user=<?= $pageUser - 1 ?>" 
        class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Prev</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPagesUser; $i++): ?>
        <a href="?page_user=<?= $i ?>"
        class="px-3 py-1 rounded 
        <?= ($i == $pageUser) ? 'bg-cyan-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($pageUser < $totalPagesUser): ?>
        <a href="?page_user=<?= $pageUser + 1 ?>" 
        class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Next</a>
    <?php endif; ?>
</div>
<?php endif; ?>
</body>
</html>