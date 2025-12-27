<?php
    use Picqer\Barcode\BarcodeGeneratorPNG;
    $sessionUser = $_SESSION['user'] ?? null;
    $role = $sessionUser['role'] ?? null;

$statCards = [];

if ($role === 'admin') {
    $statCards[] = [
        'icon' => 'fa-users',
        'color' => [
            'text'   => 'text-blue-400',
            'muted'  => 'text-blue-400/10',
            'shadow' => 'hover:shadow-blue-500/20'
        ],
        'label' => 'Total User',
        'value' => $TotalUser
    ];
}

foreach ($totalbayar as $t) {
    $statCards[] = [
        'icon' => 'fa-money-bill-wave',
        'color' => [
            'text'   => 'text-green-400',
            'muted'  => 'text-green-400/10',
            'shadow' => 'hover:shadow-green-500/20'
        ],
        'label' => 'Total Transaksi Selesai',
        'value' => 'Rp ' . number_format($t, 0, ',', '.')
    ];
}

$statCards[] = [
    'icon' => 'fa-right-to-bracket',
    'color' => [
        'text'   => 'text-amber-400',
        'muted'  => 'text-amber-400/10',
        'shadow' => 'hover:shadow-amber-500/20'
    ],
    'label' => 'Total Kendaraan Masuk',
    'value' => $Totalmasuk
];

$statCards[] = [
    'icon' => 'fa-right-from-bracket',
    'color' => [
        'text'   => 'text-red-400',
        'muted'  => 'text-red-400/10',
        'shadow' => 'hover:shadow-red-500/20'
    ],
    'label' => 'Total Kendaraan Keluar',
    'value' => $Totalkeluar
];

$statCards[] = [
    'icon' => 'fa-receipt',
    'color' => [
        'text'   => 'text-purple-400',
        'muted'  => 'text-purple-400/10',
        'shadow' => 'hover:shadow-purple-500/20'
    ],
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
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
.tab-active {
    box-shadow: inset 0 -3px 0 currentColor;
    background-opacity: 0.25;
}
</style>

</head>
<body class="bg-gray-900 text-white min-h-screen antialiased">

<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-20">
    <h2 class="col-span-2 sm:col-span-2 lg:col-span-4 text-3xl font-semibold text-cyan-400 mb-4">
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

    <div class="grid 
        <?= $role === 'admin' ? 'grid-cols-3' : 'grid-cols-2' ?>
        mt-8 overflow-hidden rounded-xl border border-gray-700">

        <button onclick="loadTable('tiket')" 
            class="tab-btn py-3 font-medium 
            bg-cyan-500/10 text-cyan-400
            hover:bg-cyan-500/20 transition">
            Tiket
        </button>

        <button onclick="loadTable('transaksi')" 
            class="tab-btn py-3 font-medium 
            bg-green-500/10 text-green-400
            hover:bg-green-500/20 transition">
            Transaksi
        </button>

        <?php if ($role === 'admin'): ?>
        <button onclick="loadTable('user')" 
            class="tab-btn py-3 font-medium 
            bg-blue-500/10 text-blue-400
            hover:bg-blue-500/20 transition">
            User
        </button>
        <?php endif; ?>
    </div>

    <div id="table-container" class="mt-4">
        <!-- table ajax -->
    </div>


<script>
function loadTable(type, el) {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('tab-active');
    });

    if (el) el.classList.add('tab-active');

    const container = document.getElementById('table-container');
    container.innerHTML = `
        <div class="text-center py-12 text-gray-400">
            <i class="fa fa-spinner fa-spin mr-2"></i> Memuat data...
        </div>
    `;

    fetch(`ajax/load-dashboard-table.php?type=${type}`)
        .then(res => res.text())
        .then(html => container.innerHTML = html)
        .catch(() => {
            container.innerHTML = `
                <div class="text-red-400 text-center py-10">
                    Gagal memuat data
                </div>
            `;
        });
}

document.addEventListener('DOMContentLoaded', () => {
    loadTable('tiket');
});
</script>


</body>
</html>