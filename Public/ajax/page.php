<?php
session_start();
require_once __DIR__ . '/../../App/Controllers/page-controller.php';

$page = $_GET['page'] ?? 'dashboard';

$controller = new PageController();

switch ($page) {
    case 'dashboard':
        $controller->dashboard();
        break;

    case 'manage-user':
        $controller->manageUser();
        break;

    case 'manage-tarif':
        $controller->manageTarif();
        break;

    case 'tiket-masuk':
        $controller->tiketMasuk();
        break;

    case 'tiket-keluar':
        $controller->tiketKeluar();
        break;


    default:
        echo "<div class='text-center text-gray-400'>Page tidak ditemukan</div>";
}
