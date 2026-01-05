<?php include __DIR__ . '/../components/global-modal.php'?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Sistem Parkir</title>
    <script src="/sistem_parkir/Public/js/theme.js" defer></script> 
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"/>
</head>
<body class="bg-bg font-sans text-text min-h-screen flex items-center justify-center">

    <div class="w-full max-w-5xl bg-surface shadow-xl rounded-2xl grid grid-cols-1 md:grid-cols-2 overflow-hidden">

        <div class="hidden md:flex p-10 bg-surface flex-col justify-center items-center text-center">
            <i class="fa-solid fa-square-parking text-primary text-7xl mb-6"></i>
            <h2 class="text-2xl font-semibold text-primary mb-4">Sistem Parkir</h2>
            <p class="text-muted leading-relaxed text-sm">
                Masukkan email untuk menerima link reset password.
            </p>
        </div>

        <form action="?action=store-forgot-password" method="post" 
              class="p-8 flex flex-col gap-4 bg-surface border border-border rounded-r-2xl">

            <h1 class="text-3xl font-bold text-primary mb-4 text-center">
                Lupa Password
            </h1>

            <div>
                <?php
                    if(isset($_SESSION['flash'])){
                        alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
                        unset($_SESSION['flash']); 
                    }
                ?>
            </div>

            <label class="text-text mb-1">Email</label>
            <input type="email" name="email" placeholder="Masukkan email" required
                   class="w-full p-2 mb-4 rounded bg-bg text-text border border-border
                          focus:ring-2 focus:ring-primary outline-none">

            <button type="submit"
                    class="w-full bg-primary hover:bg-primary/90 p-2 rounded text-bg transition">
                Kirim Link Reset
            </button>

            <a href="?action=login"
               class="mt-4 text-sm text-primary hover:underline text-center">
               Kembali ke Login
            </a>
        </form>
    </div>
</body>
</html>