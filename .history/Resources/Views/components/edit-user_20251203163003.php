<?php include __DIR__ . "/global-modal.php";?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
          integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body class="bg-slate-900 min-h-screen p-6">

    <div class="max-w-md mx-auto bg-slate-800 p-8 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold text-cyan-400 mb-6">Edit User</h1>
            <div class="mb-4">
                <?php
                if(isset($_SESSION['flash'])){
                    alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
                    unset($_SESSION['flash']); // Hapus flash biar cuma muncul sekali
                }
                ?>
            </div>


        <form action="?action=store-edit-user" method="POST" class="space-y-4">
            <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">

            <div>
                <label class="block text-slate-300 mb-1" for="nama_lengkap">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required
                       class="w-full bg-slate-700 text-slate-100 border border-slate-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400">
            </div>

            <div>
                <label class="block text-slate-300 mb-1" for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required
                       class="w-full bg-slate-700 text-slate-100 border border-slate-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400">
            </div>

            <div>
                <label class="block text-slate-300 mb-1" for="password">Password (Kosongkan jika tidak ingin diubah)</label>
                <input type="password" name="password" id="password"
                       class="w-full bg-slate-700 text-slate-100 border border-slate-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400">
            </div>

            <div>
                <label class="block text-slate-300 mb-1" for="gender">Gender</label>
                <select name="gender" id="gender" required
                        class="w-full bg-slate-700 text-slate-100 border border-slate-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                    <option value="L" <?= $user['gender'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="P" <?= $user['gender'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-300 mb-1" for="role">Role</label>
                <select name="role" id="role" required
                        class="w-full bg-slate-700 text-slate-100 border border-slate-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="petugas" <?= $user['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                </select>
            </div>

            <div class="flex justify-between items-center">
                <a href="?action=manage-user" class="text-cyan-400 hover:underline"><i class="fas fa-arrow-left"></i> Kembali</a>
                <button type="submit"
                        class="bg-cyan-500 hover:bg-cyan-600 text-slate-900 px-4 py-2 rounded flex items-center gap-1">
                        <i class="fas fa-edit"></i> Update User
                </button>
            </div>
        </form>
    </div>

</body>
</html>