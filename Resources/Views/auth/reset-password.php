<?php include __DIR__ . '/../components/global-modal.php'?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Sistem Parkir</title>
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"/>
</head>
<body class="bg-slate-900 font-sans text-white min-h-screen flex items-center justify-center">

    <div class="w-full max-w-5xl bg-slate-800 shadow-xl rounded-2xl grid grid-cols-1 md:grid-cols-2 overflow-hidden">

        <div class="hidden md:flex p-10 bg-slate-800 flex-col justify-center items-center text-center">
            <i class="fa-solid fa-square-parking text-cyan-400 text-7xl mb-6"></i>
            <h2 class="text-2xl font-semibold text-cyan-300 mb-4">Sistem Parkir</h2>
            <p class="text-slate-300 leading-relaxed text-sm">
                Masukkan password baru untuk akun Anda.
            </p>
        </div>

        <form action="?action=store-reset-password" method="post" 
              class="p-8 flex flex-col gap-4 bg-slate-700">

            <h1 class="text-3xl font-bold text-cyan-400 mb-4 text-center">
                Reset Password
            </h1>

            <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token']) ?>">

            <div>
                <?php
                    if(isset($_SESSION['flash'])){
                        alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
                        unset($_SESSION['flash']); 
                    }
                ?>
            </div>

            <label>Password Baru</label>
            <input type="password" name="password" placeholder="********" required
                   class="w-full p-2 mb-4 rounded bg-slate-100 text-slate-900 focus:ring-2 focus:ring-cyan-500 outline-none">

            <button type="submit"
                    class="w-full bg-cyan-500 hover:bg-cyan-600 p-2 rounded text-white transition">
                Reset Password
            </button>

            <a href="?action=login"
               class="mt-4 text-sm text-cyan-400 hover:underline text-center">
               Kembali ke Login
            </a>
        </form>
    </div>
</body>
</html>
