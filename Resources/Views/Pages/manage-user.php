<?php include __DIR__ . "/../components/global-modal.php"?>

<div class="max-w-7xl mx-auto space-y-4 lg:ml-30 px-6 pt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 flex-wrap">
        <h2 class="text-xl sm:text-2xl font-semibold text-primary">
            Daftar <span class="text-muted">User</span>
        </h2>

        <div class="hidden sm:flex flex-wrap gap-2">
            <a href="?action=tambah-user" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-surface text-primary border border-primary rounded-lg hover-bg-primary hover-text-bg transition text-sm font-medium">
               <i class="fa-solid fa-user-plus"></i> Tambah User
            </a>
        </div>

        <a href="?action=tambah-user" 
           class="flex sm:hidden flex-col justify-center items-center bg-surface border border-primary rounded-xl p-6 shadow hover-bg-primary hover-text-bg transition text-primary">
            <i class="fa-solid fa-user-plus text-2xl mb-2"></i>
            <span class="font-medium text-sm">Tambah User</span>
        </a>
    </div>

    <div class="space-y-4 sm:hidden">
        <?php foreach($listUser as $user): ?>
            <div class="bg-surface border border-border rounded-xl p-4 shadow-sm">
                <div class="grid grid-cols-2 gap-2 text-sm text-text">
                    <div class="font-medium text-muted">ID User:</div>
                    <div class="text-right font-semibold text-text"><?= $user['id_user'] ?></div>

                    <div class="font-medium text-muted">Nama:</div>
                    <div class="text-right"><?= htmlspecialchars($user['nama_lengkap']) ?></div>

                    <div class="font-medium text-muted">Email:</div>
                    <div class="text-right"><?= htmlspecialchars($user['email']) ?></div>

                    <div class="font-medium text-muted">Gender:</div>
                    <div class="text-right">
                        <?php
                        $gender = $user['gender'] ?? '-';
                        if ($gender === 'L') { $label='Laki-laki'; $color='bg-soft-primary text-bg'; }
                        elseif ($gender==='P'){ $label='Perempuan'; $color='bg-soft-warning text-bg'; }
                        else{ $label='-'; $color='bg-soft-muted text-text'; }
                        ?>
                        <span class="px-2 py-1 rounded text-xs font-medium <?= $color ?>"><?= $label ?></span>
                    </div>

                    <div class="font-medium text-muted">Role:</div>
                    <div class="text-right">
                        <?php
                        $role = $user['role'] ?? '-';
                        $roleMap = [
                            'admin'=>['class'=>'bg-soft-primary text-bg','label'=>'Admin'],
                            'petugas'=>['class'=>'bg-soft-warning text-bg','label'=>'Petugas']
                        ];
                        $color = $roleMap[$role]['class'] ?? 'bg-soft-muted text-text';
                        $label = $roleMap[$role]['label'] ?? '-';
                        ?>
                        <span class="px-2 py-1 rounded text-xs font-medium <?= $color ?>"><?= $label ?></span>
                    </div>

                    <div class="font-medium text-muted">Dibuat:</div>
                    <div class="text-right"><?= $user['created_at'] ? (new DateTime($user['created_at']))->format('d M Y • H:i') : '-' ?></div>
                </div>

                <div class="mt-3 flex flex-col gap-2">
                    <a href="?action=edit-user&id=<?= $user['id_user'] ?>"
                       class="px-3 py-1 bg-warning hover-bg-warning/80 text-text rounded flex items-center gap-1 justify-center">
                       <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="?action=delete-user&id=<?= $user['id_user'] ?>"
                       onclick="return confirm('Yakin ingin menghapus user ini?');"
                       class="px-3 py-1 bg-danger hover-bg-danger/80 text-text rounded flex items-center gap-1 justify-center">
                       <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="overflow-x-auto bg-surface rounded-xl border border-border p-4 hidden sm:block">
        <table class="min-w-full text-sm">
            <thead class="bg-bg text-text">
                <tr>
                    <th class="px-3 py-2 text-left">ID User</th>
                    <th class="px-3 py-2 text-left">Nama</th>
                    <th class="px-3 py-2 text-left">Email</th>
                    <th class="px-3 py-2 text-left">Gender</th>
                    <th class="px-3 py-2 text-left">Role</th>
                    <th class="px-3 py-2 text-left">Dibuat Pada</th>
                    <th class="px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border text-text">
                <?php foreach($listUser as $user): ?>
                    <tr class="hover-bg-primary transition">
                        <td class="px-3 py-2"><?= $user['id_user'] ?></td>
                        <td class="px-3 py-2"><?= htmlspecialchars($user['nama_lengkap']) ?></td>
                        <td class="px-3 py-2"><?= htmlspecialchars($user['email']) ?></td>

                        <?php
                        $gender = $user['gender'] ?? '-';
                        if ($gender === 'L') { $label='Laki-laki'; $color='bg-soft-primary text-bg'; }
                        elseif ($gender==='P'){ $label='Perempuan'; $color='bg-soft-warning text-bg'; }
                        else{ $label='-'; $color='bg-soft-muted text-text'; }
                        ?>
                        <td class="px-3 py-2"><span class="px-2 py-0.5 rounded text-xs font-medium <?= $color ?>"><?= $label ?></span></td>

                        <?php
                        $role = $user['role'] ?? '-';
                        $roleMap = [
                            'admin'=>['class'=>'bg-soft-primary text-bg','label'=>'Admin'],
                            'petugas'=>['class'=>'bg-soft-warning text-bg','label'=>'Petugas']
                        ];
                        $color = $roleMap[$role]['class'] ?? 'bg-soft-muted text-text';
                        $label = $roleMap[$role]['label'] ?? '-';
                        ?>
                        <td class="px-3 py-2"><span class="px-2 py-0.5 rounded text-xs font-medium <?= $color ?>"><?= $label ?></span></td>

                        <td class="px-3 py-2"><?= $user['created_at'] ? (new DateTime($user['created_at']))->format('d M Y • H:i') : '-' ?></td>

                        <td class="px-3 py-2 flex gap-2">
                            <a href="?action=edit-user&id=<?= $user['id_user'] ?>"
                               class="px-2 py-1 bg-warning hover-bg-warning/80 text-text rounded flex items-center gap-1">
                               <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="?action=delete-user&id=<?= $user['id_user'] ?>"
                               onclick="return confirm('Yakin ingin menghapus user ini?');"
                               class="px-2 py-1 bg-danger hover-bg-danger/80 text-text rounded flex items-center gap-1">
                               <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="flex flex-wrap justify-center gap-2 mt-4">
        <?php
        $maxButtons = 5;
        $start = max(1, $page - intdiv($maxButtons, 2));
        $end = min($totalPages, $start + $maxButtons - 1);
        $start = max(1, $end - $maxButtons + 1);
        ?>
        <?php if ($page > 1): ?>
            <button onclick="location.href='?action=manage-user&page=<?= $page - 1 ?>'"
                    class="px-3 py-1 rounded bg-surface text-muted hover-bg-primary hover-text-bg transition">Prev</button>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <button onclick="location.href='?action=manage-user&page=<?= $i ?>'"
                    class="px-3 py-1 rounded transition <?= ($i==$page)?'bg-primary text-bg font-semibold':'bg-surface text-muted hover-bg-primary hover-text-bg' ?>">
                <?= $i ?>
            </button>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <button onclick="location.href='?action=manage-user&page=<?= $page + 1 ?>'"
                    class="px-3 py-1 rounded bg-surface text-muted hover-bg-primary hover-text-bg transition">Next</button>
        <?php endif; ?>
    </div>
</div>
