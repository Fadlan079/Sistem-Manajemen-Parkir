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

<div class="relative flex gap-4 items-center  px-5 py-4
            bg-surface border border-border
            rounded-2xl shadow-sm overflow-hidden">

    <div class="absolute left-0 top-0 h-full w-1.5 bg-primary opacity-80"></div>

    <div class="flex flex-col items-center justify-center
                w-11 h-11 rounded-xl
                bg-soft-primary shrink-0">
        <span class="text-xl font-bold leading-none">
            <?= $tgl ?>
        </span>
        <span class="text-[10px] uppercase tracking-wide">
            <?= $bulanIndo[$bulan] ?>
        </span>
    </div>

    <div class="leading-tight">
        <p class="text-sm font-semibold text-text">
            <?= $hariIndo[$hari]; ?>
        </p>
        <p class="text-xs text-muted">
            <?= $tahun ?>
        </p>
    </div>
</div>