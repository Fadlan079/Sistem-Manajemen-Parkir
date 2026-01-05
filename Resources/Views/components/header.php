<?php if(isset($_SESSION['user'])): ?>
<aside class="
    fixed left-0 top-0 h-screen w-55
    bg-surface border-r border-border
    flex-col
    hidden md:flex
    z-200 rounded-r-2xl shadow-lg
">

    <!-- LOGO -->
    <div class="
        flex items-center gap-3
        px-6 py-5
        border-b border-border
    ">
        <div class="
            w-10 h-10 flex items-center justify-center
            rounded-xl
            bg-primary/10
            border border-primary
        ">
            <i class="fa fa-car text-primary"></i>
        </div>

        <span class="text-lg font-bold text-primary">
            SIMA<span class="text-text/70">KIR</span>
        </span>
    </div>

    <!-- MENU -->
    <nav class="flex-1 px-4 py-6 space-y-1 text-text">

        <!-- DASHBOARD -->
        <a href="?action=index"
           class="sidebar-link <?= $current=='index'?'active':'' ?>">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>

        <?php if($_SESSION['user']['role']==='admin'): ?>

            <a href="?action=manage-user"
               class="sidebar-link <?= $current=='manage-user'?'active':'' ?>">
                <i class="fa-solid fa-users"></i>
                <span>Manage User</span>
            </a>

            <a href="?action=manage-tarif"
               class="sidebar-link <?= $current=='manage-tarif'?'active':'' ?>">
                <i class="fa-solid fa-tags"></i>
                <span>Manage Tarif</span>
            </a>

        <?php else: ?>

            <a href="?action=tiket-masuk"
               class="sidebar-link <?= $current=='tiket-masuk'?'active':'' ?>">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                <span>Tiket Masuk</span>
            </a>

            <a href="?action=tiket-keluar"
               class="sidebar-link <?= $current=='tiket-keluar'?'active':'' ?>">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Tiket Keluar</span>
            </a>

        <?php endif; ?>

    </nav>
    <a href="?action=manage-user"
    class="
        sidebar-pref
        <?= $current=='manage-user' ? 'active' : '' ?>
    ">
        <i class="fa-solid fa-sliders"></i>
        <span>Preference</span>
    </a>


<div class="flex items-center gap-2 p-1 rounded-xl border border-border bg-surface">
    <button onclick="setTheme('light')" class="theme-btn">
        <i class="fa-solid fa-sun"></i>
        <span class="hidden sm:inline">Light</span>
    </button>

    <button onclick="setTheme('dark')" class="theme-btn">
        <i class="fa-solid fa-moon"></i>
        <span class="hidden sm:inline">Dark</span>
    </button>

    <button onclick="setTheme('default')" class="theme-btn">
        <i class="fa-solid fa-palette"></i>
        <span class="hidden sm:inline">Default</span>
    </button>
</div>


    <!-- USER INFO -->
    <div class="
        px-6 py-4
        border-t border-border
    ">
        <div class="text-sm text-muted">
            <?= ucfirst($_SESSION['user']['nama_lengkap']); ?>
            <span class="text-primary">(<?= $_SESSION['user']['role'] ?>)</span>
        </div>

        <a href="?action=logout"
           class="
            mt-3 flex items-center gap-2
            text-danger
            hover:opacity-80
            transition
           ">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
    </div>

</aside>
<?php endif; ?>




<div id="mobileMenu"
     class="fixed inset-0 bg-slate-900/95 z-50 transform -translate-x-full transition-transform duration-300">

    <div class="p-6 border-b border-slate-700 flex justify-between items-center">
        <?php if(isset($_SESSION['user'])): ?>
            <div>
                <p class="text-slate-400 text-sm">Login sebagai</p>
                <h2 class="text-cyan-400 text-lg font-semibold">
                    <?= ucfirst($_SESSION['user']['nama_lengkap']); ?>
                </h2>
                <span class="text-xs text-slate-400">
                    <?= ucfirst($_SESSION['user']['role']); ?>
                </span>
            </div>
        <?php else: ?>
            <h2 class="text-cyan-400 text-xl font-bold">Menu</h2>
        <?php endif; ?>

        <button id="closeMenu" class="text-slate-300 text-2xl">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <ul class="flex flex-col mt-8 gap-3 px-6 text-slate-200">

        <?php if(isset($_SESSION['user'])): ?>
            <?php if($_SESSION['user']['role'] === 'admin'): ?>

                <li>
                    <a href="?action=index"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg
                       <?= $current=='index'
                            ? 'bg-cyan-500/10 text-cyan-400 border-l-4 border-cyan-400'
                            : 'hover:bg-slate-800' ?>">
                        <i class="fa-solid fa-house"></i> Home
                    </a>
                </li>

                <li>
                    <a href="?action=manage-user"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg
                       <?= $current=='manage-user'
                            ? 'bg-cyan-500/10 text-cyan-400 border-l-4 border-cyan-400'
                            : 'hover:bg-slate-800' ?>">
                        <i class="fa-solid fa-users"></i> Manage User
                    </a>
                </li>

                <li>
                    <a href="?action=manage-tarif"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg
                       <?= $current=='manage-tarif'
                            ? 'bg-cyan-500/10 text-cyan-400 border-l-4 border-cyan-400'
                            : 'hover:bg-slate-800' ?>">
                        <i class="fa-solid fa-tags"></i> Manage Tarif
                    </a>
                </li>

            <?php else: ?>

                <li>
                    <a href="?action=index"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg
                       <?= $current=='index'
                            ? 'bg-cyan-500/10 text-cyan-400 border-l-4 border-cyan-400'
                            : 'hover:bg-slate-800' ?>">
                        <i class="fa-solid fa-house"></i> Home
                    </a>
                </li>

                <li>
                    <a href="?action=tiket-masuk"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg
                       <?= $current=='tiket-masuk'
                            ? 'bg-cyan-500/10 text-cyan-400 border-l-4 border-cyan-400'
                            : 'hover:bg-slate-800' ?>">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Tiket Masuk
                    </a>
                </li>

                <li>
                    <a href="?action=tiket-keluar"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg
                       <?= $current=='tiket-keluar'
                            ? 'bg-cyan-500/10 text-cyan-400 border-l-4 border-cyan-400'
                            : 'hover:bg-slate-800' ?>">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Tiket Keluar
                    </a>
                </li>

            <?php endif; ?>

            <li class="mt-8 pt-4 border-t border-slate-700">
                <a href="?action=logout"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                          text-red-400 hover:bg-red-500/10">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </li>

        <?php else: ?>
            <li>
                <a href="?action=login"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>

<script>
let lastScroll = 0;
const navbar = document.getElementById("navbar");
const menuBtn = document.getElementById("menuBtn");
const mobileMenu = document.getElementById("mobileMenu");
const closeMenuBtn = document.getElementById("closeMenu");

window.addEventListener("scroll", () => {
    const current = window.scrollY;
    navbar.style.transform =
        (current > lastScroll && current > 50)
            ? "translateY(-100%)"
            : "translateY(0)";
    lastScroll = current;
});

menuBtn.addEventListener("click", () => {
    mobileMenu.classList.remove("-translate-x-full");
});

closeMenuBtn.addEventListener("click", () => {
    mobileMenu.classList.add("-translate-x-full");
});

mobileMenu.addEventListener("click", (e) => {
    if (e.target === mobileMenu) {
        mobileMenu.classList.add("-translate-x-full");
    }
});
</script>