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
    <div class="p-4 mb-5 <?= $style ?> border rounded-lg">
        <i class="fa-solid <?= $icon ?> mr-2"></i>
        <?= $message ?>
    </div>
<?php
}
?>