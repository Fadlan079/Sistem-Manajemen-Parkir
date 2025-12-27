<?php
session_start();

require_once __DIR__ . '/../../App/Controllers/AjaxDashboardController.php';

$type = $_GET['type'] ?? '';

$controller = new AjaxDashboardController();

switch ($type) {
    case 'tiket':
        $controller->tiket();
        break;

    case 'transaksi':
        $controller->transaksi();
        break;

    case 'user':
        $controller->user();
        break;

    default:
        echo "<div class='text-gray-400 text-center py-10'>Data tidak ditemukan</div>";
}