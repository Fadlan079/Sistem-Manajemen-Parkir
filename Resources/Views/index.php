<?php
    include __DIR__ . "/components/global-modal.php";
    $sessionUser = $_SESSION['user'] ?? null;
    $role = $sessionUser['role'] ?? null;
    $current = $_GET['action'] ?? 'index';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMAKIR</title>
    <script src="/sistem_parkir/Public/js/theme.js" defer></script> 
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
<body class="bg-bg text-text">
    <div class="mb-4">
        <?php
            if(isset($_SESSION['flash'])){
                alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
                unset($_SESSION['flash']);
            }
            ?>
    </div>

    <header>
        <?php include __DIR__ . "/../Views/components/header.php"?>
    </header>

    <main>
        <?php if(!$sessionUser): ?>
            <?php include __DIR__ . "/../Views/Pages/landing-page.php"?>
        <?php else: ?>
            <section id="app" class="mx-auto max-w-7xl px-6 py-10">
                <?php include __DIR__ . "/../Views/Pages/dashboard.php"?>
            </section>
        <?php endif ?>
    </main>

    <script src="/sistem_parkir/Public/js/app.js" defer></script>
</body>
</html>