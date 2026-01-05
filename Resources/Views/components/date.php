<?php 
$hari  = date('l'); 
$tgl   = date('d'); 
$bulan = date('F'); 
$tahun = date('Y'); 

$hariIndo = [     
    'Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa',
    'Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu' 
];

$bulanIndo = [     
    'January'=>'Jan','February'=>'Feb','March'=>'Mar','April'=>'Apr',
    'May'=>'Mei','June'=>'Jun','July'=>'Jul','August'=>'Agu',
    'September'=>'Sep','October'=>'Okt','November'=>'Nov','December'=>'Des' 
];
?>  

<div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 px-4 sm:px-5 py-2
            bg-surface border border-border
            rounded-xl shadow-sm">

    <!-- Icon -->
    <div class="w-9 h-9 flex items-center justify-center
                rounded-lg bg-primary/10 shrink-0">
        <i class="fa-solid fa-calendar-day text-primary text-sm sm:text-base"></i>
    </div>

    <!-- Text -->
    <div class="leading-tight text-center sm:text-left">
        <p class="text-[10px] sm:text-xs text-muted">
            <?= $hariIndo[$hari]; ?>
        </p>
        <p class="text-xs sm:text-sm font-semibold text-text">
            <?= $tgl ?> <?= $bulanIndo[$bulan] ?> <?= $tahun ?>, 
            <span id="jam"></span> <!-- jam akan diisi JS -->
        </p>
    </div>
</div>

<script>
function updateJam() {
    const now = new Date();
    let hours = now.getHours();
    let menit = now.getMinutes().toString().padStart(2, '0');
    let detik = now.getSeconds().toString().padStart(2, '0');
    
    // AM/PM
    let ampm = hours >= 12 ? 'PM' : 'AM';
    
    // format 12 jam
    hours = hours % 12;
    hours = hours ? hours : 12;
    hours = hours.toString().padStart(2, '0');
    
    document.getElementById('jam').textContent = `${hours}:${menit}:${detik} ${ampm}`;
}

// jalankan pertama kali
updateJam();
// update setiap detik
setInterval(updateJam, 1000);
</script>
