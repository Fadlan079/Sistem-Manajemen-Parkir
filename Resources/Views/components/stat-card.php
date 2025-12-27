<div class="relative bg-slate-800 border border-slate-700 p-4 sm:p-6 rounded-xl shadow-lg overflow-hidden
            transition-all duration-300 hover:-translate-y-2 <?= $color['shadow'] ?> flex flex-col sm:flex-row items-center gap-4 sm:gap-6
            aspect-square sm:aspect-auto">
    
    <!-- Icon Kiri -->
    <i class="fa-solid <?= $icon ?> <?= $color['text'] ?> text-3xl sm:text-4xl flex-shrink-0"></i>

    <!-- Text -->
    <div class="flex-1 text-center sm:text-left">
        <p class="text-slate-400 text-xs sm:text-sm"><?= $label ?></p>
        <h3 class="text-lg sm:text-2xl font-bold"><?= $value ?></h3>
    </div>

    <!-- Icon besar belakang -->
    <i class="fa-solid <?= $icon ?> absolute right-2 sm:right-4 top-1 sm:top-2 text-5xl sm:text-7xl <?= $color['muted'] ?> pointer-events-none"></i>
</div>
