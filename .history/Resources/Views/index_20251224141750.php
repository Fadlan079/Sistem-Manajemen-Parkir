<?php
    $sessionUser = $_SESSION['user'] ?? null;
    $role = $sessionUser['role'] ?? null;
    $current = $_GET['action'] ?? 'index';
    include 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Parkir</title>
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        ::-webkit-scrollbar {
            width: 5px;
            transition: width 0.3s ease;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: #22d3ee;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #06b6d4;
            box-shadow: 0 0 0 2px #06b6d4;
        }
  </style>
</head>
<body class="bg-slate-900 text-white">
    <div class="mb-4">
        <?php
        if(isset($_SESSION['flash'])){
            alert($_SESSION['flash']['type'], $_SESSION['flash']['msg']);
            unset($_SESSION['flash']); // Hapus flash biar cuma muncul sekali
        }
        ?>
    </div>

    <header>
        <?php include __DIR__ . "/../Views/components/header.php"?>
    </header>

    <main>
        <section class="max-w-7xl mx-auto px-6 py-10">
            <?php if(!$sessionUser): ?>
                <?php include __DIR__ . "/../Views/Pages/landing-page.php"?>
            <?php else: ?>
                <?php include __DIR__ . "/../Views/Pages/dashboard.php"?>
            <?php endif?>  
            <?php include __DIR__ . "/../Views/components/home.php"?>
        </section>
    </main>
    <footer class="bg-slate-900 text-slate-400 mt-10 p-6 rounded-t-xl shadow-inner">
        <?php include __DIR__ . "/../Views/components/footer.php"?>
    </footer>    
</body>
</html>