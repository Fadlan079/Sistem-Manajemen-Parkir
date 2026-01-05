<div class="
    relative
    bg-surface border border-border
    px-4 py-3
    rounded-xl
    shadow-md <?= $color['shadow'] ?>
    flex flex-col sm:flex-row
    items-center gap-2 sm:gap-4
    transition-all duration-300
    hover:-translate-y-1
">

    <!-- Icon utama -->
    <div class="
        flex items-center justify-center
        w-10 h-10
        rounded-lg
        <?= $color['muted'] ?>
    ">
        <i class="fa-solid <?= $icon ?> <?= $color['text'] ?> text-lg"></i>
    </div>

    <!-- Text -->
    <div class="flex-1 leading-tight text-center sm:text-left">
        <p class="text-muted text-[11px] sm:text-xs">
            <?= $label ?>
        </p>
        <h3 class="text-sm sm:text-base font-semibold text-text">
            <?= $value ?>
        </h3>
    </div>

    <!-- Icon dekoratif (desktop only) -->
    <i class="
        hidden sm:block
        fa-solid <?= $icon ?>
        absolute right-3 top-1/2 -translate-y-1/2
        text-4xl
        <?= $color['muted'] ?>
        opacity-40
        pointer-events-none
    "></i>
</div>
