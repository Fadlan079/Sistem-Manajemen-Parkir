<nav id="navbar" class="fixed top-0 left-0 w-full z-50 bg-slate-800 shadow-lg border-b border-slate-700 transition-transform duration-300">

    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- KIRI: Nama Sistem -->
         <div class="flex justify-center itesm">
            <i class="fa fa-car"></i>

            <h1 class="text-2xl font-bold text-cyan-500">Sistem Parkir</h1>
         </div>
        

        <!-- TENGAH: MENU -->
        <ul class="flex items-center gap-6 text-slate-300 font-medium">

            <?php if(isset($_SESSION['user'])): ?>

                <?php if($_SESSION['user']['role'] === 'admin'): ?>

                    <!-- MENU ADMIN -->
                    <li>
                        <a href="?action=index" 
                            class="hover:text-cyan-400 transition <?= $current=='index' ? 'border-b-2 border-cyan-400 text-cyan-400' : '' ?>">
                            <i class="fa-solid fa-house"></i> Home
                        </a>
                    </li>

                    <li>
                        <a href="?action=manage-user" 
                            class="hover:text-cyan-400 transition <?= $current=='manage-user' ? 'border-b-2 border-cyan-400 text-cyan-400' : '' ?>">
                            <i class="fa-solid fa-users"></i> Manage User
                        </a>
                    </li>

                    <li>
                        <a href="?action=manage-tarif" 
                            class="hover:text-cyan-400 transition <?= $current=='manage-tarif' ? 'border-b-2 border-cyan-400 text-cyan-400' : '' ?>">
                            <i class="fa-solid fa-tags"></i> Manage Tarif
                        </a>
                    </li>

                    
                <?php elseif($_SESSION['user']['role'] === 'petugas'): ?>

                    <!-- MENU PETUGAS -->
                    <li>
                        <a href="?action=index" 
                            class="hover:text-cyan-400 transition <?= $current=='index' ? 'border-b-2 border-cyan-400 text-cyan-400' : '' ?>">
                            <i class="fa-solid fa-house"></i> Home
                        </a>
                    </li>

                    <li>
                        <a href="?action=tiket-masuk" 
                            class="hover:text-cyan-400 transition <?= $current=='tiket-masuk' ? 'border-b-2 border-cyan-400 text-cyan-400' : '' ?>">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i> Tiket Masuk
                        </a>
                    </li>

                    <li>
                        <a href="?action=tiket-keluar" 
                            class="hover:text-cyan-400 transition <?= $current=='tiket-keluar' ? 'border-b-2 border-cyan-400 text-cyan-400' : '' ?>">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Tiket Keluar
                        </a>
                    </li>

                    <li>
                        <a href="?action=transaksi" 
                            class="hover:text-cyan-400 transition <?= $current=='transaksi' ? 'border-b-2 border-cyan-400 text-cyan-400' : '' ?>">
                            <i class="fa-solid fa-receipt"></i> Transaksi
                        </a>
                    </li>

                <?php endif; ?>

            <?php endif; ?>

        </ul>

        <!-- KANAN: INFO USER & LOGIN/LOGOUT -->
        <div class="flex gap-6 items-center">

            <?php if(isset($_SESSION['user'])): ?>

                <span class="text-slate-300">
                    <i class="fa-solid fa-user text-cyan-400"></i>
                    <?= ucfirst($_SESSION['user']['nama_lengkap']); ?>
                    <b class="text-cyan-400">(<?= ucfirst($_SESSION['user']['role'])?>)</b>
                </span>

                <a href="?action=logout"
                class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-white transition">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>

            <?php else: ?>

                <a href="?action=login"
                class="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 rounded-lg text-slate-900 font-semibold transition">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </a>

            <?php endif; ?>

        </div>

    </div>
</nav>
<script>
let lastScroll = 0;
const navbar = document.getElementById("navbar");

window.addEventListener("scroll", () => {
    const current = window.scrollY;

    if (current > lastScroll && current > 50) {
        // Scroll TURUN → nav hilang
        navbar.style.transform = "translateY(-100%)";
    } else {
        // Scroll NAIK → nav muncul
        navbar.style.transform = "translateY(0)";
    }

    lastScroll = current;
});
</script>
