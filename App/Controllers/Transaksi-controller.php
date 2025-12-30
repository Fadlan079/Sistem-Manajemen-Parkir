<?php 
require_once __DIR__ . "/../Models/user.php"; 
require_once __DIR__ . "/../Models/transaksi.php"; 

class TRANSAKSIController{
    private $modelTiket; 
    private $modelTransaksi; 

    public function __construct() { 
        $this->modelTiket = new Tiket(); 
        $this->modelTransaksi = new Transaksi(); 
    } 

    public function ShowInsertTransaksi() { 
        $allTiket = $this->modelTiket->SelectTiketMasukSaja(); 
        $listTiket = []; 

        foreach($allTiket as $tiket){ 
            if(!$this->modelTransaksi->isTiketPaid($tiket['id_tiket'])){ 
                $listTiket[] = $tiket; 
            } 
        } 

        include __DIR__ . "/../../Resources/Views/components/Form/form-tambah-transaksi.php"; 
    } 

    public function StoreTransaksi() { 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
            $id_tiket = $_POST['id_tiket'] ?? ''; 
            $jumlah_bayar = $_POST['jumlah_bayar'] ?? 0; 
            $metode = $_POST['metode'] ?? ''; 

            if(empty($id_tiket) || $jumlah_bayar <= 0 || empty($metode)){ 
                $_SESSION['error'] = "Data transaksi tidak valid!"; 
                header("Location: ?action=transaksi"); 
                exit; 
            } 

            $insert = $this->modelTransaksi->InsertTransaksi($id_tiket, $jumlah_bayar, $metode); 

            if($insert){ 
                $_SESSION['success'] = "Transaksi berhasil ditambahkan!"; 
                header("Location: ?action=transaksi"); 
                exit; 
            } else { 
                $_SESSION['error'] = "Gagal menambahkan transaksi!"; 
                header("Location: ?action=transaksi"); 
                exit; 
            } 
        } 
    }    
}