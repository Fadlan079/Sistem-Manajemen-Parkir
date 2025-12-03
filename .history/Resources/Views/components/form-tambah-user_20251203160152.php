<?php include __DIR__ . 'global-modal.php'?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
          integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body class="bg-slate-900 min-h-screen p-6">

    <div class="max-w-md mx-auto bg-slate-800 p-6 rounded-xl shadow-lg mt-10">
        <h2 class="text-2xl font-semibold text-cyan-400 mb-4 flex items-center gap-2">
            <i class="fas fa-user-plus"></i> Tambah User
        </h2>

            <div class="mb-4">
                <?php
                if(isset($_SESSION['flash'])){
                    alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
                    unset($_SESSION['flash']); // Hapus flash biar cuma muncul sekali
                }
                ?>
            </div>

        <form action="?action=store-tambah-user" method="POST" class="space-y-4">
            <div>
                <label class="block text-slate-300 mb-1" for="nama_lengkap">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="w-full p-2 rounded bg-slate-900 text-slate-300" placeholder="Masukkan nama lengkap" required>
            </div>

            <div>
                <label class="block text-slate-300 mb-1" for="email">Email</label>
                <input type="email" name="email" id="email" class="w-full p-2 rounded bg-slate-900 text-slate-300" placeholder="Masukkan email" required>
            </div>

            <div>
                <label class="block text-slate-300 mb-1" for="password">Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 rounded bg-slate-900 text-slate-300" placeholder="Masukkan password" required>
            </div>

            <div>
                <label class="block text-slate-300 mb-1" for="gender">Gender</label>
                <select name="gender" id="gender" class="w-full p-2 rounded bg-slate-900 text-slate-300" required>
                    <option value="">-- Pilih Gender --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-300 mb-1" for="role">Role</label>
                <select name="role" id="role" class="w-full p-2 rounded bg-slate-900 text-slate-300">
                    <option value="petugas" selected>Petugas</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2 bg-cyan-500 hover:bg-cyan-600 text-slate-900 font-bold rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Simpan User
                </button>
                <a href="?action=manage-user" class="flex-1 py-2 bg-slate-600 hover:bg-slate-700 text-slate-200 font-bold rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>

</body>
</html>
