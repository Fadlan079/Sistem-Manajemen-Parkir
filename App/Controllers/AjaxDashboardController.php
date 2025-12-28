<?php

require_once __DIR__ . '/../Models/tiket.php';
require_once __DIR__ . '/../Models/transaksi.php';
require_once __DIR__ . '/../Models/user.php';
require_once __DIR__ . '/../../vendor/autoload.php';


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

    $pageTiket = isset($_GET['page_tiket']) ? (int)$_GET['page_tiket'] : 1;
    $pageTiket = max(1, $pageTiket);
    $offsetTiket = ($pageTiket - 1) * $limit;   

    $listTiket = $this->modelTiket->SelectTiketPagination($limit, $offsetTiket);
    $totalTiket = $this->modelTiket->countAllTiket();
    $totalPagesTiket = ceil($totalTiket / $limit);

    // ==== Data untuk chart ====
    $statusStat = $this->modelTiket->getStatStatus();
    $kendaraanStat = $this->modelTiket->getStatKendaraan();

    $total_parkir = $this->modelTiket->TotalParkir();

    $statusCount = ['masuk' => 0, 'keluar' => 0];
    foreach($statusStat as $row){
        $statusCount[$row['status']] = (int)$row['total'];
    }

    $statusCount['parkir'] = (int)$total_parkir;

    $kendaraanCount = ['motor' => 0, 'mobil' => 0];
    foreach($kendaraanStat as $row){
        $kendaraanCount[$row['jenis_kendaraan']] = (int)$row['total'];
    }

        ob_start();
        include __DIR__ . '/../../Resources/Views/Sections/table-tiket.php';
        $html = ob_get_clean();

        echo json_encode([
            'html' => $html,
            'statusCount' => $statusCount,
            'kendaraanCount' => $kendaraanCount
        ]);
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

    // ================= CHART DATA =================

    // Pendapatan per hari
    $pendapatanRaw = $this->modelTransaksi->getPendapatanHarian();
    $pendapatan = [
        'labels' => [],
        'data'   => []
    ];
    foreach ($pendapatanRaw as $row) {
        $pendapatan['labels'][] = $row['tanggal'];
        $pendapatan['data'][]   = (int)$row['total'];
    }

    // Jumlah transaksi per hari
    $trxHarianRaw = $this->modelTransaksi->getJumlahTransaksiHarian();
    $trxHarian = [
        'labels' => [],
        'data'   => []
    ];
    foreach ($trxHarianRaw as $row) {
        $trxHarian['labels'][] = $row['tanggal'];
        $trxHarian['data'][]   = (int)$row['total'];
    }

    // Status transaksi
    $statusRaw = $this->modelTransaksi->getStatStatus();
    $statusCount = ['paid' => 0, 'pending' => 0];
    foreach ($statusRaw as $row) {
        $statusCount[$row['status']] = (int)$row['total'];
    }

    // Metode pembayaran
    $metodeRaw = $this->modelTransaksi->getStatMetode();
    $metodeCount = [];
    foreach ($metodeRaw as $row) {
        $metodeCount[$row['metode']] = (int)$row['total'];
    }

    // Nominal
    $nominalRaw = $this->modelTransaksi->getStatNominal();
    $nominalCount = [];
    foreach ($nominalRaw as $row) {
        $nominalCount[$row['jumlah_bayar']] = (int)$row['total'];
    }

    // ================= HTML =================
    ob_start();
    include __DIR__ . '/../../Resources/Views/Sections/table-transaksi.php';
    $html = ob_get_clean();

    echo json_encode([
        'html' => $html,
        'pendapatan' => $pendapatan,
        'trxHarian' => $trxHarian,
        'statusCount' => $statusCount,
        'metodeCount' => $metodeCount,
        'nominalCount' => $nominalCount
    ]);
}


    // ================= USER =================
// ================= USER =================
public function user() {

    if ($_SESSION['user']['role'] !== 'admin') {
        echo json_encode([
            'html' => "<div class='text-red-400 text-center py-10'>Akses ditolak</div>"
        ]);
        return;
    }

    $limit = 5;

    $pageUser = isset($_GET['page_user']) ? (int)$_GET['page_user'] : 1;
    $pageUser = max(1, $pageUser);
    $offsetUser = ($pageUser - 1) * $limit;

    $listUser = $this->modelUser->Select($limit, $offsetUser);
    $totalUser = $this->modelUser->countUser();
    $totalPagesUser = ceil($totalUser / $limit);

    // ================= CHART DATA =================

    // Role
    $roleRaw = $this->modelUser->getStatRole();
    $roleCount = [];
    foreach ($roleRaw as $row) {
        $roleCount[$row['role']] = (int)$row['total'];
    }

    // Gender
    $genderRaw = $this->modelUser->getStatGender();
    $genderCount = [
        'L' => 0,
        'P' => 0
    ];
    foreach ($genderRaw as $row) {
        $genderCount[$row['gender']] = (int)$row['total'];
    }

    // Verifikasi
    $verifRaw = $this->modelUser->getStatVerifikasi();
    $verifCount = [
        'sudah' => 0,
        'belum' => 0
    ];
    foreach ($verifRaw as $row) {
        $verifCount[$row['status']] = (int)$row['total'];
    }

    // Pertumbuhan user
    $userHarianRaw = $this->modelUser->getUserHarian();
    $userHarian = [
        'labels' => [],
        'data'   => []
    ];
    foreach ($userHarianRaw as $row) {
        $userHarian['labels'][] = $row['tanggal'];
        $userHarian['data'][]   = (int)$row['total'];
    }

    // ================= HTML =================
    ob_start();
    include __DIR__ . '/../../Resources/Views/Sections/table-user.php';
    $html = ob_get_clean();

    echo json_encode([
        'html' => $html,
        'roleCount'   => $roleCount,
        'genderCount' => $genderCount,
        'verifCount'  => $verifCount,
        'userHarian'  => $userHarian
    ]);
}


}