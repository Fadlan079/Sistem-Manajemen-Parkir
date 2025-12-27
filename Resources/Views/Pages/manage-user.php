<?php include __DIR__ . "/../components/global-modal.php"?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User</title>
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
          integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body class="bg-slate-900 min-h-screen p-6">
    <?php include __DIR__ . "/../components/header.php"?>

            <div class="mb-4">
                <?php
                    if(isset($_SESSION['flash'])){
                        alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
                        unset($_SESSION['flash']);
                    }
                ?>
            </div>

    <div class="max-w-7xl mx-auto space-y-4 mt-20">
<div class="mt-10">
    <!-- Header & Tombol Tambah -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 flex-wrap">
        <h2 class="text-xl sm:text-2xl font-semibold text-cyan-400">
            Daftar <span class="text-neutral-400">User</span>
        </h2>
                    
    <!-- Tombol Tambah User Desktop -->
    <div class="hidden sm:flex flex-wrap gap-2">
        <a href="?action=tambah-user" 
        class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600/20 text-cyan-400 border border-cyan-600/40 rounded-lg hover:bg-cyan-600/30 transition text-sm font-medium">
        <i class="fa-solid fa-user-plus"></i> Tambah User
        </a>
    </div>

    <!-- Tombol Tambah User Mobile (card) -->
    <a href="?action=tambah-user" 
    class="flex sm:hidden flex-col justify-center items-center bg-slate-800 border border-cyan-600/40 rounded-xl p-6 shadow-md hover:bg-slate-700 transition text-cyan-400">
        <i class="fa-solid fa-user-plus text-2xl mb-2"></i>
        <span class="font-medium text-sm">Tambah User</span>
    </a>


    </div>

    <!-- Card Style Mobile -->
    <div class="space-y-4 sm:hidden">
        <?php foreach($listUser as $user): ?>
            <div class="bg-slate-800 border border-slate-700 rounded-xl p-4 shadow-sm">
                <div class="grid grid-cols-2 gap-2 text-sm text-slate-300">
                    <div class="font-medium text-slate-400">ID User:</div>
                    <div class="text-right font-semibold text-white"><?= $user['id_user'] ?></div>

                    <div class="font-medium text-slate-400">Nama:</div>
                    <div class="text-right"><?= htmlspecialchars($user['nama_lengkap']) ?></div>

                    <div class="font-medium text-slate-400">Email:</div>
                    <div class="text-right"><?= htmlspecialchars($user['email']) ?></div>

                    <div class="font-medium text-slate-400">Gender:</div>
                    <div class="text-right">
                        <?php
                        $gender = $user['gender'] ?? '-';
                        if ($gender === 'L') { $label='Laki-laki'; $color='bg-blue-500/20 text-blue-400'; }
                        elseif ($gender==='P'){ $label='Perempuan'; $color='bg-pink-500/20 text-pink-400'; }
                        else{ $label='-'; $color='bg-slate-500/20 text-slate-400'; }
                        ?>
                        <span class="px-2 py-1 rounded text-xs font-medium <?= $color ?>"><?= $label ?></span>
                    </div>

                    <div class="font-medium text-slate-400">Role:</div>
                    <div class="text-right">
                        <?php
                        $role = $user['role'] ?? '-';
                        $roleMap = ['admin'=>['class'=>'bg-purple-500/20 text-purple-400','label'=>'Admin'],
                                    'petugas'=>['class'=>'bg-cyan-500/20 text-cyan-400','label'=>'Petugas']];
                        $color = $roleMap[$role]['class'] ?? 'bg-slate-500/20 text-slate-400';
                        $label = $roleMap[$role]['label'] ?? '-';
                        ?>
                        <span class="px-2 py-1 rounded text-xs font-medium <?= $color ?>"><?= $label ?></span>
                    </div>

                    <div class="font-medium text-slate-400">Dibuat:</div>
                    <div class="text-right"><?= $user['created_at'] ? (new DateTime($user['created_at']))->format('d M Y • H:i') : '-' ?></div>
                </div>

                <div class="mt-3 flex flex-col gap-2">
                    <a href="?action=edit-user&id=<?= $user['id_user'] ?>"
                       class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-slate-900 rounded flex items-center gap-1 justify-center">
                       <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="?action=delete-user&id=<?= $user['id_user'] ?>"
                       onclick="return confirm('Yakin ingin menghapus user ini?');"
                       class="px-3 py-1 bg-red-500 hover:bg-red-600 text-slate-900 rounded flex items-center gap-1 justify-center">
                       <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Desktop Table -->
    <div class="overflow-x-auto bg-slate-800 rounded-xl border border-slate-700 p-4 hidden sm:block">
        <table class="min-w-full divide-y divide-slate-700 text-sm">
            <thead class="bg-slate-900 text-slate-400">
                <tr>
                    <th class="px-6 py-3 text-left">ID User</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Gender</th>
                    <th class="px-6 py-3 text-left">Role</th>
                    <th class="px-6 py-3 text-left">Dibuat Pada</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700 text-slate-300">
                <?php foreach($listUser as $user): ?>
                    <tr class="hover:bg-slate-700 transition">
                        <td class="px-6 py-3"><?= $user['id_user'] ?></td>
                        <td class="px-6 py-3"><?= htmlspecialchars($user['nama_lengkap']) ?></td>
                        <td class="px-6 py-3"><?= htmlspecialchars($user['email']) ?></td>
                        <?php
                        $gender = $user['gender'] ?? '-';
                        if ($gender === 'L') { $label='Laki-laki'; $color='bg-blue-500/20 text-blue-400'; }
                        elseif ($gender==='P'){ $label='Perempuan'; $color='bg-pink-500/20 text-pink-400'; }
                        else{ $label='-'; $color='bg-slate-500/20 text-slate-400'; }
                        ?>
                        <td class="px-6 py-3"><span class="px-2 py-1 rounded text-xs font-medium <?= $color ?>"><?= $label ?></span></td>
                        <?php
                        $role = $user['role'] ?? '-';
                        $roleMap = ['admin'=>['class'=>'bg-purple-500/20 text-purple-400','label'=>'Admin'],
                                    'petugas'=>['class'=>'bg-cyan-500/20 text-cyan-400','label'=>'Petugas']];
                        $color = $roleMap[$role]['class'] ?? 'bg-slate-500/20 text-slate-400';
                        $label = $roleMap[$role]['label'] ?? '-';
                        ?>
                        <td class="px-6 py-3"><span class="px-2 py-1 rounded text-xs font-medium <?= $color ?>"><?= $label ?></span></td>
                        <td class="px-6 py-3"><?= $user['created_at'] ? (new DateTime($user['created_at']))->format('d M Y • H:i') : '-' ?></td>
                        <td class="px-6 py-3 flex gap-2">
                            <a href="?action=edit-user&id=<?= $user['id_user'] ?>"
                               class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-slate-900 rounded flex items-center gap-1">
                               <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="?action=delete-user&id=<?= $user['id_user'] ?>"
                               onclick="return confirm('Yakin ingin menghapus user ini?');"
                               class="px-2 py-1 bg-red-500 hover:bg-red-600 text-slate-900 rounded flex items-center gap-1">
                               <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Maksimal 5 tombol -->
    <div class="flex flex-wrap justify-center gap-2 mt-4">
        <?php
        $maxButtons = 5;
        $start = max(1, $page - intdiv($maxButtons, 2));
        $end = min($totalPages, $start + $maxButtons - 1);
        $start = max(1, $end - $maxButtons + 1);
        ?>
        <?php if ($page > 1): ?>
            <a href="?action=manage-user&page=<?= $page - 1 ?>" class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Prev</a>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <a href="?action=manage-user&page=<?= $i ?>" class="px-3 py-1 rounded <?= ($i==$page)?'bg-cyan-500 text-white':'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?action=manage-user&page=<?= $page + 1 ?>" class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Next</a>
        <?php endif; ?>
    </div>
</div>
            
</body>
</html>