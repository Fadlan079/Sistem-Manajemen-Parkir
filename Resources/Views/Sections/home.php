<section id="home" class="relative pt-24 pb-32 bg-linear-to-br from-primary/10 via-surface/50 to-bg">
    <div class="max-w-7xl mx-auto px-6 lg:px-20 flex flex-col-reverse lg:flex-row items-center gap-16">

        <div class="lg:w-1/2 lg:text-left space-y-6">
            <b class="sr-only">Sistem Manajemen Parkir</b>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold aria-hidden:">
                <span class="text-primary">Si</span><span class="text-muted">stem</span><br>
                <span class="text-primary">Ma</span><span class="text-muted">najemen</span><br>
                <span class="text-muted">Par</span><span class="text-primary">kir</span>
            </h1>

            <p class="text-muted text-lg sm:text-xl max-w-md lg:max-w-xl mx-auto lg:mx-0">
                Kelola kendaraan masuk dan keluar, transaksi, barcode, serta laporan terkini secara mudah.
            </p>
            <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 sm:gap-6">
                <a href="?action=login"
                    class="px-6 py-3 bg-success text-bg font-bold rounded-xl transition shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
                </a>
                <a href="#fitur"
                    class="px-6 py-3 border border-border hover:border-primary rounded-xl text-muted transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-eye"></i> Lihat Fitur
                </a>
            </div>
        </div>

        <div class="lg:w-1/2 relative hidden lg:flex justify-center items-center">
            <div class="absolute w-64 h-64 bg-primary/20 blur-3xl rounded-full"></div>
            
            <div class="grid grid-cols-2 gap-6 relative z-10">
                <div class="bg-surface border border-border p-6 rounded-xl text-center hover:shadow-primary/30 hover:-translate-y-1 transition">
                    <i class="fa-solid fa-ticket text-primary text-3xl mb-2"></i>
                    <p class="text-sm text-muted">Cetak Tiket Instan</p>
                </div>
                <div class="bg-surface border border-border p-6 rounded-xl text-center hover:shadow-purple-300/30 hover:-translate-y-1 transition">
                    <i class="fa-solid fa-barcode text-purple-400 text-3xl mb-2"></i>
                    <p class="text-sm text-muted">Barcode Unik</p>
                </div>
                <div class="bg-surface border border-border p-6 rounded-xl text-center hover:shadow-success hover:-translate-y-1 transition">
                    <i class="fa-solid fa-money-bill-wave text-success text-3xl mb-2"></i>
                    <p class="text-sm text-muted">Transaksi Cepat</p>
                </div>
                <div class="bg-surface border border-border p-6 rounded-xl text-center hover:shadow-warning hover:-translate-y-1 transition">
                    <i class="fa-solid fa-chart-line text-warning text-3xl mb-2"></i>
                    <p class="text-sm text-muted">Laporan Terkini</p>
                </div>
            </div>
        </div>
    </div>
</section>