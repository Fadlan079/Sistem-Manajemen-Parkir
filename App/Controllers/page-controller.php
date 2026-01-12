<?php
require_once __DIR__ . "/User-controller.php";
require_once __DIR__ . "/Tarif-controller.php";
require_once __DIR__ . "/Transaksi-controller.php";
require_once __DIR__ . "/Tiket-controller.php";
require_once __DIR__ . "/dashboard-controller.php";
require_once __DIR__ . "/AjaxDashboardController.php";

class PageController {

    public function dashboard() {
        $dashController = new DASHBOARDController();
        $ajaxdashController = new AjaxDashboardController();
        $dashController->dashboard();
    }

    public function manageUser() {
        $userController = new USERController();
        $userController->ManageUser();
    }

    public function manageTarif() {
        $tarifController = new TarifController();
        $tarifController->ManageTarif();
    }

    public function tiketMasuk() {
        $tiketController = new TIKETController();
        $tiketController->ShowTiketMasuk();
    }

    public function tiketKeluar() {
        $tiketController = new TIKETController();
        $tiketController->ShowTiketKeluar();
    }
}