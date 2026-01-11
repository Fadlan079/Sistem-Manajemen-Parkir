<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found · SIMAKIR</title>

    <script src="/sistem_parkir/Public/js/theme.js" defer></script> 
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--color-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--color-primary);
            border-radius: 999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: color-mix(in srgb, var(--color-primary) 85%, white);
        }
  </style>
</head>

<body class="bg-bg text-text font-sans">
    <?php include __DIR__ . "/../components/header-system.php"?>
    <div class="min-h-screen flex flex-col">
        <main class="flex-1 bg-surface">
            <div class="mx-auto max-w-7xl px-6">
                <div class="flex min-h-[70vh] items-center justify-center">
                    
                    <div class="max-w-xl w-full text-center">

                        <div class="mb-6 flex justify-center">
                            <i class="fa-regular fa-circle-question text-muted text-7xl"></i>
                        </div>

                        <h1 class="text-6xl font-semibold text-muted tracking-tight">
                            404
                        </h1>

                        <p class="mt-4 text-xl font-medium">
                            Halaman tidak ditemukan
                        </p>

                        <p class="mt-2 text-sm text-muted leading-relaxed">
                            Halaman yang kamu cari mungkin telah dipindahkan, dihapus,
                            atau URL yang kamu masukkan tidak valid.
                        </p>

                        <hr class="my-6 border-border">

                        <div class="flex items-center justify-center gap-4 text-sm">
                            <a href="?action=index"
                            class="inline-flex items-center gap-2 text-primary hover:underline">
                                <i class="fa-solid fa-arrow-left"></i>
                                Kembali ke Halaman Utama
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </main>
        <?php include __DIR__ . "/../components/footer-system.php"?>
    </div>
</body>
</html>
