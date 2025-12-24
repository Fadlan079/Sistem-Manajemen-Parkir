<?php
function alert($type, $message) {
    $styles = [
        'success' => 'bg-green-600/80 text-white border-green-700',
        'error'   => 'bg-red-600/80 text-white border-red-700',
        'warning' => 'bg-yellow-500/80 text-white border-yellow-600',
        'info'    => 'bg-blue-600/80 text-white border-blue-700',
    ];

    $icons = [
        'success' => 'fa-circle-check',
        'error'   => 'fa-circle-xmark',
        'warning' => 'fa-triangle-exclamation',
        'info'    => 'fa-circle-info',
    ];

    $style = $styles[$type] ?? $styles['info'];
    $icon  = $icons[$type] ?? $icons['info'];
?>
    <div class="alert fixed top-20 left-1/2 transform -translate-x-1/2 p-4 mb-5 <?= $style ?> border rounded-lg flex items-center shadow-lg backdrop-blur-sm opacity-0 translate-y-[-50px] z-50" id="flashAlert">
        <i class="fa-solid <?= $icon ?> mr-2 text-xl"></i>
        <span class="font-medium"><?= $message ?></span>
    </div>

    <script>
        const alertEl = document.getElementById('flashAlert');
        if(alertEl){

            requestAnimationFrame(() => {
                alertEl.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                alertEl.style.opacity = '1';
                alertEl.style.transform = 'translateY(0)';
            });


            setTimeout(() => {
                alertEl.style.opacity = '0';
                alertEl.style.transform = 'translateY(-50px)';
                setTimeout(() => alertEl.remove(), 500);
            }, 3000);
        }
    </script>
<?php
}
?>
