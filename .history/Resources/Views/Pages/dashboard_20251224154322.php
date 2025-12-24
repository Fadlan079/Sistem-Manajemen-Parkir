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
<?php if($role === 'admin'): 
    
    ?>
    
<?php endif; ?>
</body>
</html>