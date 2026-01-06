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

<div class="flex items-center gap-4 px-4 sm:px-5 py-3
            bg-surface border border-border
            rounded-2xl shadow-sm">

    <div class="w-11 h-11 flex items-center justify-center
                rounded-full bg-soft-primary shrink-0">
        <span class="text-primary font-bold text-lg sm:text-xl">
            <?= $tgl ?>
        </span>
    </div>

    <div class="leading-tight">
        <p class="text-md sm:text-base font-semibold text-text">
            <?= $hariIndo[$hari]; ?>
        </p>

        <p class="text-xs sm:text-sm text-muted">
            <?= $bulanIndo[$bulan] ?> <?= $tahun ?> • 
            <span id="jam"></span>
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
