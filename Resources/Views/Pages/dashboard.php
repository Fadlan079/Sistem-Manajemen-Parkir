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
        'text'   => 'text-emerald-400',
        'muted'  => 'text-emerald-400/10',
        'shadow' => 'hover:shadow-emerald-500/20'
    ],
    'label' => 'Total Kendaraan Masuk',
    'value' => $Totalmasuk
];


$statCards[] = [
    'icon' => 'fa-right-from-bracket',
    'color' => [
        'text'   => 'text-rose-400',
        'muted'  => 'text-rose-400/10',
        'shadow' => 'hover:shadow-rose-500/20'
    ],
    'label' => 'Total Kendaraan Keluar',
    'value' => $Totalkeluar
];

$statCards[] = [
    'icon' => 'fa-square-parking',
    'color' => [
        'text'   => 'text-amber-400',
        'muted'  => 'text-amber-400/10',
        'shadow' => 'hover:shadow-amber-500/20'
    ],
    'label' => 'Kendaraan Sedang Parkir',
    'value' => $total_parkir
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
    background-color: rgba(255,255,255,0.06);
}

    </style>

</head>
<body class="bg-gray-900 text-white min-h-screen antialiased">

<div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-20 ">
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

<button id="tab-tiket"
    onclick="loadTable('tiket', this)" 
    class="tab-btn py-3 font-medium 
    bg-cyan-500/10 text-cyan-400
    hover:bg-cyan-500/20 transition">
    Tiket
</button>



<button onclick="loadTable('transaksi', this)" 
    class="tab-btn py-3 font-medium 
    bg-green-500/10 text-green-400
    hover:bg-green-500/20 transition">
    Transaksi
</button>


        <?php if ($role === 'admin'): ?>
<button onclick="loadTable('user', this)" 
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let activeTabType = 'tiket';
let activeTabEl = null;

let chartPendapatan;
let chartTrxHarian;
let chartStatusTrx;
let chartNominal;

function loadTable(type, el = null, page = 1) {

    if (el) {
        activeTabEl = el;
        activeTabType = type;
    }

    // reset tab
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('tab-active');
    });
    if (activeTabEl) activeTabEl.classList.add('tab-active');

    const container = document.getElementById('table-container');
    container.innerHTML = `
        <div class="text-center py-12 text-gray-400">
            <i class="fa fa-spinner fa-spin mr-2"></i> Memuat data...
        </div>
    `;

    let pageParam = '';
    if (type === 'tiket') pageParam = `&page_tiket=${page}`;
    if (type === 'transaksi') pageParam = `&page_trx=${page}`;
    if (type === 'user') pageParam = `&page_user=${page}`;

    fetch(`ajax/load-dashboard-table.php?type=${type}${pageParam}`)
        .then(res => res.json())

.then(data => {
    container.innerHTML = data.html;

    if (type === 'tiket') {
        renderChartTiket(data.statusCount, data.kendaraanCount);
    }

    if (type === 'transaksi') {
        setTimeout(() => {
            renderChartTransaksi(data);
        }, 50);
    }

if (type === 'user') {
    renderChartUser({
        roleCount: data.roleCount,
        genderCount: data.genderCount,
        verifCount: data.verifCount,
        userHarian: data.userHarian
    });
}

})

        .catch(err => {
            console.error('Load table error:', err);
            container.innerHTML = "<div class='text-red-400 text-center py-10'>Gagal memuat data</div>";
        });

    }

// load default tab
document.addEventListener('DOMContentLoaded', () => {
    const defaultTab = document.getElementById('tab-tiket');
    loadTable('tiket', defaultTab);
});

