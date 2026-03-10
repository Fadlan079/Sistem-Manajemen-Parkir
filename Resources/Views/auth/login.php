<?php include __DIR__ . '/../components/global-modal.php'?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login · SIMAKIR</title>
    <script src="js/theme.js" defer></script> 
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>

<body class="bg-bg font-sans text-text">
    <div class="min-h-screen flex items-center justify-center bg-bg">
        <div class="min-h-screen w-full grid grid-cols-1 md:grid-cols-2">
            <div class="p-10 bg-surface flex flex-col justify-center items-center text-center h-full">
                <i class="fa-solid fa-square-parking text-primary text-6xl md:text-7xl lg:text-8xl mb-6"></i>

                <h2 class="text-xl md:text-2xl lg:text-3xl font-semibold text-primary mb-4">
                    Selamat Datang Kembali
                </h2>

                <p class="text-sm md:text-base lg:text-lg text-muted leading-relaxed max-w-lg">
                    Masuk ke sistem manajemen parkir untuk mencatat kendaraan,
                    mengelola transaksi, dan melihat laporan operasional secara terpusat.
                </p>

                <ul class="mt-8 space-y-3 text-sm md:text-base lg:text-lg text-muted text-left">
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
                        Pengelolaan transaksi dan histori parkir
                    </li>
                    <li>
                        <i class="fa-solid fa-circle-check text-primary mr-2"></i>
                        Akses dashboard laporan parkir
                    </li>
                </ul>
            </div>
            <div class="flex items-center justify-center bg-bg">
                <form action="?action=store-login" method="post"
                    class="w-full max-w-md p-8 bg-surface border border-border
                            lg:rounded-2xl shadow-xl flex flex-col gap-4">

                    <h1 class="text-3xl font-bold text-primary mb-4 text-center">
                        Login Sistem Parkir
                    </h1>

                    <div class="mb-4">
                        <?php
                            if(isset($_SESSION['flash'])){
                                alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
                                unset($_SESSION['flash']); 
                            }
                        ?>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm mb-1 text-text">Email</label>
                        <input type="text" name="email"
                            placeholder="Masukkan email"
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

                    <div class="flex justify-between mt-2 text-sm items-center">
                        <?php if(!empty($_SESSION['unverified_email'])): ?>
                            <div class="flex items-center gap-2">
                                <a id="resendBtn"
                                href="?action=resend-verification&email=<?= urlencode($_SESSION['unverified_email']) ?>"
                                onclick="handleResend(this)"
                                class="text-primary hover:underline">
                                    Kirim Ulang Email Verifikasi
                                </a>
                                <span id="timer" class="text-xs text-muted"></span>
                            </div>
                        <?php endif; ?>
                                    <a href="?action=forgot-password"
                        class="text-primary hover:underline">
                        Lupa password?
                        </a>
                    </div>

                    <button type="submit"
                            class="mt-3 bg-primary hover:bg-primary/90 text-bg p-2 rounded-lg text-lg shadow-md transition">
                        Login
                    </button>

                    <p class="text-sm text-center mt-2 text-text">
                        Belum punya akun?
                        <a href="?action=register" class="text-primary hover:underline">Register</a>
                    </p>

                    <a href="?action=index"
                    class="mt-2 w-full text-center border border-primary 
                            text-primary p-2 rounded-lg hover:bg-primary hover:text-bg 
                            flex items-center justify-center gap-2 transition">
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali ke Halaman Utama
                    </a>
                </form>
            </div>
    </div>
<script>
let sisa = <?= $_SESSION['resend_wait'] ?? 0 ?>;
const timer = document.getElementById('timer');
const btn = document.getElementById('resendBtn');

function lockButton(btn){
    if(!btn) return;
    btn.classList.add('opacity-50', 'pointer-events-none');
    btn.innerText = 'Tunggu...';
}

function handleResend(btn){
    lockButton(btn);
    if(timer) timer.innerText = '(mengirim...)';
}

if(btn && sisa > 0){
    lockButton(btn);

    const interval = setInterval(() => {
        if(timer) timer.innerText = `(${sisa} detik)`;
        sisa--; 

        if(sisa < 0){
            clearInterval(interval);
            btn.classList.remove('opacity-50', 'pointer-events-none');
            btn.innerText = 'Kirim Ulang Email Verifikasi';
            if(timer) timer.innerText = '';
        }
    }, 1000);
}
</script>
</body>
</html>
