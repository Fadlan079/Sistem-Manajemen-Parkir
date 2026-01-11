<header id="404Topbar" class="fixed top-0 left-0 right-0 z-100 bg-bg backdrop-blur border-b border-border transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 lg:px-20 h-16 flex items-center justify-between">
        <div class="font-extrabold text-xl text-primary">
            SIMAKIR
        </div>

        <div class="hidden md:flex items-center gap-8 text-sm">
            <a href="?action=index" class="nav-link">Beranda</a>
            <?php if(isset($_SESSION['user'])): ?>
                <a href="?action=logout"
                    class="px-4 py-2 bg-danger text-bg rounded-lg font-semibold">
                    Logout
                </a>
            <?php else:?>
                <a href="?action=login"
                    class="px-4 py-2 bg-success text-bg rounded-lg font-semibold">
                    Login
                </a>
            <?php endif?>  
            <button id="themeToggle"
                class="w-10 h-10 rounded-lg border border-border
                        bg-surface flex items-center justify-center
                        hover:bg-bg transition">
                <i id="themeIcon" class="fa-solid fa-moon"></i>
            </button>
        </div>

        <button id="404MenuBtn"
            class="md:hidden text-2xl">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</header>

<div id="404Overlay"
    class="fixed inset-0 bg-black/40 z-200 opacity-0 pointer-events-none transition"></div>
</div>

<aside id="404MobileSidebar"
    class="fixed top-0 left-0 h-full w-72 bg-bg border-r border-border
            z-210 -translate-x-full pointer-events-none rounded-r-2xl
            transition-transform duration-300">

    <div class="p-6 flex justify-between items-center border-b border-border">
        <span class="font-bold text-lg text-primary">SIMAKIR</span>
        <button id="404CloseBtn" class="text-xl">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="p-6 flex flex-col gap-4 text-sm">
        <?php if(isset($_SESSION['user'])): ?>
            <a href="?action=logout"
            class="mt-4 px-4 py-2 bg-danger text-bg rounded-lg font-semibold text-center">
            Logout
            </a>
        <?php else:?>
            <a href="?action=login"
            class="mt-4 px-4 py-2 bg-success text-bg rounded-lg font-semibold text-center">
            Login
            </a>  
        <?php endif?>    
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const openBtn  = document.getElementById('404MenuBtn');
    const closeBtn = document.getElementById('404CloseBtn');
    const sidebar  = document.getElementById('404MobileSidebar');
    const overlay  = document.getElementById('404Overlay');
    const topbar   = document.getElementById('404Topbar');

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