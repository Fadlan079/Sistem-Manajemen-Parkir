<?php include __DIR__ . '/../components/global-modal.php'?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIMAKIR</title>
    <script src="/sistem_parkir/Public/js/theme.js" defer></script> 
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>

<body class="bg-bg font-sans text-text">

    <div class="max-w-5xl mx-auto lg:mt-16 bg-surface shadow-xl rounded-2xl grid grid-cols-1 md:grid-cols-2 overflow-hidden">
        
        <?php
            if(isset($_SESSION['flash'])){
                alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
                unset($_SESSION['flash']);
            }
        ?>

        <form action="?action=store-register" method="post" 
              class="p-8 flex flex-col gap-4 bg-surface border border-border rounded-r-2xl">

            <h1 class="text-3xl font-bold text-primary mb-4 text-center">
                Registrasi Pengguna
            </h1>

            <div class="flex flex-col">
                <label class="text-sm mb-1 text-text">Nama Lengkap</label>
                <input type="text" name="nama_lengkap"
                    placeholder="Isi dengan nama lengkap"
                    class="bg-bg text-text p-2 rounded-lg border border-border
                           focus:ring-2 focus:ring-primary outline-none">
            </div>

            <div class="flex flex-col">
                <label class="text-sm mb-1 text-text">Email</label>
                <input type="text" name="email"
                    placeholder="Isi dengan email"
                    class="bg-bg text-text p-2 rounded-lg border border-border
                           focus:ring-2 focus:ring-primary outline-none">
            </div>

            <div class="flex flex-col">
                <label class="text-sm mb-1 text-text">Password</label>
                <input type="password" name="password"
                    placeholder="********"
                    class="bg-bg text-text p-2 rounded-lg border border-border
                           focus:ring-2 focus:ring-primary outline-none">
            </div>

            <div class="flex flex-col">
                <label class="text-sm mb-1 text-text">Gender</label>
                <select name="gender" 
                        class="bg-bg text-text p-2 rounded-lg border border-border
                               focus:ring-2 focus:ring-primary outline-none">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <button type="submit"
                    class="mt-3 bg-primary hover:bg-primary/90 text-bg p-2 rounded-lg text-lg shadow-md transition">
                Daftar Sekarang
            </button>

            <p class="text-sm text-center mt-2 text-text">
                Sudah punya akun?
                <a href="?action=login" class="text-primary hover:underline">Login</a>
            </p>
         
            <a href="?action=index"
               class="mt-2 w-full text-center border border-primary 
                      text-primary p-2 rounded-lg hover:bg-primary hover:text-bg 
                      flex items-center justify-center gap-2 transition">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Halaman Utama
            </a>
        </form>

        <div class="p-10 bg-surface flex flex-col justify-center items-center text-center">

            <i class="fa-solid fa-square-parking text-primary text-7xl mb-6"></i>

            <h2 class="text-2xl font-semibold text-primary mb-4">
                Sistem Manajemen Parkir
            </h2>

            <p class="text-muted leading-relaxed text-sm">
                Akses sistem parkir untuk mencatat kendaraan masuk dan keluar,
                mencetak tiket barcode, serta mengelola transaksi parkir
                melalui dashboard terpusat.
            </p>

            <ul class="mt-6 space-y-2 text-muted text-sm text-left">
                <li>
                    <i class="fa-solid fa-circle-check text-primary mr-2"></i>
                    Pencatatan kendaraan masuk dan keluar
                </li>
                <li>
                    <i class="fa-solid fa-circle-check text-primary mr-2"></i>
                    Pembuatan dan pencetakan tiket barcode
                </li>
                <li>
                    <i class="fa-solid fa-circle-check text-primary mr-2"></i>
                    Pengelolaan transaksi parkir
                </li>
                <li>
                    <i class="fa-solid fa-circle-check text-primary mr-2"></i>
                    Akses dashboard laporan parkir
                </li>
            </ul>
        </div>
    </div>
</body>
</html>