function renderChartTiket(statusData, kendaraanData) { 
    // Hapus chart sebelumnya kalau ada
    if (window.chartStatus) window.chartStatus.destroy();
    if (window.chartKendaraan) window.chartKendaraan.destroy();

    // Chart status tiket
    const ctxStatus = document.getElementById('chartStatusTiket').getContext('2d');
    window.chartStatus = new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Masuk', 'Keluar', 'Sedang Parkir'],
            datasets: [{
                label: 'Jumlah Tiket',
                data: [statusData.masuk, statusData.keluar, statusData.parkir],
                backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
                borderWidth: 1
            }]
        },
    });


    // Chart jenis kendaraan
    const ctxKendaraan = document.getElementById('chartJenisKendaraan').getContext('2d');
    window.chartKendaraan = new Chart(ctxKendaraan, {
        type: 'bar',
        data: {
            labels: ['Motor', 'Mobil'],
            datasets: [{
                label: 'Jumlah Kendaraan',
                data: [kendaraanData.motor, kendaraanData.mobil],
                backgroundColor: ['#0ea5e9', '#f59e0b'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

    
}

function renderChartTransaksi(res) {

    // destroy chart lama
    chartPendapatan?.destroy();
    chartTrxHarian?.destroy();
    chartStatusTrx?.destroy();
    chartNominal?.destroy();

    // ================= PENDAPATAN =================
chartPendapatan = new Chart(
    document.getElementById('chartPendapatan'),
    {
        type: 'line',
        data: {
            labels: res.pendapatan.labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: res.pendapatan.data,
                borderColor: '#22c55e',           // green
                backgroundColor: 'rgba(34,197,94,0.25)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#16a34a',
                pointRadius: 4
            }]
        }
    }
);


    // ================= TRANSAKSI HARIAN =================
chartTrxHarian = new Chart(
    document.getElementById('chartTrxHarian'),
    {
        type: 'bar',
        data: {
            labels: res.trxHarian.labels,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: res.trxHarian.data,
                backgroundColor: '#06b6d4', // cyan
                borderRadius: 8
            }]
        }
    }
);


    // ================= STATUS =================
chartStatusTrx = new Chart(
    document.getElementById('chartStatus'),
    {
        type: 'doughnut',
        data: {
            labels: Object.keys(res.statusCount),
            datasets: [{
                data: Object.values(res.statusCount),
                backgroundColor: [
                    '#22c55e', // sukses
                    '#facc15', // pending
                ],
                borderWidth: 1
            }]
        }
    }
);


chartNominal = new Chart(
    document.getElementById('chartNominal'),
    {
        type: 'bar',
        data: {
            labels: Object.keys(res.nominalCount),
            datasets: [{
                label: 'Jumlah Transaksi',
                data: Object.values(res.nominalCount),
                backgroundColor: [
                    '#a855f7',
                    '#ec4899',
                    '#6366f1',
                    '#14b8a6'
                ],
                borderRadius: 8
            }]
        }
    }
);

}

function renderChartUser(data) {

    // ROLE
    const ctxRole = document.getElementById('chartRole');
    if (!ctxRole) return;

    if (window.chartRole instanceof Chart) {
        window.chartRole.destroy();
    }

    window.chartRole = new Chart(ctxRole, {
        type: 'doughnut',
        data: {
            labels: Object.keys(data.roleCount),
            datasets: [{
                data: Object.values(data.roleCount),
            }]
        }
    });

    // GENDER
    const ctxGender = document.getElementById('chartGender');
    if (window.chartGender instanceof Chart) {
        window.chartGender.destroy();
    }

    window.chartGender = new Chart(ctxGender, {
        type: 'pie',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: Object.values(data.genderCount),
            }]
        }
    });

    // VERIFIKASI
    const ctxVerif = document.getElementById('chartVerif');
    if (window.chartVerif instanceof Chart) {
        window.chartVerif.destroy();
    }

    window.chartVerif = new Chart(ctxVerif, {
        type: 'bar',
        data: {
            labels: Object.keys(data.verifCount),
            datasets: [{
                data: Object.values(data.verifCount),
            }]
        }
    });

    // USER HARIAN
    const ctxUserHarian = document.getElementById('chartUserHarian');
    if (window.chartUserHarian instanceof Chart) {
        window.chartUserHarian.destroy();
    }

    window.chartUserHarian = new Chart(ctxUserHarian, {
        type: 'line',
        data: {
            labels: data.userHarian.labels,
            datasets: [{
                label: 'User Baru',
                data: data.userHarian.data,
                tension: 0.3
            }]
        }
    });
}

</script>
</body>
</html>