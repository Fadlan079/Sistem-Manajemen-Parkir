<?php
function alert($type, $message) {
    $styles = [
        'success' => 'bg-green-600/80 text-green-400 border-green-600',
        'error'   => 'bg-red-600/20 text-red-400 border-red-600',
        'warning' => 'bg-yellow-600/20 text-yellow-400 border-yellow-600',
        'info'    => 'bg-blue-600/20 text-blue-400 border-blue-600',
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
    <div class="alert fixed top-20 left-1/2 transform -translate-x-1/2 p-4 mb-5 <?= $style ?> border rounded-lg flex items-center opacity-0 translate-y-[-50px] z-50" id="flashAlert">
        <i class="fa-solid <?= $icon ?> mr-2"></i>
        <?= $message ?>
    </div>

    <script>
        const alertEl = document.getElementById('flashAlert');
        if(alertEl){
            // Slide in dari atas ke bawah
            requestAnimationFrame(() => {
                alertEl.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                alertEl.style.opacity = '1';
                alertEl.style.transform = 'translateY(0)'; // jatuh ke posisi normal
            });

            // Auto-hide setelah 3 detik
            setTimeout(() => {
                alertEl.style.opacity = '0';
                alertEl.style.transform = 'translateY(-50px)'; // naik lagi ke atas
                setTimeout(() => alertEl.remove(), 500);
            }, 3000);
        }
    </script>
<?php
}
?>
