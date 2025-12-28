<?php 
require_once __DIR__ . "/../Models/tiket.php"; 
require_once __DIR__ . "/../Models/tarif-parkir.php";
require_once __DIR__ . "/../Models/transaksi.php"; 

class TIKETController{
    private $modelTiket; 
    private $modelTarif;
    private $modelTransaksi;

    public function __construct() { 
        $this->modelTiket = new Tiket();
        $this->modelTarif = new TarifParkir();  
        $this->modelTransaksi = new Transaksi();  
    } 

    public function ShowTiketMasuk() { 
        $data_tarif = $this->modelTarif->SelectTarif(); 
        include __DIR__ . "/../../Resources/Views/components/Form/tiket-masuk.php"; 
    } 

    public function StoreTiketMasuk() { 
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return; 

        $nomor_polisi = trim($_POST['nomor_polisi'] ?? ''); 
        $jenis_kendaraan = $_POST['jenis_kendaraan']; 
        $id_tarif = $_POST['id_tarif']; 
        $tgl_masuk = date("Y-m-d H:i:s"); 
        $id_petugas_masuk = $_SESSION['user']['id_user']; 
        $status = "masuk"; 

        if (empty($nomor_polisi)) { 
            $_SESSION['flash'] = [ 'type' => 'error', 'msg' => 'Nomor polisi wajib diisi' ]; 
            header("Location: ?action=tiket-masuk"); 
            exit; 
        } 

        $insert = $this->modelTiket->InsertTiketMasuk($nomor_polisi, $jenis_kendaraan, $id_tarif, $tgl_masuk, $id_petugas_masuk, $status); 

        if ($insert) { 
            $lastId = $this->modelTiket->lastInsertId(); 
            header("Location: ?action=preview-tiket&id=$lastId"); 
            exit; 
        } else { 
            $_SESSION['flash'] = [ 'type' => 'error', 'msg' => 'Gagal Membuat Tiket' ]; 
            header("Location: ?action=tiket-masuk"); 
            exit; 
        } 
    } 

    public function PreviewTiket() { 
        $id = $_GET['id']; 
        $tiket = $this->modelTiket->GetTiketById($id); 
        include __DIR__ . '/../../Resources/Views/Tiket/preview-tiket.php'; 
    } 

    public function HapusTiket() { 
        $id = $_GET['id']; 
        $this->modelTiket->DeleteTiket($id); 
        $_SESSION['flash'] = [ 'type' => 'error', 'msg' => 'Tiket dibatalkan.' ]; 
        header("Location: ?action=tiket-masuk"); 
    } 

    public function PrintTiket() { 
        if (!isset($_GET['id'])) { 
            echo "ID tidak ditemukan"; 
            return; 
        } 

        $id = $_GET['id']; 
        $tiket = $this->modelTiket->getTiketById($id); 

        if (!$tiket) { 
            echo "Tiket tidak ditemukan"; 
            return; 
        } 

        include __DIR__ . "/../../Resources/Views/Tiket/tiket.php"; 
    } 

    public function GetTiketByBarcode() { 
        header("Content-Type: application/json"); 
        if (!isset($_GET['barcode'])) { 
            echo json_encode(['status' => 'error', 'message' => 'Barcode tidak dikirim']); 
            return; 
        } 

        $barcode = $_GET['barcode']; 
        $data = $this->modelTiket->GetTiketByBarcode($barcode); 

        if ($data) { 
            echo json_encode(['status' => 'success', 'data' => $data]); 
        } else { 
            echo json_encode(['status' => 'not_found']); 
        } 
    } 

    public function ShowTiketKeluar() { 
        include __DIR__ . "/../../Resources/Views/components/Form/tiket-keluar.php"; 
    } 

    public function UpdateTiketKeluar() { 
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return; 

        $barcode = trim($_POST['barcode'] ?? ''); 
        $total_harga = intval(str_replace('.', '', $_POST['total_harga'] ?? 0)); 
        $metode = 'cash'; 

        if ($barcode === '' || $total_harga <= 0) { 
            $_SESSION['flash'] = [ 'type' => 'error', 'msg' => 'Data tidak valid! Scan ulang barcode.' ]; 
            header("Location: ?action=tiket-keluar"); 
            exit; 
        } 

        $tgl_keluar = date("Y-m-d H:i:s"); 
        $id_petugas_keluar = $_SESSION['user']['id_user']; 
        $tiket = $this->modelTiket->GetTiketAktifByBarcode($barcode); 

        if (!$tiket) { 
            $_SESSION['flash'] = [ 'type' => 'error', 'msg' => 'Tiket tidak ditemukan / sudah keluar!' ]; 
            header("Location: ?action=tiket-keluar"); 
            exit; 
        } 

        $update = $this->modelTiket->UpdateTiketKeluar($barcode, $tgl_keluar, $id_petugas_keluar, $total_harga); 

        if ($update <= 0) { 
            $_SESSION['flash'] = [ 'type' => 'error', 'msg' => 'Gagal update tiket!' ]; 
            header("Location: ?action=tiket-keluar"); 
            exit; 
        } 

        $this->modelTransaksi->InsertTransaksiAuto($tiket['id_tiket'], $total_harga, $metode); 
        $_SESSION['flash'] = [ 'type' => 'success', 'msg' => 'Tiket selesai & pembayaran berhasil!' ]; 
        header("Location: ?action=tiket-keluar"); 
        exit; 
    } 
}
?>