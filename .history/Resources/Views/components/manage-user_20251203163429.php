<?php include __DIR__ . "/global-modal.php";?>
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
    <?php include __DIR__ . "/header.php"?>

    <div class="max-w-6xl mx-auto space-y-4 mt-20">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-cyan-400">Manage <span class="text-neutral-400">User</span></h1>
            <div class="flex gap-2">
                <a href="?action=index" 
                   class="bg-slate-600 hover:bg-slate-700 text-slate-200 px-4 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                   <i class="fas fa-arrow-left"></i> Dashboard
                </a>
                <a href="?action=tambah-user" 
                   class="bg-cyan-500 hover:bg-cyan-600 text-slate-900 px-4 py-2 rounded-lg font-semibold transition flex items-center gap-2">
                   <i class="fas fa-user-plus"></i> Tambah User
                </a>
            </div>
        </div>

            <div class="mb-4">
                <?php
                if(isset($_SESSION['flash'])){
                    alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
                    unset($_SESSION['flash']); // Hapus flash biar cuma muncul sekali
                }
                ?>
            </div>

       <div class="overflow-x-auto bg-slate-800 rounded-xl shadow-lg">
            <table class="min-w-full divide-y divide-slate-700">
                <thead class="bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-slate-300 font-medium uppercase">#</th>
                        <th class="px-6 py-3 text-left text-slate-300 font-medium uppercase">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-slate-300 font-medium uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-slate-300 font-medium uppercase">Gender</th>
                        <th class="px-6 py-3 text-left text-slate-300 font-medium uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-slate-300 font-medium uppercase">Dibuat Pada</th>
                        <th class="px-6 py-3 text-left text-slate-300 font-medium uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-slate-800 divide-y divide-slate-700">
                    <?php foreach($listUser as $user): ?>
                        <tr class="hover:bg-slate-700 transition">
                            <td class="px-6 py-4 text-slate-300"><?= $p++ ?></td>
                            <td class="px-6 py-4 text-slate-300"><?= htmlspecialchars($user['nama_lengkap']) ?></td>
                            <td class="px-6 py-4 text-slate-300"><?= htmlspecialchars($user['email']) ?></td>
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
                            <td class="px-6 py-4 text-slate-300"><?= htmlspecialchars($user['role']) ?></td>
                            <td class="px-6 py-4 text-slate-300"><?= $user['created_at'] ?></td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="?action=edit-user&id=<?= $user['id_user'] ?>" 
                                   class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-slate-900 rounded flex items-center gap-1 transition">
                                   <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="?action=delete-user&id=<?= $user['id_user'] ?>" 
                                   onclick="return confirm('Yakin ingin menghapus user ini?');"
                                   class="px-3 py-1 bg-red-500 hover:bg-red-600 text-slate-900 rounded flex items-center gap-1 transition">
                                   <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(empty($listUser)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-slate-400 py-4">Belum ada data user.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex justify-center gap-2 mt-4">
        <?php if ($page > 1): ?>
            <a href="?action=manage-user&page=<?= $page - 1 ?>" 
            class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?action=manage-user&page=<?= $i ?>"
            class="px-3 py-1 rounded 
            <?= ($i == $page) ? 'bg-cyan-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?action=manage-user&page=<?= $page + 1 ?>" 
            class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">Next</a>
        <?php endif; ?>
    </div>
</body>
</html>