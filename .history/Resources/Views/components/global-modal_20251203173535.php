<?php
function alert($type, $message) {
    $styles = [
        'success' => 'bg-green-600/20 text-green-400 border-green-600',
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
    <div class="alert p-4 mb-5 <?= $style ?> border rounded-lg flex items-center" id="flashAlert">
        <i class="fa-solid <?= $icon ?> mr-2"></i>
        <?= $message ?>
    </div>

    <script>
        // Auto-hide setelah 3 detik
        setTimeout(() => {
            const alert = document.getElementById('flashAlert');
            if(alert){
                alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 500); // Hapus elemen setelah animasi
            }
        }, 3000);
    </script>
<?php
}
?>
