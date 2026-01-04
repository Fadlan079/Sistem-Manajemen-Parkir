<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMAKIR</title>
    <script src="/sistem_parkir/Public/js/theme.js" defer></script> 
    <link rel="stylesheet" href="Css/output.css">
    <style>
        .nav-link {
        position: relative;
        color: var(--color-muted);
        transition: color .3s;
        }

        .nav-link.active {
        color: var(--color-primary);
        }

        .nav-link.active::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -6px;
        width: 100%;
        height: 2px;
        background: var(--color-primary);
        border-radius: 2px;
        }

        .mobile-link {
        padding: 0.75rem;
        border-radius: 0.75rem;
        color: var(--color-muted);
        transition: background .3s, color .3s;
        }

        .mobile-link.active {
        background: var(--color-primary);
        color: white;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-bg text-text antialiased">
    <nav class="fixed top-0 left-0 right-0 z-100 bg-bg/80 backdrop-blur border-b border-border">
        <div class="max-w-7xl mx-auto px-6 lg:px-20 h-16 flex items-center justify-between">
            <div class="font-extrabold text-xl text-primary">
            SIMAKIR
            </div>

            <div class="hidden md:flex items-center gap-8 text-sm">
            <a href="#home" class="nav-link">Home</a>
            <a href="#about" class="nav-link">Tentang</a>
            <a href="#cara-kerja" class="nav-link">Cara Kerja</a>
            <a href="#value" class="nav-link">Value</a>
            <a href="#fitur" class="nav-link">Fitur</a>
            <a href="?action=login"
                class="px-4 py-2 bg-success text-bg rounded-lg font-semibold">
                Login
            </a>
            </div>

            <button id="lpMenuBtn" class="md:hidden text-2xl">
            <i class="fa-solid fa-bars"></i>
            </button>

        </div>
    </nav>
    <div id="menuOverlay"
        class="fixed inset-0 bg-black/40 z-200 opacity-0 pointer-events-none transition"></div>
    <div id="lpMobileMenu"
        class="fixed top-0 left-0 h-full w-72 bg-bg border-r border-border
                z-210 -translate-x-full pointer-events-none
                transition-transform duration-300">


        <div class="p-6 flex justify-between items-center border-b border-border">
            <span class="font-bold text-lg text-primary">SIMAKIR</span>
            <button id="lpCloseMenu" class="text-xl">
            <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="p-6 flex flex-col gap-4 text-sm">
            <a href="#home" class="mobile-link">Home</a>
            <a href="#about" class="mobile-link">Tentang</a>
            <a href="#cara-kerja" class="mobile-link">Cara Kerja</a>
            <a href="#value" class="mobile-link">Value</a>
            <a href="#fitur" class="mobile-link">Fitur</a>
            

            <a href="?action=login"
            class="mt-4 px-4 py-2 bg-success text-bg rounded-lg font-semibold text-center">
            Login
            </a>
        </div>
    </div>
    <main>
        <?php include __DIR__ . "/../Sections/home.php"?>

        <?php include __DIR__ . "/../Sections/about.php"?>

        <?php include __DIR__ . "/../Sections/cara-kerja.php"?>

        <?php include __DIR__ . "/../Sections/value.php"?>

        <?php include __DIR__ . "/../Sections/fitur.php"?>

        <?php include __DIR__ . "/../Sections/CTA.php"?>
    </main>
    
    <footer class="bg-surface border-t border-border">
        <?php include __DIR__ . "/../components/footer.php"?>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('lpMenuBtn');
    const mobileMenu = document.getElementById('lpMobileMenu');
    const closeBtn = document.getElementById('lpCloseMenu');
    const overlay     = document.getElementById('menuOverlay');

    const navLinks    = document.querySelectorAll('.nav-link');
    const mobileLinks = document.querySelectorAll('.mobile-link');
    const allLinks    = document.querySelectorAll('.nav-link, .mobile-link');
    const sections    = document.querySelectorAll('section[id]');

    function openMenu(){
    mobileMenu.classList.remove('-translate-x-full','pointer-events-none');
    overlay.classList.remove('opacity-0','pointer-events-none');
    }

    function closeMenu(){
    mobileMenu.classList.add('-translate-x-full','pointer-events-none');
    overlay.classList.add('opacity-0','pointer-events-none');
    }

    if(menuBtn) menuBtn.addEventListener('click', openMenu);
    if(closeBtn) closeBtn.addEventListener('click', closeMenu);
    if(overlay) overlay.addEventListener('click', closeMenu);

    mobileLinks.forEach(link => {
        link.addEventListener('click', closeMenu);
    });

    function updateActiveNav(){
        let currentSection = '';

        sections.forEach(section => {
        const sectionTop = section.offsetTop - 120;
        if (window.scrollY >= sectionTop) {
            currentSection = section.getAttribute('id');
        }
        });

        allLinks.forEach(link => {
        link.classList.remove('active');
        const href = link.getAttribute('href');
        if (href === `#${currentSection}`) {
            link.classList.add('active');
        }
        });
    }

    window.addEventListener('scroll', updateActiveNav);
    updateActiveNav();

    allLinks.forEach(link => {
        link.addEventListener('click', e => {
        const target = link.getAttribute('href');

        if(target.startsWith('#')){
            e.preventDefault();
            const section = document.querySelector(target);

            if(section){
            const offset = 70;
            const y = section.offsetTop - offset;

            window.scrollTo({
                top: y,
                behavior: 'smooth'
            });
            }
        }
        });
    });

    });
    </script>
</body>
</html>