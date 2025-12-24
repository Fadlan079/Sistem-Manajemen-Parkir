<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Parkir Modern</title>
    <link rel="stylesheet" href="Css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-900 text-white min-h-screen antialiased">
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white">

        <div class="pt-24 pb-20 px-6 sm:px-10 lg:px-20">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2 text-center lg:text-left space-y-6">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-cyan-400">
                        Sistem Manajemen Parkir
                    </h1>

                    <p class="text-slate-300 text-base sm:text-lg leading-relaxed max-w-md lg:max-w-2xl mx-auto lg:mx-0">
                        Kelola kendaraan masuk & keluar secara otomatis, lengkap dengan barcode, 
                        transaksi real-time, dan laporan profesional untuk usaha parkirmu.
                    </p>

                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 sm:gap-6">
                        <a href="?action=login"
                        class="px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-slate-900 font-bold rounded-xl transition shadow-md">
                            <i class="fa-solid fa-right-to-bracket mr-2"></i> Masuk Sekarang
                        </a>

                        <a href="#fitur"
                        class="px-6 py-3 border border-slate-600 hover:border-cyan-400 rounded-xl text-slate-300 transition">
                            Lihat Fitur
                        </a>
                    </div>
                </div>

                <div class="hidden lg:flex justify-center lg:w-1/2 relative">
                    <div class="absolute w-64 h-64 bg-cyan-500/20 blur-3xl rounded-full"></div>

                    <div class="grid grid-cols-2 gap-6 relative z-10">
                        <div class="bg-slate-800 border border-slate-700 p-6 rounded-xl text-center">
                            <i class="fa-solid fa-ticket text-cyan-400 text-3xl mb-2"></i>
                            <p class="text-sm text-slate-300">Tiket Otomatis</p>
                        </div>

                        <div class="bg-slate-800 border border-slate-700 p-6 rounded-xl text-center">
                            <i class="fa-solid fa-barcode text-purple-400 text-3xl mb-2"></i>
                            <p class="text-sm text-slate-300">Barcode Unik</p>
                        </div>

                        <div class="bg-slate-800 border border-slate-700 p-6 rounded-xl text-center">
                            <i class="fa-solid fa-money-bill-wave text-green-400 text-3xl mb-2"></i>
                            <p class="text-sm text-slate-300">Transaksi</p>
                        </div>

                        <div class="bg-slate-800 border border-slate-700 p-6 rounded-xl text-center">
                            <i class="fa-solid fa-chart-line text-amber-400 text-3xl mb-2"></i>
                            <p class="text-sm text-slate-300">Laporan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="fitur" class="pb-24 px-6 sm:px-10 lg:px-20">
            <div class="max-w-7xl mx-auto text-center space-y-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-cyan-400">
                    Fitur Unggulan
                </h2>

                <p class="text-slate-400 text-base sm:text-lg leading-relaxed">
                    Semua yang kamu butuhkan untuk sistem parkir modern
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                    <div class="bg-slate-800 border border-slate-700 p-6 rounded-xl hover:-translate-y-1 transition shadow-lg hover:shadow-cyan-500/20">
                        <i class="fa-solid fa-ticket text-cyan-400 text-3xl mb-2"></i>
                        <h3 class="text-lg font-semibold mb-1">Tiket Otomatis</h3>
                        <p class="text-slate-300 text-sm leading-relaxed">
                            Setiap kendaraan masuk langsung mendapatkan tiket barcode unik.
                        </p>
                    </div>

                    <div class="bg-slate-800 border border-slate-700 p-6 rounded-xl hover:-translate-y-1 transition shadow-lg hover:shadow-green-500/20">
                        <i class="fa-solid fa-cash-register text-green-400 text-3xl mb-2"></i>
                        <h3 class="text-lg font-semibold mb-1">Transaksi Cepat</h3>
                        <p class="text-slate-300 text-sm leading-relaxed">
                            Perhitungan tarif otomatis dan status pembayaran langsung tercatat.
                        </p>
                    </div>

                    <div class="bg-slate-800 border border-slate-700 p-6 rounded-xl hover:-translate-y-1 transition shadow-lg hover:shadow-purple-500/20">
                        <i class="fa-solid fa-chart-pie text-purple-400 text-3xl mb-2"></i>
                        <h3 class="text-lg font-semibold mb-1">Laporan Real-time</h3>
                        <p class="text-slate-300 text-sm leading-relaxed">
                            Pendapatan, kendaraan masuk-keluar, dan statistik ditampilkan langsung.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>