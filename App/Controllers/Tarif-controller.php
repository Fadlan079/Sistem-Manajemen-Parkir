<?php 
require_once __DIR__ . "/../Models/tarif-parkir.php"; 

class TARIFController{
    private $modelTarif; 

    public function __construct() { 
        $this->modelTarif = new TarifParkir(); 
    } 

    public function ManageTarif() { 
        $current = 'manage-tarif'; 
        $listTarif = $this->modelTarif->SelectTarif(); 
        include __DIR__ . "/../../Resources/Views/Pages/manage-tarif.php"; 
    } 

    public function deleteTarif($id) {
        header('Content-Type: application/json');

        if (!$id) {
            echo json_encode([
                'status' => 'error',
                'msg' => 'ID tarif tidak valid'
            ]);
            exit;
        }

        $delete = $this->modelTarif->DeleteTarif($id);

        echo json_encode([
            'status' => $delete ? 'success' : 'error',
            'msg' => $delete
                ? 'Tarif berhasil dihapus'
                : 'Gagal menghapus tarif'
        ]);
        exit;
    }
    
    public function ShowInsertTarif() { 
        include __DIR__ . "/../../Resources/Views/components/Form/form-tambah-tarif.php"; 
    } 

    public function storeInsertTarif() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'status' => false,
                'message' => 'Invalid request'
            ]);
            exit;
        }

        $jenis_kendaraan = $_POST['jenis_kendaraan'] ?? '';
        $harga_flat = (int) ($_POST['harga_flat'] ?? 0);

        if ($jenis_kendaraan === '' || $harga_flat <= 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Data tidak valid'
            ]);
            exit;
        }

        $insert = $this->modelTarif->InsertTarif($jenis_kendaraan, $harga_flat);

        echo json_encode([
            'status' => $insert ? true : false,
            'message' => $insert ? 'Tarif berhasil disimpan' : 'Gagal menyimpan tarif'
        ]);
    }

    public function editTarif($id_tarif) { 
        $tarif = $this->modelTarif->getById($id_tarif); 
        include __DIR__ . "/../../Resources/Views/components/Form/edit-tarif.php"; 
    } 

    public function UpdateTarif() {
        header('Content-Type: application/json');

        $id_tarif = $_POST['id_tarif'] ?? null;
        $jenis_kendaraan = $_POST['jenis_kendaraan'] ?? '';
        $harga_flat = (int) ($_POST['harga_flat'] ?? 0);

        if (!$id_tarif || $jenis_kendaraan === '' || $harga_flat <= 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Data tidak valid'
            ]);
            exit;
        }

        $update = $this->modelTarif->UpdateTarif(
            $id_tarif,
            $jenis_kendaraan,
            $harga_flat
        );

        echo json_encode([
            'status' => $update ? true : false,
            'message' => $update ? 'Tarif berhasil diupdate' : 'Gagal update tarif'
        ]);
    }
}