<?php if (!empty($listUser)): ?>
<div id="chart-user-container"
     class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 ">

    <!-- Role User -->
    <div class="
        bg-surface border border-border
        p-4 rounded-xl
        shadow-md
    ">
        <h3 class="text-primary font-semibold mb-2">
            Role User
        </h3>
        <canvas id="chartRole"></canvas>
    </div>

    <!-- Gender User -->
    <div class="
        bg-surface border border-border
        p-4 rounded-xl
        shadow-md
    ">
        <h3 class="text-primary font-semibold mb-2">
            Gender User
        </h3>
        <canvas id="chartGender"></canvas>
    </div>

    <!-- Verifikasi User -->
    <div class="
        bg-surface border border-border
        p-4 rounded-xl
        shadow-md
    ">
        <h3 class="text-primary font-semibold mb-2">
            Verifikasi User
        </h3>
        <canvas id="chartVerif"></canvas>
    </div>

    <!-- Pertumbuhan User -->
    <div class="
        bg-surface border border-border
        p-4 rounded-xl
        shadow-md
        md:col-span-2
    ">
        <h3 class="text-primary font-semibold mb-2">
            Pertumbuhan User
        </h3>
        <canvas id="chartUserHarian"></canvas>
    </div>

</div>
    
<?php endif; ?>

<div class="mt-10">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 flex-wrap">
        <h2 class="text-xl sm:text-2xl font-semibold text-primary">
            Daftar <span class="text-muted">User</span>
        </h2>

        <div class="flex flex-wrap gap-2">
            <form action="?action=import-user-excel" method="POST" enctype="multipart/form-data">
                <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-soft-success border border-success rounded-lg hover-bg-success transition text-sm font-medium">
                    <i class="fa-solid fa-file-import"></i> Import Excel
                    <input type="file" name="file_excel" accept=".xls,.xlsx" class="hidden" onchange="this.form.submit()">
                </label>
            </form>

            <a href="?action=export-user-excel" class="inline-flex items-center gap-2 px-4 py-2 bg-soft-primary border border-primary rounded-lg hover-bg-primary transition text-sm font-medium">
                <i class="fa-solid fa-file-export"></i> Export Excel
            </a>
        </div>
    </div>

    <?php if (empty($listUser)): ?>

    <div class="bg-slate-800 border border-slate-700 rounded-xl p-8 text-center mt-6 ">
        <div class="flex flex-col items-center gap-3">
            <i class="fa-solid fa-users-slash text-4xl text-slate-500"></i>

            <h3 class="text-lg font-semibold text-slate-300">
                Data User Kosong
            </h3>
            <p class="text-sm text-slate-400 max-w-md">
                Belum ada data user yang tersedia saat ini.  
                Silakan lakukan 

                <form action="?action=import-user-excel" method="POST" enctype="multipart/form-data" class="inline">
                    <label class="text-emerald-400 font-medium cursor-pointer hover:underline">
                        import Excel
                        <input 
                            type="file" 
                            name="file_excel" 
                            accept=".xls,.xlsx" 
                            class="hidden" 
                            onchange="this.form.submit()"
                        >
                    </label>
                </form>

                atau tambahkan user baru.
            </p>
        </div>
    </div>

    <?php else:?>
