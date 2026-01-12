<?php 
require_once __DIR__ . "/../Models/user.php"; 
require_once __DIR__ . "/../Models/tiket.php"; 
require_once __DIR__ . "/../Models/transaksi.php"; 

class DASHBOARDController { 
    private $modelUser; 
    private $modelTiket; 
    private $modelTransaksi; 

    public function __construct() { 
        $this->modelUser = new User(); 
        $this->modelTiket = new Tiket(); 
        $this->modelTransaksi = new Transaksi(); 
    } 

    public function index() { 
        include __DIR__ . "/../../Resources/Views/index.php"; 
    } 

    public function dashboard(){
                $current = 'index'; 
        $totalbayar = $this->modelTransaksi->TotalBayar(); 
        $TotalUser = $this->modelUser->countuser(); 
        $Totalmasuk = $this->modelTiket->countTiketMasuk(); 
        $Totalkeluar = $this->modelTiket->countTiketKeluar(); 
        $Totaltransaksi = $this->modelTransaksi->countTransaksi(); 
        $statusStat = $this->modelTiket->getStatStatus(); 
        $kendaraanStat = $this->modelTiket->getStatKendaraan(); 
        $totalPendapatan = $this->modelTiket->getTotalPendapatan(); 
        $pendapatanPerHari = $this->modelTiket->getPendapatanPerHari(); 
        $total_parkir = $this->modelTiket->TotalParkir();

        $statusCount = [ 'masuk' => 0, 'keluar' => 0 ]; 
        foreach ($statusStat as $row) { 
            $statusCount[$row['status']] = (int)$row['total']; 
        } 

        $kendaraanCount = [ 'motor' => 0, 'mobil' => 0 ]; 
        foreach ($kendaraanStat as $row) { 
            $kendaraanCount[$row['jenis_kendaraan']] = (int)$row['total']; 
        } 
        include __DIR__ . "/../../Resources/Views/Pages/dashboard.php";
    }
} 