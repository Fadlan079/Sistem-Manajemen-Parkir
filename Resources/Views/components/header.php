<?php if(isset($_SESSION['user'])): ?>
<aside class="
    fixed left-0 top-0 h-screen w-55
    bg-surface border-r border-border
    flex-col
    hidden md:flex
    z-200 rounded-r-2xl shadow-lg">

    <div class="
        flex items-center gap-3
        px-6 py-5
        border-b border-border">
        <div class="
            w-10 h-10 flex items-center justify-center
            rounded-full
            bg-soft-primary
            border-2 border-primary">
            <i class="fa-solid fa-square-parking text-primary"></i>
        </div>

        <span class="text-lg font-bold text-primary">
            SIMAKIR</span>
        </span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 text-text">
        <a href="#" data-page="dashboard" onclick="loadPage(event,'dashboard')"
           class="sidebar-link <?= $current=='index'?'active':'' ?>">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>

        <?php if($_SESSION['user']['role']==='admin'): ?>

            <a href="#" data-page="manage-user" onclick="loadPage(event,'manage-user')"
               class="sidebar-link <?= $current=='manage-user'?'active':'' ?>">
                <i class="fa-solid fa-users"></i>
                <span>Manage User</span>
            </a>

            <a href="#" data-page="manage-tarif" onclick="loadPage(event,'manage-tarif')"
               class="sidebar-link <?= $current=='manage-tarif'?'active':'' ?>">
                <i class="fa-solid fa-tags"></i>
                <span>Manage Tarif</span>
            </a>

        <?php else: ?>

            <a href="#" data-page="tiket-masuk" onclick="loadPage(event,'tiket-masuk')"
               class="sidebar-link <?= $current=='tiket-masuk'?'active':'' ?>">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                <span>Tiket Masuk</span>
            </a>

            <a href="#" data-page="tiket-keluar" onclick="loadPage(event,'tiket-keluar')"
               class="sidebar-link <?= $current=='tiket-keluar'?'active':'' ?>">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Tiket Keluar</span>
            </a>

        <?php endif; ?>
    </nav>

    <div class="grid grid-cols-3 m-3 text-center gap-2 p-1 rounded-xl border border-border bg-surface">
        <button onclick="setTheme('light')" class="theme-btn">
            <i class="fa-solid fa-sun"></i>
        </button>

        <button onclick="setTheme('dark')" class="theme-btn">
            <i class="fa-solid fa-moon"></i>
        </button>

        <button onclick="setTheme('default')" class="theme-btn">
            <i class="fa-solid fa-circle"></i>
        </button>
    </div>

    <div class="
        px-6 py-4
        border-t border-border">
        <div class="text-sm text-muted">
            <?= ucfirst($_SESSION['user']['nama_lengkap']); ?>
            <span class="text-primary">(<?= ucfirst($_SESSION['user']['role']) ?>)</span>
        </div>

        <a href="?action=logout"
           class="
            mt-3 flex items-center gap-2
            bg-soft-danger p-2 rounded-xl border border-danger
            hover:opacity-80
            transition">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
    </div>

</aside>

<header id="dashTopbar" class="lg:hidden fixed top-0 left-0 right-0 z-100 bg-bg/80 backdrop-blur border-b border-border transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 lg:px-20 h-16 flex items-center justify-between">
        <div class="font-extrabold text-xl text-primary">
            SIMAKIR
        </div>

        <button id="dashMenuBtn"
            class="md:hidden text-2xl">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</header>

<div id="dashOverlay"
    class="fixed inset-0 bg-black/40 z-200 opacity-0 pointer-events-none transition"></div>
</div>

<aside id="dashMobileSidebar"
    class="fixed top-0 left-0 h-full w-72 bg-bg border-r border-border
            z-210 -translate-x-full pointer-events-none rounded-r-2xl
            transition-transform duration-300">

    <div class="p-6 flex justify-between items-center border-b border-border">
        <span class="font-bold text-lg text-primary">SIMAKIR</span>
        <button id="dashCloseBtn" class="text-xl">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="p-6 flex flex-col gap-4 text-sm">
        <a href="#" data-page="dashboard" onclick="loadPage(event,'dashboard')"
        class="mobile-link <?= $current=='index'?'active':'' ?>">
            Dashboard
        </a>
        <?php if($_SESSION['user']['role']==='admin'): ?>
            <a href="#" data-page="manage-user" onclick="loadPage(event,'manage-user')"
            class="mobile-link <?= $current=='manage-user'?'active':'' ?>">
                Manage User
            </a>
            <a href="#" data-page="manage-tarif" onclick="loadPage(event,'manage-tarif')"
            class="mobile-link <?= $current=='manage-tarif'?'active':'' ?>">
                Manage Tarif
            </a>
        <?php else: ?>
            <a href="#" data-page="tiket-masuk" onclick="loadPage(event,'tiket-masuk')"
            class="mobile-link <?= $current=='tiket-masuk'?'active':'' ?>">
                Tiket Masuk
            </a>

            <a href="#" data-page="tiket-keluar" onclick="loadPage(event,'tiket-keluar')"
            class="mobile-link <?= $current=='tiket-keluar'?'active':'' ?>">
                Tiket Keluar
            </a>
        <?php endif; ?>
            <a href="?action=logout"
            class="mt-4 px-4 py-2 bg-danger text-bg rounded-lg font-semibold text-center">
            Logout
            </a>
    </div>

</aside>
<?php endif; ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const openBtn  = document.getElementById('dashMenuBtn');
    const closeBtn = document.getElementById('dashCloseBtn');
    const sidebar  = document.getElementById('dashMobileSidebar');
    const overlay  = document.getElementById('dashOverlay');
    const topbar   = document.getElementById('dashTopbar');

    function openSidebar(){
        sidebar.classList.remove('-translate-x-full','pointer-events-none');
        overlay.classList.remove('opacity-0','pointer-events-none');
    }

    function closeSidebar(){
        sidebar.classList.add('-translate-x-full','pointer-events-none');
        overlay.classList.add('opacity-0','pointer-events-none');
    }

    openBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

    if (!topbar) return;

    let lastScrollY = window.scrollY;
    const threshold = 10;

    window.addEventListener('scroll', () => {
        const currentScroll = window.scrollY;
        if (!sidebar.classList.contains('-translate-x-full')) return;

        if (Math.abs(currentScroll - lastScrollY) < threshold) return;

        if (currentScroll > lastScrollY && currentScroll > 60) {
            topbar.classList.add('-translate-y-full');
        } else {
            topbar.classList.remove('-translate-y-full');
        }
        if (currentScroll <= 5) {
            topbar.classList.remove('-translate-y-full');
        }

        lastScrollY = currentScroll;
    });
});
</script>