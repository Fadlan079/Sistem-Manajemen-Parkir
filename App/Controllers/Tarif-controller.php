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
        $this->modelTarif->DeleteTarif($id); 
        header("Location:?action=manage-tarif"); 
    } 

    public function ShowInsertTarif() { 
        include __DIR__ . "/../../Resources/Views/components/Form/form-tambah-tarif.php"; 
    } 

    public function storeInsertTarif() { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $jenis_kendaraan = $_POST['jenis_kendaraan'] ?? ''; 
            $harga_flat = $_POST['harga_flat'] ?? 0; 

            if (empty($jenis_kendaraan) || $harga_flat <= 0) { 
                echo "<script>alert('Data tidak valid!'); window.history.back();</script>"; 
                exit; 
            } 

            $insert = $this->modelTarif->InsertTarif($jenis_kendaraan, $harga_flat); 

            if ($insert) { 
                echo "<script>alert('Tarif berhasil disimpan!'); window.location='?action=manage-tarif';</script>"; 
            } else { 
                echo "<script>alert('Gagal menyimpan tarif!'); window.history.back();</script>"; 
            } 
        } 
    } 

    public function editTarif($id_tarif) { 
        $tarif = $this->modelTarif->getById($id_tarif); 
        include __DIR__ . "/../../Resources/Views/components/Form/edit-tarif.php"; 
    } 

    public function UpdateTarif() { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
            $id_tarif = $_POST['id_tarif']; 
            $jenis_kendaraan = $_POST['jenis_kendaraan']; 
            $harga_flat = $_POST['harga_flat']; 

            if (empty($jenis_kendaraan) || $harga_flat <= 0) { 
                $_SESSION['error'] = "Data tidak valid!"; 
                header("Location: ?action=edit-tarif&id=".$id_tarif); 
                exit; 
            } 

            $update = $this->modelTarif->UpdateTarif($id_tarif, $jenis_kendaraan, $harga_flat); 

            if ($update) { 
                $_SESSION['success'] = "Tarif berhasil diupdate!"; 
                header("Location: ?action=manage-tarif"); 
                exit; 
            } else { 
                $_SESSION['error'] = "Gagal mengupdate tarif!"; 
                header("Location: ?action=edit-tarif&id=".$id_tarif); 
                exit; 
            } 
        } 
    } 
}
?>