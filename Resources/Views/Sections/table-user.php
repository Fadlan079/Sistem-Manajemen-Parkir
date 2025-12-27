<div class="mt-10">
    <!-- Header & Tombol Import/Export -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 flex-wrap">
        <h2 class="text-xl sm:text-2xl font-semibold text-cyan-400">
            Daftar <span class="text-neutral-400">User</span>
        </h2>

        <div class="flex flex-wrap gap-2">
            <!-- Import Excel -->
            <form action="?action=import-user-excel" method="POST" enctype="multipart/form-data">
                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-emerald-600/20 text-emerald-400 border border-emerald-600/40 rounded-lg hover:bg-emerald-600/30 transition text-sm font-medium">
                    <i class="fa-solid fa-file-import"></i> Import Excel
                    <input type="file" name="file_excel" accept=".xls,.xlsx" class="hidden" onchange="this.form.submit()">
                </label>
            </form>

            <!-- Export Excel -->
            <a href="?action=export-user-excel" class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600/20 text-cyan-400 border border-cyan-600/40 rounded-lg hover:bg-cyan-600/30 transition text-sm font-medium">
                <i class="fa-solid fa-file-export"></i> Export Excel
            </a>
        </div>
    </div>

    <!-- Card Style Mobile -->
    <div class="space-y-4">
        <?php foreach($listUser as $user): ?>
            <?php
            // Gender
            $gender = $user['gender'] ?? '-';
            if ($gender === 'L') { $genderClass = 'bg-blue-500/20 text-blue-400'; $genderIcon = '<i class="fa-solid fa-mars"></i>'; $genderLabel = 'Laki-laki'; }
            elseif ($gender === 'P') { $genderClass = 'bg-pink-500/20 text-pink-400'; $genderIcon = '<i class="fa-solid fa-venus"></i>'; $genderLabel = 'Perempuan'; }
            else { $genderClass = 'bg-slate-500/20 text-slate-400'; $genderIcon = '<i class="fa-solid fa-circle-question"></i>'; $genderLabel = '-'; }

            // Role
            $role = $user['role'] ?? '-';
            $roleMap = [
                'admin' => ['class' => 'bg-purple-500/20 text-purple-400','icon' => '<i class="fa-solid fa-user-shield mr-1"></i>'],
                'petugas' => ['class' => 'bg-cyan-500/20 text-cyan-400','icon' => '<i class="fa-solid fa-id-badge mr-1"></i>']
            ];
            $roleClass = $roleMap[$role]['class'] ?? 'bg-slate-500/20 text-slate-400';
            $roleIcon = $roleMap[$role]['icon'] ?? '';
            $roleDisplay = ucfirst($role);
            ?>
            <div class="bg-slate-800 border border-slate-700 rounded-xl p-4 shadow-sm sm:hidden text-sm text-slate-300">
                <div class="grid grid-cols-2 gap-2">
                    <div class="font-medium text-slate-400">ID User:</div>
                    <div class="text-right font-semibold text-white"><?= $user['id_user'] ?></div>

                    <div class="font-medium text-slate-400">Nama:</div>
                    <div class="text-right"><?= $user['nama_lengkap'] ?></div>

                    <div class="font-medium text-slate-400">Email:</div>
                    <div class="text-right"><?= $user['email'] ?></div>

                    <div class="font-medium text-slate-400">Gender:</div>
                    <div class="text-right"><span class="px-2 py-1 rounded-md text-sm font-medium flex items-center gap-1 <?= $genderClass ?>"><?= $genderIcon ?> <?= $genderLabel ?></span></div>

                    <div class="font-medium text-slate-400">Role:</div>
                    <div class="text-right"><span class="px-2 py-1 rounded-md text-sm font-medium <?= $roleClass ?>"><?= $roleIcon . $roleDisplay ?></span></div>

                    <div class="font-medium text-slate-400">Dibuat Pada:</div>
                    <div class="text-right"><?= $user['created_at'] ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Desktop Table -->
    <div class="overflow-x-auto bg-slate-800 rounded-xl border border-slate-700 p-4 hidden sm:block">
        <table class="min-w-full divide-y divide-slate-700 text-sm">
            <thead class="bg-slate-900 text-slate-400">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">ID User</th>
                    <th class="px-6 py-3 text-left">Nama Lengkap</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Gender</th>
                    <th class="px-6 py-3 text-left">Role</th>
                    <th class="px-6 py-3 text-left">Dibuat Pada</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700 text-slate-300">
                <?php $p = 1; foreach($listUser as $user): ?>
                    <?php
                    // Gender
                    $gender = $user['gender'] ?? '-';
                    if ($gender === 'L') { $genderClass = 'bg-blue-500/20 text-blue-400'; $genderIcon = '<i class="fa-solid fa-mars"></i>'; $genderLabel = 'Laki-laki'; }
                    elseif ($gender === 'P') { $genderClass = 'bg-pink-500/20 text-pink-400'; $genderIcon = '<i class="fa-solid fa-venus"></i>'; $genderLabel = 'Perempuan'; }
                    else { $genderClass = 'bg-slate-500/20 text-slate-400'; $genderIcon = '<i class="fa-solid fa-circle-question"></i>'; $genderLabel = '-'; }

                    // Role
                    $role = $user['role'] ?? '-';
                    $roleMap = [
                        'admin' => ['class' => 'bg-purple-500/20 text-purple-400','icon' => '<i class="fa-solid fa-user-shield mr-1"></i>'],
                        'petugas' => ['class' => 'bg-cyan-500/20 text-cyan-400','icon' => '<i class="fa-solid fa-id-badge mr-1"></i>']
                    ];
                    $roleClass = $roleMap[$role]['class'] ?? 'bg-slate-500/20 text-slate-400';
                    $roleIcon = $roleMap[$role]['icon'] ?? '';
                    $roleDisplay = ucfirst($role);
                    ?>
                    <tr class="hover:bg-slate-700 transition">
                        <td class="px-6 py-3"><?= $p++ ?></td>
                        <td class="px-6 py-3"><?= $user['id_user'] ?></td>
                        <td class="px-6 py-3"><?= $user['nama_lengkap'] ?></td>
                        <td class="px-6 py-3"><?= $user['email'] ?></td>
                        <td class="px-6 py-3"><span class="px-2 py-1 rounded-md text-sm font-medium flex items-center gap-1 <?= $genderClass ?>"><?= $genderIcon ?> <?= $genderLabel ?></span></td>
                        <td class="px-6 py-3"><span class="px-2 py-1 rounded-md text-sm font-medium <?= $roleClass ?>"><?= $roleIcon . $roleDisplay ?></span></td>
                        <td class="px-6 py-3"><?= $user['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Maks 5 tombol -->
<div class="flex flex-wrap justify-center gap-2 mt-4">
<?php
$maxButtons = 5;
$start = max(1, $pageUser - intdiv($maxButtons, 2));
$end = min($totalPagesUser, $start + $maxButtons - 1);
$start = max(1, $end - $maxButtons + 1);
?>

<?php if ($pageUser > 1): ?>
    <button onclick="loadTable('user', null, <?= $pageUser - 1 ?>)"
        class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">
        Prev
    </button>
<?php endif; ?>

<?php for ($i = $start; $i <= $end; $i++): ?>
    <button onclick="loadTable('user', null, <?= $i ?>)"
        class="px-3 py-1 rounded
        <?= $i == $pageUser ? 'bg-cyan-500 text-white' : 'bg-slate-700 text-slate-300 hover:bg-slate-600' ?>">
        <?= $i ?>
    </button>
<?php endfor; ?>

<?php if ($pageUser < $totalPagesUser): ?>
    <button onclick="loadTable('user', null, <?= $pageUser + 1 ?>)"
        class="px-3 py-1 bg-slate-700 text-slate-300 rounded hover:bg-slate-600">
        Next
    </button>
<?php endif; ?>
</div>

</div>
