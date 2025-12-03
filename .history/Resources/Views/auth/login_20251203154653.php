<?php include 'global-modal.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Parkir</title>
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>

<body class="bg-slate-900 font-sans text-white">
        <div class="mb-4">
        <?php
        if(isset($_SESSION['flash'])){
            alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
            unset($_SESSION['flash']); // Hapus flash biar cuma muncul sekali
        }
        ?>
    </div>

    <div class="max-w-5xl mx-auto mt-16 bg-slate-800 shadow-xl rounded-2xl grid grid-cols-1 md:grid-cols-2 overflow-hidden">

        <!-- LEFT SIDE — ILUSTRASI -->
        <div class="p-10 bg-slate-800 flex flex-col justify-center items-center text-center">

            <i class="fa-solid fa-square-parking text-cyan-400 text-7xl mb-6"></i>

            <h2 class="text-2xl font-semibold text-cyan-300 mb-4">
                Selamat Datang Kembali
            </h2>

            <p class="text-slate-300 leading-relaxed text-sm">
                Masuk ke sistem parkir untuk mengelola data kendaraan,
                transaksi, dan laporan secara mudah dan cepat.
            </p>

            <ul class="mt-6 space-y-2 text-slate-300 text-sm">
                <li><i class="fa-solid fa-circle-check text-cyan-400 mr-2"></i> Akses dashboard lengkap</li>
                <li><i class="fa-solid fa-circle-check text-cyan-400 mr-2"></i> Kelola kendaraan masuk/keluar</li>
                <li><i class="fa-solid fa-circle-check text-cyan-400 mr-2"></i> Pantau transaksi parkir real-time</li>
            </ul>
        </div>

        <!-- RIGHT SIDE — FORM LOGIN -->
        <form action="?action=store-login" method="post" 
              class="p-8 flex flex-col gap-4 bg-slate-700">

            <h1 class="text-3xl font-bold text-cyan-400 mb-4 text-center">
                Login Sistem Parkir
            </h1>

            <div class="flex flex-col">
                <label class="text-sm mb-1">Email</label>
                <input type="text" name="email"
                    placeholder="Masukkan email"
                    class="bg-slate-100 text-slate-900 p-2 rounded-lg 
                           focus:ring-2 focus:ring-cyan-500 outline-none">
            </div>

            <div class="flex flex-col">
                <label class="text-sm mb-1">Password</label>
                <input type="password" name="password"
                    placeholder="********"
                    class="bg-slate-100 text-slate-900 p-2 rounded-lg 
                           focus:ring-2 focus:ring-cyan-500 outline-none">
            </div>

            <button type="submit"
                    class="mt-3 bg-cyan-500 hover:bg-cyan-600 text-white p-2 rounded-lg text-lg shadow-md transition">
                Login
            </button>

            <p class="text-sm text-center mt-2">
                Belum punya akun?
                <a href="?action=register" class="text-cyan-400 hover:underline">Register</a>
            </p>

            <a href="?action=index"
            class="mt-2 w-full text-center border border-cyan-400 
                    text-cyan-400 p-2 rounded-lg hover:bg-cyan-500 hover:text-slate-900 
                    flex items-center justify-center gap-2 transition">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>
        </form>

    </div>

</body>
</html>
