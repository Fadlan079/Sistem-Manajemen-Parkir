<?php

require_once __DIR__ . '/../Models/tiket.php';
require_once __DIR__ . '/../Models/transaksi.php';
require_once __DIR__ . '/../Models/user.php';

class AjaxDashboardController {

    private $modelUser;
    private $modelTiket;
    private $modelTransaksi;

    public function __construct() {
        $this->modelUser = new User();
        $this->modelTiket = new Tiket();
        $this->modelTransaksi = new Transaksi();
    }

    // ================= TIKET =================
    public function tiket() {

        $limit = 5;

        // SAMA PERSIS kaya dashboard
        $pageTiket = isset($_GET['page_tiket']) ? (int)$_GET['page_tiket'] : 1;
        $pageTiket = max(1, $pageTiket);
        $offsetTiket = ($pageTiket - 1) * $limit;

        // METHOD SAMA
        $listTiket = $this->modelTiket->SelectTiketPagination($limit, $offsetTiket);
        $totalTiket = $this->modelTiket->countAllTiket();
        $totalPagesTiket = ceil($totalTiket / $limit);

        include __DIR__ . '/../../Resources/Views/Sections/table-tiket.php';
    }

    // ================= TRANSAKSI =================
    public function transaksi() {

        $limit = 5;

        $pageTrx = isset($_GET['page_trx']) ? (int)$_GET['page_trx'] : 1;
        $pageTrx = max(1, $pageTrx);
        $offsetTrx = ($pageTrx - 1) * $limit;

        $listTransaksi = $this->modelTransaksi->SelectPagination($limit, $offsetTrx);
        $totalTrx = $this->modelTransaksi->countTransaksi();
        $totalPagesTrx = ceil($totalTrx / $limit);

        include __DIR__ . '/../../Resources/Views/Sections/table-transaksi.php';
    }

    // ================= USER =================
    public function user() {

        if ($_SESSION['user']['role'] !== 'admin') {
            echo "<div class='text-red-400 text-center py-10'>Akses ditolak</div>";
            return;
        }

        $limit = 5;

        $pageUser = isset($_GET['page_user']) ? (int)$_GET['page_user'] : 1;
        $pageUser = max(1, $pageUser);
        $offsetUser = ($pageUser - 1) * $limit;

        $listUser = $this->modelUser->Select($limit, $offsetUser);
        $totalUser = $this->modelUser->countUser();
        $totalPagesUser = ceil($totalUser / $limit);

        // kalau di table-user kamu pakai $p
        $p = ($pageUser - 1) * $limit + 1;

        include __DIR__ . '/../../Resources/Views/Sections/table-user.php';
    }
}
