<div id="globalModal"
     class="group fixed inset-0 z-50 hidden
            items-center justify-center
            bg-black/40 backdrop-blur-sm">

    <div
        class="relative w-full max-w-md
               bg-surface border border-border
               rounded-2xl shadow-lg
               p-6
               transform scale-95 opacity-0
               transition-all duration-300 ease-out
               group-[.flex]:scale-100
               group-[.flex]:opacity-100">

        <button
            onclick="closeModal()"
            class="absolute top-3 right-3
                   w-8 h-8 flex items-center justify-center
                   rounded-full
                   text-muted
                   hover:bg-border hover:text-text
                   transition">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>

        <div id="modalContent"></div>
    </div>
</div>
