<nav id="navbar" class="fixed top-0 left-0 w-full z-50 bg-slate-800 shadow-lg border-b border-slate-700 transition-transform duration-300">

    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- Logo -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 flex justify-center items-center border-2 border-cyan-400 rounded-full">
                <i class="fa fa-car text-neutral-400 text-lg"></i>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-cyan-500">
                Sistem <span class="text-neutral-400">Parkir</span>
            </h1>
        </div>

        <!-- Hamburger Button Mobile -->
        <button id="menuBtn" class="lg:hidden text-cyan-400 text-2xl">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Menu Desktop -->
        <ul class="hidden lg:flex items-center gap-6 text-slate-300 font-medium">
            <?php if(isset($_SESSION['user'])): ?>
                <?php if($_SESSION['user']['role'] === 'admin'): ?>
                    <li><a class="hover:text-cyan-400 transition <?= $current=='index'?'border-b-2 border-cyan-400 text-cyan-400':'' ?>" href="?action=index">
                        <i class="fa-solid fa-house"></i> Home
                    </a></li>
                    <li><a class="hover:text-cyan-400 transition <?= $current=='manage-user'?'border-b-2 border-cyan-400 text-cyan-400':'' ?>" href="?action=manage-user">
                        <i class="fa-solid fa-users"></i> Manage User
                    </a></li>
                    <li><a class="hover:text-cyan-400 transition <?= $current=='manage-tarif'?'border-b-2 border-cyan-400 text-cyan-400':'' ?>" href="?action=manage-tarif">
                        <i class="fa-solid fa-tags"></i> Manage Tarif
                    </a></li>
                <?php else: ?>
                    <li><a class="hover:text-cyan-400 transition <?= $current=='index'?'border-b-2 border-cyan-400 text-cyan-400':'' ?>" href="?action=index">
                        <i class="fa-solid fa-house"></i> Home
                    </a></li>
                    <li><a class="hover:text-cyan-400 transition <?= $current=='tiket-masuk'?'border-b-2 border-cyan-400 text-cyan-400':'' ?>" href="?action=tiket-masuk">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Tiket Masuk
                    </a></li>
                    <li><a class="hover:text-cyan-400 transition <?= $current=='tiket-keluar'?'border-b-2 border-cyan-400 text-cyan-400':'' ?>" href="?action=tiket-keluar">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Tiket Keluar
                    </a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>

        <!-- User Info Desktop -->
        <div class="hidden lg:flex gap-6 items-center">
            <?php if(isset($_SESSION['user'])): ?>
                <span class="text-slate-300">
                    <i class="fa-solid fa-user text-cyan-400"></i>
                    <?= ucfirst($_SESSION['user']['nama_lengkap']); ?>
                    <b class="text-cyan-400">(<?= ucfirst($_SESSION['user']['role'])?>)</b>
                </span>
                <a href="?action=logout" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-white transition">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            <?php else: ?>
                <a href="?action=login" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 rounded-lg text-slate-900 font-semibold transition">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </a>
            <?php endif; ?>
        </div>

    </div>
</nav>

<!-- Overlay Menu Mobile -->
<div id="mobileMenu" class="fixed inset-0 bg-slate-900/95 z-50 transform -translate-x-full transition-transform duration-300 flex flex-col">
    
    <div class="flex justify-between items-center p-6 border-b border-slate-700">
        <h2 class="text-cyan-400 text-xl font-bold">Menu</h2>
        <button id="closeMenu" class="text-slate-300 text-2xl">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <ul class="flex flex-col mt-4 gap-6 text-lg text-slate-200 px-6">
        <?php if(isset($_SESSION['user'])): ?>
            <?php if($_SESSION['user']['role'] === 'admin'): ?>
                <li><a href="?action=index" class="hover:text-cyan-400"><i class="fa-solid fa-house mr-2"></i>Home</a></li>
                <li><a href="?action=manage-user" class="hover:text-cyan-400"><i class="fa-solid fa-users mr-2"></i>Manage User</a></li>
                <li><a href="?action=manage-tarif" class="hover:text-cyan-400"><i class="fa-solid fa-tags mr-2"></i>Manage Tarif</a></li>
            <?php else: ?>
                <li><a href="?action=index" class="hover:text-cyan-400"><i class="fa-solid fa-house mr-2"></i>Home</a></li>
                <li><a href="?action=tiket-masuk" class="hover:text-cyan-400"><i class="fa-solid fa-arrow-right-to-bracket mr-2"></i>Tiket Masuk</a></li>
                <li><a href="?action=tiket-keluar" class="hover:text-cyan-400"><i class="fa-solid fa-arrow-right-from-bracket mr-2"></i>Tiket Keluar</a></li>
            <?php endif; ?>
            <li class="mt-6 border-t border-slate-700 pt-4">
                <a href="?action=logout" class="block text-red-400">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                </a>
            </li>
        <?php else: ?>
            <li><a href="?action=login" class="hover:text-cyan-400"><i class="fa-solid fa-right-to-bracket mr-2"></i>Login</a></li>
        <?php endif; ?>
    </ul>
</div>
<script>
    let lastScroll = 0;
const navbar = document.getElementById("navbar");
const menuBtn = document.getElementById("menuBtn");
const mobileMenu = document.getElementById("mobileMenu");
const closeMenuBtn = document.getElementById("closeMenu");

// Scroll hide/show navbar
window.addEventListener("scroll", () => {
    const current = window.scrollY;
    navbar.style.transform = (current > lastScroll && current > 50) 
        ? "translateY(-100%)" 
        : "translateY(0)";
    lastScroll = current;
});

// Hamburger menu open
menuBtn.addEventListener("click", () => {
    mobileMenu.classList.remove("-translate-x-full");
});

// Hamburger menu close
closeMenuBtn.addEventListener("click", () => {
    mobileMenu.classList.add("-translate-x-full");
});

// Klik overlay di luar menu untuk close
mobileMenu.addEventListener("click", (e) => {
    if(e.target === mobileMenu){
        mobileMenu.classList.add("-translate-x-full");
    }
});

</script>