<div class="space-y-4">
    <?php foreach($listUser as $user): ?>
        
        <?php 
        $verifiedAt = $user['email_verified_at'];

        if (!empty($verifiedAt)) {
            $verifStatusLabel = 'Terverifikasi';
            $verifStatusClass = 'bg-soft-success';
            $verifIcon = '<i class="fa-solid fa-circle-check mr-1"></i>';
            $verifDate = date('d M Y H:i', strtotime($verifiedAt));
        } else {
            $verifStatusLabel = 'Belum';
            $verifStatusClass = 'bg-soft-danger';
            $verifIcon = '<i class="fa-solid fa-circle-xmark mr-1"></i>';
            $verifDate = '-';
        }
        ?>

        <?php
        $gender = $user['gender'] ?? '-';
        if ($gender === 'L') {
            $genderClass = 'bg-soft-primary';
            $genderIcon = '<i class="fa-solid fa-mars"></i>';
            $genderLabel = 'Laki-laki';
        } elseif ($gender === 'P') {
            $genderClass = 'bg-soft-warning';
            $genderIcon = '<i class="fa-solid fa-venus"></i>';
            $genderLabel = 'Perempuan';
        } else {
            $genderClass = 'bg-soft-muted';
            $genderIcon = '<i class="fa-solid fa-circle-question"></i>';
            $genderLabel = '-';
        }

        $role = $user['role'] ?? '-';
        $roleMap = [
            'admin' => [
                'class' => 'bg-soft-primary',
                'icon' => '<i class="fa-solid fa-user-shield mr-1"></i>'
            ],
            'petugas' => [
                'class' => 'bg-soft-warning',
                'icon' => '<i class="fa-solid fa-id-badge mr-1"></i>'
            ]
        ];
        $roleClass = $roleMap[$role]['class'] ?? 'bg-soft-muted';
        $roleIcon = $roleMap[$role]['icon'] ?? '';
        $roleDisplay = ucfirst($role);
        ?>

        <div class="bg-surface border border-border rounded-xl p-4 shadow-sm sm:hidden text-xs text-text">
            <div class="grid grid-cols-2 gap-2">
                <div class="font-medium text-muted">ID User:</div>
                <div class="text-right font-semibold">
                    <?= $user['id_user'] ?>
                </div>

                <div class="font-medium text-muted">Nama:</div>
                <div class="text-right">
                    <?= $user['nama_lengkap'] ?>
                </div>

                <div class="font-medium text-muted">Email:</div>
                <div class="text-right truncate">
                    <?= $user['email'] ?>
                </div>

                <div class="font-medium text-muted">Gender:</div>
                <div class="text-right">
                    <span class="px-2 py-0.5 rounded text-[11px] font-medium inline-flex items-center gap-1 <?= $genderClass ?>">
                        <?= $genderIcon ?> <?= $genderLabel ?>
                    </span>
                </div>

                <div class="font-medium text-muted">Role:</div>
                <div class="text-right">
                    <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $roleClass ?>">
                        <?= $roleIcon . $roleDisplay ?>
                    </span>
                </div>

                <div class="font-medium text-muted">Dibuat Pada:</div>
                <div class="text-right">
                    <?= $user['created_at'] ?>
                </div>

                <div class="font-medium text-muted">Status Verifikasi:</div>
                <div class="text-right">
                    <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $verifStatusClass ?>">
                        <?= $verifIcon . $verifStatusLabel ?>
                    </span>
                </div>

                <div class="font-medium text-muted">Tgl Verifikasi:</div>
                <div class="text-right">
                    <?= $verifDate ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

    <div class="overflow-x-auto bg-surface rounded-xl border border-border p-4 hidden sm:block">
    <table class="min-w-full text-xs">
        <thead class="bg-bg text-text uppercase tracking-wide">
            <tr>
                <th class="px-3 py-2">ID</th>
                <th class="px-3 py-2">Nama</th>
                <th class="px-3 py-2">Email</th>
                <th class="px-3 py-2">Gender</th>
                <th class="px-3 py-2">Role</th>
                <th class="px-3 py-2">Dibuat</th>
                <th class="px-3 py-2">Verif</th>
                <th class="px-3 py-2">Tgl Verif</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-neutral-600 text-text">
            <?php foreach($listUser as $user): ?>
                <?php 
                $verifiedAt = $user['email_verified_at'];

                if (!empty($verifiedAt)) {
                    $verifStatusLabel = 'Terverifikasi';
                    $verifStatusClass = 'bg-soft-success';
                    $verifIcon = '<i class="fa-solid fa-circle-check mr-1"></i>';
                    $verifDate = date('d M Y H:i', strtotime($verifiedAt));
                } else {
                    $verifStatusLabel = 'Belum';
                    $verifStatusClass = 'bg-soft-danger';
                    $verifIcon = '<i class="fa-solid fa-circle-xmark mr-1"></i>';
                    $verifDate = '-';
                }
                ?>

                <?php
                $gender = $user['gender'] ?? '-';
                if ($gender === 'L') {
                    $genderClass = 'bg-soft-primary';
                    $genderIcon = '<i class="fa-solid fa-mars"></i>';
                    $genderLabel = 'Laki-laki';
                } elseif ($gender === 'P') {
                    $genderClass = 'bg-soft-warning';
                    $genderIcon = '<i class="fa-solid fa-venus"></i>';
                    $genderLabel = 'Perempuan';
                } else {
                    $genderClass = 'bg-soft-muted';
                    $genderIcon = '<i class="fa-solid fa-circle-question"></i>';
                    $genderLabel = '-';
                }

                $role = $user['role'] ?? '-';
                $roleMap = [
                    'admin' => [
                        'class' => 'bg-soft-primary',
                        'icon' => '<i class="fa-solid fa-user-shield mr-1"></i>'
                    ],
                    'petugas' => [
                        'class' => 'bg-soft-warning',
                        'icon' => '<i class="fa-solid fa-id-badge mr-1"></i>'
                    ]
                ];
                $roleClass = $roleMap[$role]['class'] ?? 'bg-soft-muted';
                $roleIcon = $roleMap[$role]['icon'] ?? '';
                $roleDisplay = ucfirst($role);
                ?>

                <tr class="hover-bg-primary transition">
                    <td class="px-2 py-2 align-middle">
                        <?= $user['id_user'] ?>
                    </td>

                    <td class="px-3 py-2 align-middle">
                        <div class="font-medium text-text leading-tight">
                            <?= $user['nama_lengkap'] ?>
                        </div>
                    </td>

                    <td class="px-3 py-2 align-middle">
                        <div class="text-[11px] truncate max-w-[220px]" title="<?= $user['email'] ?>">
                            <?= $user['email'] ?>
                        </div>
                    </td>

                    <td class="px-3 py-2 align-middle">
                        <span class="px-2 py-0.5 rounded text-[11px] font-medium inline-flex items-center gap-1 <?= $genderClass ?>">
                            <?= $genderIcon ?> <?= $genderLabel ?>
                        </span>
                    </td>

                    <td class="px-3 py-2 align-middle">
                        <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $roleClass ?>">
                            <?= $roleIcon . $roleDisplay ?>
                        </span>
                    </td>

                    <td class="px-3 py-2 align-middle">
                        <?= $user['created_at'] ?>
                    </td>

                    <td class="px-3 py-2 align-middle">
                        <span class="px-2 py-0.5 rounded text-[11px] font-medium <?= $verifStatusClass ?>">
                            <?= $verifIcon . $verifStatusLabel ?>
                        </span>
                    </td>

                    <td class="px-3 py-2 align-middle">
                        <?= $verifDate ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


    <div class="flex flex-wrap justify-center gap-2 mt-4">
        <?php
        $maxButtons = 5;
        $start = max(1, $pageUser - intdiv($maxButtons, 2));
        $end = min($totalPagesUser, $start + $maxButtons - 1);
        $start = max(1, $end - $maxButtons + 1);
        ?>

        <?php if ($pageUser > 1): ?>
            <button onclick="loadTable('user', null, <?= $pageUser - 1 ?>)"
                class="px-3 py-1 rounded
                    bg-surface text-muted
                    hover-bg-primary hover-text-primary
                    transition">
                Prev
            </button>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <button onclick="loadTable('user', null, <?= $i ?>)"
                class="px-3 py-1 rounded
                <?= $i == $pageUser 
                    ? 'bg-primary text-bg font-semibold'
                    : 'bg-surface text-muted hover-bg-primary hover-text-primary' ?>">
                <?= $i ?>
            </button>
        <?php endfor; ?>

        <?php if ($pageUser < $totalPagesUser): ?>
            <button onclick="loadTable('user', null, <?= $pageUser + 1 ?>)"
                class="px-3 py-1 rounded
                    bg-surface text-muted
                    hover-bg-primary hover-text-primary
                    transition">
                Next
            </button>
        <?php endif; ?>
        </div>
    </div>
<?php endif?>